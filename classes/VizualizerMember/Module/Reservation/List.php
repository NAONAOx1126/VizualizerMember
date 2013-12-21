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
 * 予約のリストを取得する。
 *
 * @package VizualizerMember
 * @author Naohisa Minagawa <info@vizualizer.jp>
 */
class VizualizerMember_Module_Reservation_List extends Vizualizer_Plugin_Module_List
{

    function execute($params)
    {
        // 指定日と前後の日付を設定
        $post = Vizualizer::request();
        $search = $post["search"];
        if (isset($search["back:start_time"])) {
            $attr = Vizualizer::attr();
            $attr["thisDay"] = date("Y-m-d", strtotime($search["back:start_time"]));
            $attr["prevDay"] = date("Y-m-d", strtotime($search["back:start_time"]) - 24 * 3600);
            $attr["nextDay"] = date("Y-m-d", strtotime($search["back:start_time"]) + 24 * 3600);
        }

        $this->executeImpl($params, "Member", "Reservation", $params->get("result", "reservations"));
    }
}
