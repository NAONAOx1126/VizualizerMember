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
 * 顧客の詳細データを取得する。
 *
 * @package VizualizerMember
 * @author Naohisa Minagawa <info@vizualizer.jp>
 */
class VizualizerMember_Module_Customer_Detail extends Vizualizer_Plugin_Module_Detail
{

    function execute($params)
    {
        $post = Vizualizer::request();
        if (!($post["customer_id"] > 0)) {
            // 顧客IDが取得できない場合は電話番号から顧客IDを取得
            if (!empty($post["tel"])) {
                // サイトデータを取得する。
                $loader = new Vizualizer_Plugin("Member");
                $model = $loader->loadModel("Customer");
                $model->findByTel($post["tel"]);
                if($model->customer_id > 0){
                    $post->set("customer_id", $model->customer_id);
                }
            }
        }
        $this->executeImpl("Member", "Customer", $post["customer_id"], $params->get("result", "customer"));
    }
}
