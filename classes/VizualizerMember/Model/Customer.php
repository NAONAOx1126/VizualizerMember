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
}
