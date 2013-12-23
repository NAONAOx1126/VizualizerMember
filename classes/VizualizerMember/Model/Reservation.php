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
 * 予約のモデルです。
 *
 * @package VizualizerMember
 * @author Naohisa Minagawa <info@vizualizer.jp>
 */
class VizualizerMember_Model_Reservation extends Vizualizer_Plugin_Model
{

    /**
     * コンストラクタ
     *
     * @param $values モデルに初期設定する値
     */
    public function __construct($values = array())
    {
        $loader = new Vizualizer_Plugin("member");
        parent::__construct($loader->loadTable("Reservations"), $values);
    }

    /**
     * 主キーでデータを取得する。
     *
     * @param $reservation_id 予約ID
     */
    public function findByPrimaryKey($reservation_id)
    {
        $this->findBy(array("reservation_id" => $reservation_id));
    }

    /**
     * 予約コードでデータを取得する。
     *
     * @param $reservation_code 予約ID
     */
    public function findByReservationCode($reservation_code)
    {
        $this->findBy(array("reservation_code" => $reservation_code));
    }

    public function findAllByCustomerId($customer_id, $order = "", $reverse = false)
    {
        return $this->findAllBy(array("customer_id" => $customer_id), $order, $reverse);
    }

    /**
     * 予約に紐づく組織を取得
     *
     * @return 組織
     */
    public function company()
    {
        $loader = new Vizualizer_Plugin("admin");
        $company = $loader->loadModel("Company");
        $company->findByPrimaryKey($this->company_id);
        return $company;
    }

    /**
     * 予約に紐づくオペレータを取得
     *
     * @return オペレータ
     */
    public function operator()
    {
        $loader = new Vizualizer_Plugin("admin");
        $operator = $loader->loadModel("CompanyOperator");
        $operator->findByPrimaryKey($this->operator_id);
        return $operator;
    }

    /**
     * 予約に紐づくスケジュールを取得
     *
     * @return オペレータ
     */
    public function schedule()
    {
        $loader = new Vizualizer_Plugin("admin");
        $schedule = $loader->loadModel("OperatorSchedule");
        $schedule->findBy(array("operator_id" => $this->operator_id, "le:start_time" => $this->start_time, "ge:end_time" => $this->start_time));
        return $schedule;
    }

    /**
     * 予約に紐づく顧客を取得
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

    /**
     * 予約に紐づくステータスを取得
     *
     * @return 顧客
     */
    public function status()
    {
        $loader = new Vizualizer_Plugin("member");
        $status = $loader->loadModel("ReservationStatus");
        $status->findByPrimaryKey($this->reservation_status_id);
        return $status;
    }


    public function getTargets($prefix){
        $start = strtotime($this->start_time);
        $now = $start;
        $result = array();
        while($now < strtotime($this->end_time)){
            $id = $prefix."-".$this->operator_id."-";
            if(date("Ymd", $start) < date("Ymd", $now)){
                $id .= (date("H", $now) + 24).date("i", $now);
            }else{
                $id .= date("Hi", $now);
            }
            $result[$id] = $this;
            $now += 1800;
        }
        return $result;
    }
}
