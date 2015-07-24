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
 * 半角英数かどうかのチェックを行う。
 *
 * @package Vizualizer
 * @author Naohisa Minagawa <info@vizualizer.jp>
 */
class VizualizerMember_Module_Customer_Check_UniqueEmail extends Vizualizer_Plugin_Module
{

    /**
     * モジュールのエンドポイント
     */
    function execute($params)
    {
        $post = Vizualizer::request();

        $loader = new Vizualizer_Plugin("member");
        $customer = $loader->loadModel("Customer");
        $count = $customer->countBy(array("ne:customer_id" => $post["customer_id"], "email" => $post["email"]));
        if ($count > 0) {
            throw new Vizualizer_Exception_Invalid("email", "メールアドレス" . $params->get("suffix", "が重複しています。"));
        }
    }
}
