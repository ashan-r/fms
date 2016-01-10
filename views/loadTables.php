<?php

require_once '../config/dbc.php';
require_once '../class/database.php';
require_once '../class/systemSetting.php';
$dbClass = new database();
$system = new setting();

if (array_key_exists("table", $_POST)) {
    if ($_POST['table'] == 'maker_info') {
        //@Sachith : load sub category table by main category id
        $system->prepareSelectQueryForJSON("SELECT maker_id, maker_name, `desc`, maker_status 
        FROM maker WHERE maker.maker_status = 1");
    } else if ($_POST['table'] == 'c_customers_table') {
        //kitz
        $query = "SELECT
        customer.cus_id,
        customer.cus_name,
        customer.cus_inv_name,
        customer.cus_address,
        customer.cus_inv_address,
        customer.cus_phone1,
        customer.cus_phone2,
        customer.other_contact,
        customer.comments
        FROM `customer`
        WHERE
        customer.cus_status != 99";
        $system->prepareSelectQueryForJSON($query);
    } else if ($_POST['table'] == 'model_info') {
        $query = "SELECT
        maker_model.mod_id,
        maker_model.mod_name,
        maker_model.mod_options
        FROM
        maker_model
        WHERE
        maker_model.mod_status = 1 AND
        maker_model.maker_id = '{$_POST['maker_id']}'";
        $system->prepareSelectQueryForJSON($query);
    } else if ($_POST['table'] == 'load_sup_reg_tbl') {
        $system->prepareSelectQueryForJSON("SELECT
supplier.supp_id,
supplier.supp_code,
supplier.supp_name,
supplier.inv_name,
supplier.supp_address,
supplier.inv_address,
supplier.phone,
supplier.inv_phone,
supplier.supp_email,
supplier.web,
supplier.supp_fax
FROM
supplier
WHERE supplier.supp_status = '1'");
    } else if ($_POST['table'] == 'load_clearnce_tbl') {
      $rec_per_page = 15; // enter the same value in 'view_vehicle_tbl_paging'
        if (filter_var($_REQUEST["records"], FILTER_VALIDATE_INT)) {
            $rec_per_page = $_REQUEST["records"];
        }
        if (isset($_REQUEST["page"])) {
            $page = $_REQUEST["page"];
        } else {
            $page = 1;
        }
        $start_from = ($page - 1) * $rec_per_page;
        $query_p1 = "SELECT
                        vehicle.vh_id,
                        vehicle.vh_index_num,
                        vehicle.vh_code,
                        vehicle.vh_chassis_code,
                        vehicle.vh_chassis_num,
                        vehicle.engine_code,
                        vehicle.engine_num,
                        vehicle.engine_cc,
                        vehicle.auc_display_price,
                        vehicle.stock_location,
                        vehicle.stock_status,
                        maker_model.mod_name,
                        maker.maker_name,
                        coordinator.short_name,
                        vehicle.color_group,
                        vh_clearing.shipped_date,
                        vh_clearing.vessel,
                        vh_clearing.refunds,
                        vh_clearing.arrival_date,
                        vh_clearing.document_status
                        FROM
                        vehicle
                        INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
                        INNER JOIN maker ON maker_model.maker_id = maker.maker_id
                        LEFT JOIN coordinator ON vehicle.coordinator_id = coordinator.coordinator_id
                        INNER JOIN supplier ON vehicle.supp_id = supplier.supp_id
                        LEFT JOIN vh_clearing ON vh_clearing.vh_id = vehicle.vh_id
                        WHERE
                            vehicle.record_status = '1'
";

        if ($_POST['stock_status'] != 0) {
            $query_p1 = $query_p1 . " AND vehicle.stock_status = '{$_POST['stock_status']}'";
        }

        $query_p3 = " ORDER BY vehicle.vh_group ASC,vehicle.vh_index_num ASC LIMIT $start_from, $rec_per_page";
        if ($_POST['supp_id'] > 0) {
            $query_p2 = " AND supplier.supp_id = '{$_POST['supp_id']}'";
//            create_vehicle_viewlist($query_p1 . $query_p2 . $query_p3, $query_p1 . $query_p2);
            $system->prepareSelectQueryForJSON($query_p1 . $query_p2 . $query_p3);
        } else {
            $system->prepareSelectQueryForJSON($query_p1 . $query_p3);
        }


    } else if ($_POST['table'] == 'load_coordinator_tbl') {
        $system->prepareSelectQueryForJSON("SELECT
coordinator_id,
coordinator_name,
short_name,
phone,
category,phone2,email1,email2,address
FROM
coordinator
WHERE
coordinator.coordinator_status ='1' ");
    } else if ($_POST['table'] == 'load_view_order_tbl') {
        $order_status = $_POST['order_status'];
        $system->prepareSelectQueryForJSON("SELECT
cus_order.order_date,
cus_order.pay_comments,
cus_order.description,
cus_order.gb,
cus_order.pay_advance,
cus_order.max_price,
cus_order.order_actions,
cus_order.cus_conditions,
cus_order.vh_options,
cus_order.milage_max,
cus_order.vh_color,
cus_order.vh_year,
coordinator.coordinator_name,
maker_model.mod_name,
maker.maker_name,
cus_order.order_no,
customer.cus_name,
cus_order.order_id,
cus_order.order_status,
cus_order.vh_reserved,
IFNULL(vehicle.vh_code,'-') AS vh_code
FROM
cus_order
INNER JOIN coordinator ON cus_order.coordinator_id = coordinator.coordinator_id
INNER JOIN maker_model ON cus_order.model_id = maker_model.mod_id
INNER JOIN maker ON maker_model.maker_id = maker.maker_id
INNER JOIN customer ON cus_order.cus_id = customer.cus_id
LEFT JOIN vehicle ON cus_order.vh_reserved = vehicle.vh_id
WHERE
cus_order.order_status = '$order_status'");
    } else if ($_POST['table'] == 'vehicleModiTable') {
        $system->prepareSelectQueryForJSON("SELECT
vehicle_modification.mod_id,
vehicle_modification.request_date,
vehicle_modification.`desc`,
vehicle_modification.vh_id,
vehicle_modification.cus_id,
vehicle_modification.mod_status,
customer.cus_name,
vehicle.vh_code,
vehicle_modification.`options`,
vehicle_modification.other_opt
FROM
vehicle_modification
INNER JOIN customer ON customer.cus_id = vehicle_modification.cus_id
INNER JOIN vehicle ON vehicle.vh_id = vehicle_modification.vh_id
WHERE vehicle_modification.vh_id = '{$_POST['vh_id']}'");
    } else if ($_POST['table'] == 'load_view_vehicle_tbl') {
        $rec_per_page = 15; // enter the same value in 'view_vehicle_tbl_paging'
        if (filter_var($_REQUEST["records"], FILTER_VALIDATE_INT)) {
            $rec_per_page = $_REQUEST["records"];
        }
        if (isset($_REQUEST["page"])) {
            $page = $_REQUEST["page"];
        } else {
            $page = 1;
        }
        $start_from = ($page - 1) * $rec_per_page;
        $query_p1 = "SELECT
    vehicle.vh_id,
    vehicle.vh_index_num,
    vehicle.vh_code,
    vehicle.vh_chassis_code,
    vehicle.vh_chassis_num,
    vehicle.engine_code,
    vehicle.engine_num,
    vehicle.engine_cc,
    vehicle.package,
    vehicle.vh_year,
    vehicle.vh_color,
    vehicle.vh_milage,
    vehicle.vh_options,
    vehicle.fuel_type,
    vehicle.transmission,
    vehicle.seats,
    vehicle.doors,
    vehicle.eval_grade,
    vehicle.drive_wheels,
    vehicle.additional_options,
    vehicle.bid_date,
    vehicle.auction_name,
    vehicle.lot_no,
    vehicle.auction_grade,
    vehicle.auc_display_price,
    vehicle.stock_location,
    vehicle.stock_status,
    maker_model.mod_name,
    maker.maker_name,
    coordinator.short_name,
    supplier.supp_name,
    vehicle.color_group
    FROM
    vehicle
    INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
    INNER JOIN maker ON maker_model.maker_id = maker.maker_id
    LEFT JOIN coordinator ON vehicle.coordinator_id = coordinator.coordinator_id
    INNER JOIN supplier ON vehicle.supp_id = supplier.supp_id
    WHERE
    vehicle.record_status = '1'";

        if ($_POST['stock_status'] != 0) {
            $query_p1 = $query_p1 . " AND vehicle.stock_status = '{$_POST['stock_status']}'";
        }

        $query_p3 = " ORDER BY vehicle.vh_group ASC,vehicle.vh_index_num ASC LIMIT $start_from, $rec_per_page";
        if ($_POST['supp_id'] > 0) {
            $query_p2 = " AND supplier.supp_id = '{$_POST['supp_id']}'";
//            create_vehicle_viewlist($query_p1 . $query_p2 . $query_p3, $query_p1 . $query_p2);
            $system->prepareSelectQueryForJSON($query_p1 . $query_p2 . $query_p3);
        } else {
            $system->prepareSelectQueryForJSON($query_p1 . $query_p3);
        }


        //
    } else if ($_POST['table'] == 'view_vehicle_tbl_paging') {
        $rec_per_page = 15;
        if (filter_var($_REQUEST["records"], FILTER_VALIDATE_INT)) {
            $rec_per_page = $_REQUEST["records"];
        }
        MainConfig::connectDB();
//        $result_1;
        $query_p1 = "SELECT count(vehicle.vh_id)  AS num_rec
    FROM
    vehicle
    INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
    INNER JOIN maker ON maker_model.maker_id = maker.maker_id
    LEFT JOIN coordinator ON vehicle.coordinator_id = coordinator.coordinator_id
    INNER JOIN supplier ON vehicle.supp_id = supplier.supp_id
    WHERE
    vehicle.record_status = '1'";

        if ($_POST['stock_status'] != 0) {
            $query_p1 = $query_p1 . " AND vehicle.stock_status = '{$_POST['stock_status']}'";
        }
        if ($_POST['supp_id'] > 0) {
            $query_p2 = " AND supplier.supp_id = '{$_POST['supp_id']}'";
            $result_1 = mysql_query($query_p1 . $query_p2);
        } else {
            $result_1 = mysql_query($query_p1);
        }
        $total_pages = 0;
        if (!empty($result_1)) {
            $data_arr = mysql_fetch_array($result_1);
            $total_pages = ceil($data_arr[0] / $rec_per_page);
        }
        echo json_encode(array("tot_pg" => $total_pages));
        //
    }
//    ******************** keyword search with paging-- 
    else if ($_POST['table'] == 'view_vehicle_keyword_search::::fnc-disabled') {
        $keyword_arr = $_POST['key_arr'];
        $rec_per_page = 15;
        if (isset($_REQUEST["page"])) {
            $page = $_REQUEST["page"];
        } else {
            $page = 1;
        }
        $start_from = ($page - 1) * $rec_per_page;
        // column names are case sensitive
        $search_cols = array('vh_code', 'vh_chassis_code', 'vh_chassis_num', 'engine_code', 'engine_num', 'vh_year', 'vh_color', 'vh_options', 'additional_options', 'auc_display_price', 'mod_name', 'maker_name', 'short_name');
        $init_query = "SELECT
    vehicle.vh_id,
    vehicle.vh_index_num,
    vehicle.vh_code,
    vehicle.vh_chassis_code,
    vehicle.vh_chassis_num,
    vehicle.engine_code,
    vehicle.engine_num,
    vehicle.engine_cc,
    vehicle.package,
    vehicle.vh_year,
    vehicle.vh_color,
    vehicle.vh_milage,
    vehicle.vh_options,
    vehicle.fuel_type,
    vehicle.transmission,
    vehicle.seats,
    vehicle.doors,
    vehicle.eval_grade,
    vehicle.drive_wheels,
    vehicle.additional_options,
    vehicle.bid_date,
    vehicle.auction_name,
    vehicle.lot_no,
    vehicle.auction_grade,
    vehicle.auc_display_price,
    vehicle.stock_location,
    vehicle.stock_status,
    maker_model.mod_name,
    maker.maker_name,
    coordinator.short_name,
    supplier.supp_name
    FROM
    vehicle
    INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
    INNER JOIN maker ON maker_model.maker_id = maker.maker_id
    INNER JOIN coordinator ON vehicle.coordinator_id = coordinator.coordinator_id
    INNER JOIN supplier ON vehicle.supp_id = supplier.supp_id
    WHERE
    vehicle.record_status = '1' ORDER BY vehicle.vh_index_num ASC";

        $data = array();
        MainConfig::connectDB();
        $result = mysql_query($init_query);
        $numrows = mysql_num_rows($result);

        if ($numrows !== FALSE && $numrows < 101) {
            if (mysql_data_seek($result, $start_from)) {
                $i = 0;
//                while ($row = mysql_fetch_assoc($result)) {
                while ($i < $rec_per_page) {

                    $row = mysql_fetch_assoc($result);
//                    print_r($row);
                    if (!$row === FALSE) {
//                search keywords are resetted in each db row
//                $keywords = array('yota', 'riu');
                        $keywords = $keyword_arr;
                        //
                        foreach ($row as $dbcol => $dbcell) {
                            // check if,there are any keywords left for search. (matched keywords are removed from array)
                            if (!empty($keywords)) {
                                //then, match column names to see if this column included for searching
                                if (in_array($dbcol, $search_cols)) {
                                    //
                                    foreach ($keywords as $index => $needle) {
                                        if (stripos($dbcell, $needle) !== FALSE) {
                                            // one of the keywords found in a cell value 
                                            // remove the found keyword
                                            unset($keywords[$index]);
                                        }
                                    }

                                    if (empty($keywords)) {
                                        //all keywords are matched
                                        $i++;
                                        $data[] = $row;
                                        continue;
                                    }
                                }
                            }
                        }
                    } else {
                        //no more data rows
                        $i = $rec_per_page;
                        continue;
                    }
                }
            }//invslid start row number          
        }// too many search results
        MainConfig::closeDB();
        echo json_encode($data);
        //
    } else if ($_POST['table'] == 'view_vehicle_keyword_search') {
        $keyword_arr = $_POST['key_arr'];
        // column names are case sensitive
        $search_cols = array('vh_code', 'vh_chassis_code', 'vh_chassis_num', 'engine_code', 'engine_num', 'vh_year', 'vh_color', 'vh_options', 'additional_options', 'auc_display_price', 'mod_name', 'maker_name', 'short_name');
        $init_query = "SELECT
    vehicle.vh_id,
    vehicle.vh_index_num,
    vehicle.vh_code,
    vehicle.vh_chassis_code,
    vehicle.vh_chassis_num,
    vehicle.engine_code,
    vehicle.engine_num,
    vehicle.engine_cc,
    vehicle.package,
    vehicle.vh_year,
    vehicle.vh_color,
    vehicle.vh_milage,
    vehicle.vh_options,
    vehicle.fuel_type,
    vehicle.transmission,
    vehicle.seats,
    vehicle.doors,
    vehicle.eval_grade,
    vehicle.drive_wheels,
    vehicle.additional_options,
    vehicle.bid_date,
    vehicle.auction_name,
    vehicle.lot_no,
    vehicle.auction_grade,
    vehicle.auc_display_price,
    vehicle.stock_location,
    vehicle.stock_status,
    maker_model.mod_name,
    maker.maker_name,
    coordinator.short_name,
    supplier.supp_name
    FROM
    vehicle
    INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
    INNER JOIN maker ON maker_model.maker_id = maker.maker_id
    INNER JOIN coordinator ON vehicle.coordinator_id = coordinator.coordinator_id
    INNER JOIN supplier ON vehicle.supp_id = supplier.supp_id
    WHERE
    vehicle.record_status = '1' ORDER BY vehicle.vh_index_num ASC";

        $data = array();
        MainConfig::connectDB();
        $result = mysql_query($init_query);
        $numrows = mysql_num_rows($result);

        if ($numrows !== FALSE && $numrows < 2000) {
            while ($row = mysql_fetch_assoc($result)) {

//                search keywords are resetted in each db row
//                $keywords = array('yota', 'riu');
                $keywords = $keyword_arr;
                //
                foreach ($row as $dbcol => $dbcell) {
                    // check if,there are any keywords left for search. (matched keywords are removed from array)
                    if (!empty($keywords)) {
                        //then, match column names to see if this column included for searching
                        if (in_array($dbcol, $search_cols)) {
                            //
                            foreach ($keywords as $index => $needle) {
                                if (stripos($dbcell, $needle) !== FALSE) {
                                    // one of the keywords found in a cell value 
                                    // remove the found keyword
                                    unset($keywords[$index]);
                                }
                            }

                            if (empty($keywords)) {
                                //all keywords are matched
                                $data[] = $row;
                                continue;
                            }
                        }
                    }
                }
            }
        } else {
            echo 'too many search results';
        }// too many search results
        MainConfig::closeDB();
        echo json_encode($data);
        //
    } else if ($_POST['table'] == 'customer_search_res') {
        $system->prepareSelectQueryForJSON("SELECT customer.cus_id,
            customer.cus_inv_name,
            customer.cus_address,
            customer.cus_inv_address,
            customer.cus_phone1,
            customer.cus_phone2,
            customer.cus_email2,
            customer.other_contact,
            customer.cus_name,
            customer.cus_email1
            FROM customer
            WHERE cus_status ='1'");
    } else if ($_POST['table'] == 'load_proinv_vehicle_tbl') {
        if (!empty($_POST['ref_id'])) {
            $system->prepareSelectQueryForJSON("SELECT
            vehicle.vh_id,
            maker.maker_name,
            maker_model.mod_name,
            vehicle.vh_chassis_code,
            vehicle.vh_chassis_num,
            vehicle.engine_code,
            vehicle.engine_num,
            vehicle.engine_cc,
            vehicle.vh_year,
            vehicle.auc_display_price,
            vehicle.vh_code,
            pi_entries.pi_entry_id,
            pi_entries.tot_amt
            FROM
            vehicle
            INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
            INNER JOIN maker ON maker_model.maker_id = maker.maker_id
            INNER JOIN pi_entries ON pi_entries.vh_id = vehicle.vh_id
            WHERE
            pi_entries.pi_id = '{$_POST['ref_id']}'
            ORDER BY vehicle.vh_code ASC");
        }
    } else if ($_POST['table'] == 'load_supp_bank_tbl') {
        $system->prepareSelectQueryForJSON("SELECT
        supp_bank.bank_id,
        supp_bank.bank_name,
        supp_bank.swift,
        supp_bank.branch,
        supp_bank.ac_num
        FROM
        supp_bank
        WHERE
        supp_bank.bank_status = 1");
    } else if ($_POST['table'] == 'vh_search_res') {
        $system->prepareSelectQueryForJSON("SELECT
maker_model.mod_name,
maker.maker_name,
vehicle.vh_color,
vehicle.vh_chassis_num,
vehicle.vh_chassis_code,
vehicle.vh_code,
vehicle.vh_id
FROM
vehicle
INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
INNER JOIN maker ON maker_model.maker_id = maker.maker_id
WHERE
vehicle.record_status = '1' AND
vehicle.stock_status = '1'
ORDER BY
vehicle.supp_id ASC,
vehicle.vh_index_num ASC");
    } else if ($_POST['table'] == 'load_proInvoiceView_table') {
        //viraj
        $system->prepareSelectQueryForJSON("SELECT
proforma_inv.pi_id,
proforma_inv.pi_no,
proforma_inv.pi_date,
customer.cus_inv_name,
proforma_inv.consignee_name,
proforma_inv.last_shipment_date,
proforma_inv.port_discharge,
proforma_inv.validity,
proforma_inv.presentation_period,
proforma_inv.total_cif,
proforma_inv.pi_sent,
proforma_inv.pi_type
FROM
proforma_inv
INNER JOIN customer ON customer.cus_id = proforma_inv.cus_id
WHERE
proforma_inv.pi_status = '{$_POST['inv_status']}'
ORDER BY
proforma_inv.pi_date ASC");
    } else if ($_POST['table'] == 'vh_search_filtered') {
        $system->prepareSelectQueryForJSON("SELECT
maker_model.mod_name,
maker.maker_name,
vehicle.vh_color,
vehicle.vh_chassis_num,
vehicle.vh_chassis_code,
vehicle.vh_code,
vehicle.vh_id
FROM
vehicle
INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
INNER JOIN maker ON maker_model.maker_id = maker.maker_id
WHERE
vehicle.record_status = '1' AND
vehicle.stock_status = '1' AND
maker_model.mod_id = '{$_POST['vh_model']}'
ORDER BY
vehicle.supp_id ASC,
vehicle.vh_index_num ASC");
    } else if ($_POST['table'] == 'load_lease_co_tbl') {
        $system->prepareSelectQueryForJSON("SELECT
leasing.ls_id,
leasing.ls_name,
leasing.ls_address,
leasing.ls_contact,
leasing.ls_status
FROM
leasing
WHERE
leasing.ls_status = '1'");
    } else if ($_POST['table'] == 'syscode_tbl') {
        $query = "SELECT
        syscode.description,
        syscode.sys_id,
        syscode.remarks
        FROM
        syscode
        WHERE
        syscode.type = '{$_POST['type_id']}'";
        $system->prepareSelectQueryForJSON($query);
    } else if ($_POST['table'] == 'web_vh_feauture_list') {
        $query = "SELECT
        syscode.description,
        syscode.sys_id,
        syscode.remarks
        FROM
        syscode
        WHERE
        syscode.type = '{$_POST['type_id']}' ORDER BY syscode.description ASC";
        MainConfig::connectDB();
        $result = mysql_query($query) or die(mysql_error());
        $rowcount = mysql_num_rows($result);
        $html = '';
        if ($rowcount > 0) {
            $blank_cell = 3 - ($rowcount % 3);
            $j = 0;
            while ($row1 = mysql_fetch_assoc($result)) {
                if ($j === 0) {
                    $html .= '<tr>';
                }
                $html .='<td><label><input type="checkbox" value="' . $row1['sys_id'] . '"/>&nbsp;' . $row1['description'] . '</label></td>';
                $j++;
                if ($j === 3) {
                    $html .= '</tr>';
                    $j = 0;
                }
            }
            if ($blank_cell < 3) {
                for ($i = 1; $i <= $blank_cell; $i++) {
                    $html .='<td>&nbsp;</td>';
                }
                $html .='</tr>';
            }
        }
        MainConfig::closeDB();
        echo $html;
        //
    } else if ($_POST['table'] == 'tbl_web_homepg') {
        $query = "SELECT
        web_homepg.wh_id,
        web_homepg.wh_image,
        web_homepg.wh_head1
        FROM
        web_homepg WHERE
        web_homepg.wh_section = '{$_POST['section']}'";
        $system->prepareSelectQueryForJSON($query);
    } else if ($_POST['table'] == 'vehicle_spec_table') {
        $query = "SELECT
        vh_tech_spec.spec_title,
        vh_tech_spec.spec_id,
        vh_tech_spec.eng_cc,
        vh_tech_spec.eng_rpm,
        vh_tech_spec.perf_max_speed,
        vh_tech_spec.trans_type,
        vh_tech_spec.fuel_cons_highway,
        vh_tech_spec.bd_curb_weight,
        vh_tech_spec.cap_fuel_tank
        FROM
        vh_tech_spec
        WHERE
        vh_tech_spec.mod_id = '{$_POST['model_id']}'";
        $system->prepareSelectQueryForJSON($query);
    } else if ($_POST['table'] == 'sendWeb_selectedVh') {
        $query = "SELECT
        vehicle.vh_code,
        maker_model.mod_name,
        vehicle.package,
        vehicle.vh_year,
        vehicle.vh_color,
        vehicle.vh_id,
        maker_model.mod_id
        FROM
        vehicle
        INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
        WHERE
        vehicle.vh_id IN ({$_POST['idlist']})";
        $system->prepareSelectQueryForJSON($query);
    } else if ($_POST['table'] == 'news_details_tbl') {
        $system->prepareSelectQueryForJSON("SELECT
        web_news.news_id,
        web_news.heading_1,
        web_news.posted_date,
        web_news.image
        FROM
        web_news");
    } else if ($_POST['table'] == 'load_vh_group_tbl') {
        $system->prepareSelectQueryForJSON("SELECT DISTINCT (tbl.vh_group)
        FROM
        (SELECT vehicle.vh_id,vehicle.vh_group
        FROM vehicle WHERE vh_group !='' ORDER BY vehicle.vh_id DESC LIMIT 100) AS tbl");
    } else if ($_POST['table'] == 'report_imported_vehicle') {
        $system->prepareSelectQueryForJSON("SELECT
        vehicle.vh_code,
        maker.maker_name,
        maker_model.mod_name,
        vehicle.vh_chassis_code,
        vehicle.vh_chassis_num,
        vehicle.vh_year,
        vehicle.vh_color,
        vehicle.vh_milage,
        vehicle_other.tot_cost,
        vehicle_other.import_date
        FROM vehicle
        INNER JOIN vehicle_other ON vehicle_other.vh_id = vehicle.vh_id
        INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
        INNER JOIN maker ON maker_model.maker_id = maker.maker_id
        WHERE vehicle.record_status = 1 AND vehicle_other.import_date BETWEEN '{$_POST['firstDate']}' AND '{$_POST['endDate']}'");
    } else if ($_POST['table'] == 'report_vehicle_sales') {
        $system->prepareSelectQueryForJSON("SELECT
        vehicle.vh_code,
        maker.maker_name,
        maker_model.mod_name,
        CONCAT_WS('-',vehicle.vh_chassis_code,vehicle.vh_chassis_num) AS vh_chassis,
        vehicle_other.import_date,
        customer.cus_inv_name,
        vehicle_other.vh_reg_num,
        vehicle_other.tot_cost,
        vehicle_other.sold_price,
        (vehicle_other.sold_price-vehicle_other.tot_cost) AS sales_profit
        FROM
        vehicle
        INNER JOIN vehicle_other ON vehicle_other.vh_id = vehicle.vh_id
        INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
        INNER JOIN maker ON maker_model.maker_id = maker.maker_id
        INNER JOIN customer ON customer.cus_id = vehicle_other.cus_id
        WHERE vehicle.record_status = 1 AND vehicle_other.import_date BETWEEN '{$_POST['firstDate']}' AND '{$_POST['endDate']}'");
    } else if ($_POST['table'] == 'exvh_search_result') {
        $system->prepareSelectQueryForJSON("SELECT
        vehicle.vh_code,
        vehicle.vh_id,
        maker.maker_name,
        maker_model.mod_name,
        CONCAT(vehicle.vh_chassis_code,'-',vehicle.vh_chassis_num) AS vh_chassis
        FROM
        vehicle
        INNER JOIN vehicle_other ON vehicle_other.vh_id = vehicle.vh_id
        INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
        INNER JOIN maker ON maker_model.maker_id = maker.maker_id
        WHERE
        vehicle_other.vh_purchase_type = '1'");
    } else if ($_POST['table'] == 'report_cheque') {
//    Sam_Rulz Creations - Sam -
        $system->prepareSelectQueryForJSON("SELECT
customer.cus_inv_name,
vh_payment.in_amount,
vh_payment.pay_date,
vh_payment.chq_date,
vh_payment.pay_bank,
vh_payment.chq_num,
vh_payment.pay_confirmed,
vh_payment.vp_id,
vh_payment.bank_account
FROM
vh_payment
INNER JOIN customer ON customer.cus_id = vh_payment.cus_id
WHERE
vh_payment.pay_method = 'CHEQUE' AND
vh_payment.pay_date BETWEEN '{$_POST['firstDate']}' AND '{$_POST['endDate']}'  AND
vh_payment.pay_confirmed = '{$_POST['chq_type']}'");
    } else if ($_POST['table'] == 'vh_payments') {
        $system->prepareSelectQueryForJSON("SELECT
    vh_payment.in_amount,
    vh_payment.pay_date,
    vh_payment.chq_date,
    vh_payment.pay_method,
    vh_payment.pay_bank,
    vh_payment.chq_num,
    vh_payment.pay_confirmed,
    vh_payment.vp_id,
    vh_payment.pay_category,
    vh_payment.bank_account
    FROM
    vh_payment
    WHERE
    vh_payment.vh_id = '{$_POST['vh_id']}' AND
    vh_payment.pay_confirmed < '5' ORDER BY
    vh_payment.pay_date ASC,
    vh_payment.pay_method ASC");
    } else if ($_POST['table'] == 'report_vh_stock') {
        $qpart1 = "SELECT
	vehicle.vh_code,
	maker.maker_name,
	maker_model.mod_name,
	vehicle.vh_chassis_code,
	vehicle.vh_chassis_num,
	vehicle.vh_year,
	vehicle.vh_color,
	vehicle.vh_milage,
	vehicle_other.import_date,
	vehicle.stock_location,
	vehicle_other.vh_purchase_type
        FROM
	vehicle
	INNER JOIN vehicle_other ON vehicle_other.vh_id = vehicle.vh_id
	INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
	INNER JOIN maker ON maker_model.maker_id = maker.maker_id
        WHERE
        vehicle.record_status = '1'";
        if (!empty($_POST['st_location']) && $_POST['st_location'] !== 0) {
            $qpart1 .="  AND vehicle.stock_location = '{$_POST['st_location']}'";
        }
        $qpart1 .=" ORDER BY maker.maker_name ASC,maker_model.mod_name ASC,vehicle_other.import_date ASC";
        $system->prepareSelectQueryForJSON($qpart1);
    } else if ($_POST['table'] == 'vh_inweb') {
        $query = "SELECT
        vehicle.vh_code,
        vehicle.vh_id,
        maker_model.mod_name,
        maker.maker_name,
        CONCAT(vehicle.vh_chassis_code,'-',vehicle.vh_chassis_num)AS vh_chassis,
        vehicle.vh_year,
        vehicle.vh_color,
        maker_model.mod_id
        FROM web_vh_data
        INNER JOIN vehicle ON web_vh_data.vh_id = vehicle.vh_id
        INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
        INNER JOIN maker ON maker_model.maker_id = maker.maker_id
        ORDER BY
        maker.maker_name ASC,
        maker_model.mod_name ASC,
        vehicle.vh_id DESC LIMIT 100";
        $system->prepareSelectQueryForJSON($query);
    }  else if ($_POST['table'] == 'load_view_clearing_tbl') {
        $rec_per_page = 15; // enter the same value in 'view_vechicle_tbl_paging'
        if (filter_var($_REQUEST["records"], FILTER_VALIDATE_INT)) {
            $rec_per_page = $_REQUEST["records"];
        }
        if (isset($_REQUEST["page"])) {
            $page = $_REQUEST["page"];
        } else {
            $page = 1;
        }
        $start_from = ($page - 1) * $rec_per_page;
        $query_p1 = "SELECT
                        vehicle.vh_id,
                        vehicle.vh_index_num,
                        vehicle.vh_code,
                        vehicle.vh_chassis_code,
                        vehicle.vh_chassis_num,
                        vehicle.engine_code,
                        vehicle.engine_num,
                        vehicle.engine_cc,
                        vehicle.auc_display_price,
                        vehicle.stock_location,
                        vehicle.stock_status,
                        maker_model.mod_name,
                        maker.maker_name,
                        coordinator.short_name,
                        vehicle.color_group,
                        vh_clearing.shipped_date,
                        vh_clearing.vessel,
                        vh_clearing.refunds,
                        vh_clearing.arrival_date,
                        vh_clearing.document_status,
                        supplier.supp_id,
                        supplier.supp_name,
                        vh_clearing.duty,
                        vh_clearing.clr_date,
                        vh_clearing.lc_no,
                        vh_clearing.to_clr_agent
                        FROM
                        vehicle
                        INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
                        INNER JOIN maker ON maker_model.maker_id = maker.maker_id
                        LEFT JOIN coordinator ON vehicle.coordinator_id = coordinator.coordinator_id
                        INNER JOIN supplier ON vehicle.supp_id = supplier.supp_id
                        LEFT JOIN vh_clearing ON vh_clearing.vh_id = vehicle.vh_id
                        WHERE
                            vehicle.record_status = '1'

";

        if ($_POST['stock_status'] != 0) {
            $query_p1 = $query_p1 . " AND vehicle.stock_status = '{$_POST['stock_status']}'";
        }

        $query_p3 = " ORDER BY vehicle.vh_group ASC,vehicle.vh_index_num ASC LIMIT $start_from, $rec_per_page";
        if ($_POST['supp_id'] > 0) {
            $query_p2 = " AND supplier.supp_id = '{$_POST['supp_id']}'";
//            create_vehicle_viewlist($query_p1 . $query_p2 . $query_p3, $query_p1 . $query_p2);
            $system->prepareSelectQueryForJSON($query_p1 . $query_p2 . $query_p3);
        } else {
            $system->prepareSelectQueryForJSON($query_p1 . $query_p3);
        }


        //
    } else if ($_POST['table'] == 'load_employee_tbl') {
        $system->prepareSelectQueryForJSON("SELECT
r_employee.emp_id,
r_employee.empno,
r_employee.title,
r_employee.`name`,
r_employee.designation,
r_employee.nic,
r_employee.tel,
r_employee.gender,
r_employee.epfno,
r_employee.basic,
r_employee.reg_date,
r_employee.`status`
FROM
r_employee
where r_employee.`status` = '1'");
    }
}

/// ********** galary by V!raj
else if (array_key_exists("galary", $_POST)) {
    MainConfig::connectDB();
    $data = array();
    $vid = $_POST['vehicleID'];
    $qu = "SELECT
vehicle_photo.file_3,
vehicle_photo.ph_id,
vehicle_photo.p_visible,
vehicle.vh_code
FROM
vehicle_photo
INNER JOIN vehicle ON vehicle_photo.vh_id = vehicle.vh_id
WHERE vehicle_photo.vh_id = {$vid}";
    $system->prepareSelectQueryForJSON($qu);
} 
