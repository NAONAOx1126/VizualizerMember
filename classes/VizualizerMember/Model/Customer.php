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
 * 顧客のモデルです。
 *
 * @package VizualizerMember
 * @author Naohisa Minagawa <info@vizualizer.jp>
 */
class VizualizerMember_Model_Customer extends Vizualizer_Plugin_Model
{

    /**
     * コンストラクタ
     *
     * @param $values モデルに初期設定する値
     */
    public function __construct($values = array())
    {
        $loader = new Vizualizer_Plugin("member");
        parent::__construct($loader->loadTable("Customers"), $values);
    }

    /**
     * 主キーでデータを取得する。
     *
     * @param $customer_id 顧客ID
     */
    public function findByPrimaryKey($customer_id)
    {
        $this->findBy(array("customer_id" => $customer_id));
    }

    /**
     * メールアドレスでデータを取得する。
     *
     * @param $email メールアドレス
     */
    public function findByEmail($email)
    {
        $this->findBy(array("email" => $email));
    }

    /**
     * 電話番号でデータを取得する。
     *
     * @param $tel 電話番号
     */
    public function findByTel($tel)
    {
        $this->findBy(array("tel1+tel2+tel3" => $tel));
    }

    /**
     * 顧客ステータスを取得する。
     *
     * @return 顧客ステータス
     */
    public function status()
    {
        $loader = new Vizualizer_Plugin("member");
        $customerStatus = $loader->loadModel("CustomerStatus");
        $customerStatus->findByPrimaryKey($this->customer_status_id);
        return $customerStatus;
    }

    /**
     * 顧客種別を取得する。
     *
     * @return 顧客種別
     */
    public function type()
    {
        $loader = new Vizualizer_Plugin("member");
        $customerType = $loader->loadModel("CustomerType");
        $customerType->findByPrimaryKey($this->customer_status_id);
        return $customerType;
    }

    public function reservations($order = "", $reverse = false)
    {
        $loader = new Vizualizer_Plugin("member");
        $reservation = $loader->loadModel("Reservation");
        $reservations = $reservation->findAllByCustomerId($this->customer_id, $order, $reverse);
        return $reservations;
    }

    public function save()
    {
        $register = false;
        if (!array_key_exists("customer_id", $this->values_org) && !array_key_exists("customer_id", $this->values)) {
            $register = true;
        }
        parent::save();
        if($register && Vizualizer_Configure::exists("registermail_title") && Vizualizer_Configure::exists("registermail_template")){
            // メールの内容を作成
            $title = Vizualizer_Configure::get("registermail_title");
            $templateName = Vizualizer_Configure::get("registermail_template");
            $attr = Vizualizer::attr();
            $template = $attr["template"];
            if(!empty($template)){
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
                $mail->setTo($this->email);
                $mail->setSubject($title);
                $mail->addBody($body);
                $mail->send();

                // ショップにメール送信
                $mail = new Vizualizer_Sendmail();
                $mail->setFrom($this->email);
                $mail->setTo($company->email);
                $mail->setSubject($title);
                $mail->addBody($body);
                $mail->send();
            }
        }
    }
}
