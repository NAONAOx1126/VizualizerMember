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
 * 会員のログイン処理を実行する。
 *
 * @package VizualizerMember
 * @author Naohisa Minagawa <info@vizualizer.jp>
 */
class VizualizerMember_Module_Login extends Vizualizer_Plugin_Module
{

    function execute($params)
    {
        $loader = new Vizualizer_Plugin("Member");
        if (Vizualizer_Session::get(VizualizerMember::SESSION_KEY) === null) {
            $post = Vizualizer::request();
            if (isset($post["login"])) {
                // 顧客モデルを取得する。
                $customer = $loader->loadModel("Customer");

                if (empty($post["email"])) {
                    Vizualizer_Logger::writeDebug("メールアドレスが入力されていません。");
                    throw new Vizualizer_Exception_Invalid("login", "メールアドレスが入力されていません。");
                }

                // 渡されたログインIDでレコードを取得する。
                $customer->findByEmail($post["email"]);

                // ログインIDに該当するアカウントが無い場合
                Vizualizer_Logger::writeDebug("Try Login AS :\r\n" . var_export($customer->toArray(), true));
                if (!($customer->customer_id > 0)) {
                    Vizualizer_Logger::writeDebug("ログインIDに該当するアカウントがありません。");
                    throw new Vizualizer_Exception_Invalid("login", "ログイン情報が正しくありません。");
                }

                // 保存されたパスワードと一致するか調べる。
                if ($customer->password != $post["password"]) {
                    Vizualizer_Logger::writeDebug("パスワードが一致しません");
                    throw new Vizualizer_Exception_Invalid("login", "ログイン情報が正しくありません。");
                }

                // 取得されたアカウントの状態を調べる。
                if ($customer->active_flg != "1") {
                    Vizualizer_Logger::writeDebug("アカウントがアクティブではありません。");
                    throw new Vizualizer_Exception_Invalid("login", "ログイン情報が正しくありません。");
                }

                // 取得されたアカウントの状態を調べる。
                if ($customer->delete_flg == "1") {
                    Vizualizer_Logger::writeDebug("アカウントが削除されています。");
                    throw new Vizualizer_Exception_Invalid("login", "ログイン情報が正しくありません。");
                }

                // ログインに成功した場合には管理者情報をセッションに格納する。
                Vizualizer_Session::set(VizualizerMember::SESSION_KEY, $customer->toArray());

                // 登録に使用したキーを無効化
                $this->removeInput("login");

                // パラメータに自動遷移先が割り当てられている場合はリダイレクト
                $this->reload();
            }
        }

        // ユーザーモデルを復元する。
        $customer = $loader->loadModel("Customer", Vizualizer_Session::get(VizualizerMember::SESSION_KEY));
        if ($customer->customer_id > 0) {
            $attr = Vizualizer::attr();
            $attr[VizualizerMember::KEY] = $customer;

            // パラメータに自動遷移先が割り当てられている場合はリダイレクト
            if ($params->check("redirect")) {
                $this->redirectInside($params->check("redirect"));
            }
        } else {
            Vizualizer_Logger::writeDebug("認証されていません。");
            throw new Vizualizer_Exception_Invalid("", "");
        }
    }
}
