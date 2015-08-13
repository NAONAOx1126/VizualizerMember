<?php

/**
 * Copyright (C) 2012 Vizualizer All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author    Naohisa Minagawa <info@vizualizer.jp>
 * @copyright Copyright (c) 2010, Vizualizer
 * @license http://www.apache.org/licenses/LICENSE-2.0.html Apache License, Version 2.0
 * @since PHP 5.3
 * @version   1.0.0
 */

/**
 * リマインダーエントリーのデータを照合し、パスワードを更新する。
 *
 * @package VizualizerMember
 * @author Naohisa Minagawa <info@vizualizer.jp>
 */
class VizualizerMember_Module_Reminder_Confirm extends Vizualizer_Plugin_Module
{

    function execute($params)
    {
        // 予約ステータスIDが未設定の場合で、パラメータにステータスコードが渡っている場合はステータスIDを取得
        $post = Vizualizer::request();

        // リマインダーデータを取得する。
        if($post["reminder_key"] > 0){
            $loader = new Vizualizer_Plugin("Member");
            $model = $loader->loadModel("ReminderEntry");
            $model->findByReminderKey($post["reminder_key"]);
            if($model->reminder_entry_id > 0){
                // データを取得できた場合は、認証キーを照合
                if($model->auth_key === $post["auth_key"]){
                    $connection = Vizualizer_Database_Factory::begin("member");
                    try {
                        // 認証キーが一致した場合は、パスワードを更新
                        if(!empty($post["password"])){
                            $customer = $model->customer();
                            $customer->password = $post["password"];
                            $customer->save();
                        }
                        // 更新後、リマインダーデータを削除
                        $model->delete();
                        // エラーが無かった場合、処理をコミットする。
                        Vizualizer_Database_Factory::commit($connection);

                        // リセットメールの内容を作成
                        $title = Vizualizer_Configure::get("reset_password_mail_title");
                        $templateName = Vizualizer_Configure::get("reset_password_mail_template");
                        $attr = Vizualizer::attr();
                        $template = $attr["template"];
                        if(!empty($template)){
                            $customer = $model->customer();
                            $template->assign("reminder", $model->toArray());
                            $body = $template->fetch($templateName.".txt");

                            // ショップの情報を取得
                            $loader = new Vizualizer_Plugin("admin");
                            $company = $loader->loadModel("Company");
                            if (Vizualizer_Configure::get("delegate_company") > 0) {
                                $company->findBy(array("company_id" => Vizualizer_Configure::get("delegate_company")));
                            } else {
                                $company->findBy(array());
                            }

                            // 購入者にメール送信
                            $mail = new Vizualizer_Sendmail();
                            $mail->setFrom($company->email);
                            $mail->setTo($customer->email);
                            $mail->setSubject($title);
                            $mail->addBody($body);
                            $mail->send();
                        }
                    } catch (Exception $e) {
                        Vizualizer_Database_Factory::rollback($connection);
                        throw new Vizualizer_Exception_Database($e);
                    }
                }
            }
        }
    }
}
