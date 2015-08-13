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
 * リマインダーエントリーのモデルです。
 *
 * @package VizualizerMember
 * @author Naohisa Minagawa <info@vizualizer.jp>
 */
class VizualizerMember_Model_ReminderEntry extends Vizualizer_Plugin_Model
{

    /**
     * コンストラクタ
     *
     * @param $values モデルに初期設定する値
     */
    public function __construct($values = array())
    {
        $loader = new Vizualizer_Plugin("member");
        parent::__construct($loader->loadTable("ReminderEntries"), $values);
    }

    /**
     * 主キーでデータを取得する。
     *
     * @param $reminder_entry_id 顧客ID
     */
    public function findByPrimaryKey($reminder_entry_id)
    {
        $this->findBy(array("reminder_entry_id" => $reminder_entry_id));
    }

    /**
     * 顧客IDでデータを取得する。
     *
     * @param $customer_id 顧客ID
     */
    public function findAllByCustomerId($customer_id)
    {
        return $this->findAllBy(array("customer_id" => $customer_id));
    }

    /**
     * リマインダーキーでデータを取得する。
     *
     * @param $reminder_key リマインダーキー
     */
    public function findByReminderKey($reminder_key)
    {
        $this->findBy(array("reminder_key" => $reminder_key));
    }

    /**
     * 顧客を取得する。
     *
     * @return 顧客
     */
    public function customer()
    {
        $loader = new Vizualizer_Plugin("member");
        $customer = $loader->loadModel("Customer");
        $customer->findByPrimaryKey($this->customer_id);
        return $customer;
    }
}
