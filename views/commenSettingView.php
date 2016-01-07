<?php

session_start();
require_once '../config/dbc.php';
require_once '../class/database.php';
require_once '../class/systemSetting.php';
$system = new setting();
$database = new database();
MainConfig::connectDB();
if (array_key_exists("action", $_POST)) {
    if ($_POST['action'] == 'maker_save') {
        $today = date('Y-m-d');
        if (empty($_POST['maker_name'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a Maker Name")));
            return;
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("INSERT INTO `maker`(`maker_name`, `desc`, `maker_status`) VALUES ('{$_POST['maker_name']}', '{$_POST['maker_desc']}', '1')");
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'Maker', '{$today}', '{$_SESSION['user_id']}')");
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Maker saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'maker_update') {
        $today = date('Y-m-d');
        $form = $_POST['form_data'];
        if (empty($form['maker_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Maker to update")));
            return;
        }
        if (empty($form['maker_name'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a Maker Name")));
            return;
        }
        foreach ($form as $key => $value) {
            $form[$key] = mysql_real_escape_string($form[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `maker` SET `maker_name`='{$form['maker_name']}', `desc`='{$form['maker_desc']}' WHERE (`maker_id`='{$form['maker_id']}')") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Maker-{$form['maker_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Maker saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'maker_select') {
        $maker_id = $_POST['maker_id'];
        $system->prepareSelectQueryForJSON("SELECT
        maker.maker_id,
        maker.maker_name,
        maker.`desc`
        FROM
        maker
        WHERE
        maker.maker_id = '{$maker_id}'");
    } elseif ($_POST['action'] == 'delete_maker') {
        $maker_id = $_POST['maker_id'];
        $today = date('Y-m-d');

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `maker` SET maker_status='99' WHERE (`maker_id`='{$maker_id}')") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'Maker-{$maker_id}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Maker Deleted")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not delete")));
        }
        MainConfig::closeDB();
    } elseif ($_POST['action'] == 'exec_mysql_query') {
        $ins = mysql_query($_POST['str_query']) or die(mysql_error());
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'kitz_customer_save') {
//kitz
        $today = date('Y-m-d');
        $form = $_POST['form_data'];
        foreach ($form as $key => $value) {
            $form[$key] = mysql_real_escape_string($form[$key]);
        }

        $insert_query = "INSERT INTO `customer` (`cus_name`, `cus_inv_name`, `cus_address`, `cus_inv_address`, `cus_phone1`, `cus_phone2`,cus_email1,cus_email2, `other_contact`, `comments`, `cus_status`,`leasing_id`) VALUES "
                . "('{$form['c_name']}', '{$form['c_inv_name']}', '{$form['c_addr']}', '{$form['c_inv_addr']}', '{$form['c_phone1']}', '{$form['c_phone2']}', '{$form['c_email1']}', '{$form['c_email2']}', '{$form['c_other']}', '{$form['c_comments']}', 1, '{$form['c_lease']}');";

        $transaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'Customer-{$form['c_name']}', '{$today}', '{$_SESSION['user_id']}')";


        mysql_query("START TRANSACTION");
        $insert = mysql_query($insert_query) or die(mysql_error());
        $transaction = mysql_query($transaction_query);
        if ($insert && $transaction) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Customer Added.")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Couldn't Add Customer.")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'kitz_select_costomer') {
//kitz
        $cus_id = $_POST['cus_id'];
        $query = "SELECT customer.cus_id,
        customer.cus_name,
        customer.cus_inv_name,
        customer.cus_address,
        customer.cus_inv_address,
        customer.cus_phone1,
        customer.cus_phone2,
        customer.cus_email1,
        customer.cus_email2,
        customer.other_contact,
        customer.comments,
        leasing.ls_name,
        leasing.ls_id,
        leasing.ls_address
        FROM `customer`
        LEFT JOIN leasing ON customer.leasing_id = leasing.ls_id
        WHERE
        customer.cus_status != 99 AND
        customer.cus_id = '{$cus_id}' LIMIT 1";
//        echo $query;

        $result = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        echo json_encode($row);
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'kitz_customer_update') {
//kitz
        $today = date('Y-m-d');
        $form = $_POST['form_data'];
        foreach ($form as $key => $value) {
            $form[$key] = mysql_real_escape_string($form[$key]);
        }

        $update_query = "UPDATE `customer` SET  `cus_name` = '{$form['c_name']}',cus_inv_name = '{$form['c_inv_name']}',`cus_address` = '{$form['c_addr']}',`cus_inv_address` = '{$form['c_inv_addr']}',
        `cus_phone1` = '{$form['c_phone1']}',`cus_phone2` = '{$form['c_phone2']}',cus_email1= '{$form['c_email1']}',cus_email2= '{$form['c_email2']}' ,`other_contact` = '{$form['c_other']}',`comments` = '{$form['c_comments']}' ,`leasing_id` = '{$form['c_lease']}' WHERE `cus_id` = '{$form['c_id']}'";

        $transaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Customer-{$form['c_id']}', '{$today}', '{$_SESSION['user_id']}')";

        mysql_query("START TRANSACTION");
        $insert = mysql_query($update_query) or die(mysql_error());
        $transaction = mysql_query($transaction_query);
        if ($insert && $transaction) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Customer Updated.")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Couldn't Update Customer.")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'kitz_delete_customer') {
//kitz
        $today = date('Y-m-d');
        $cus_id = $_POST['cus_id'];
        $delete_query = "UPDATE `customer` SET  `cus_status` = '99' WHERE (`cus_id`='{$cus_id}')";
        $transaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'Customer-{$cus_id}', '{$today}', '{$_SESSION['user_id']}')";

        mysql_query("START TRANSACTION");
        $delete = mysql_query($delete_query);
        $transaction = mysql_query($transaction_query);
        if ($delete && $transaction) {
            mysql_query('COMMIT');
            echo json_encode(array(array("msgType" => 1, "msg" => "Customer Deleted.")));
        } else {
            mysql_query('ROLLBACK');
            echo json_encode(array(array("msgType" => 2, "msg" => "Customer Cannot Be Deleted.")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'add_vh_model') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['maker_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Maker")));
            return;
        }
        if (empty($data['model'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a Model name")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        $insert_query = "INSERT INTO `maker_model` (
	`maker_id`,
	`mod_name`,
	`mod_options`,
	`mod_desc`,
        mod_overview,
	`mod_status`
        ) VALUES ('{$data['maker_id']}', '{$data['model']}', '', '{$data['desc']}', '{$data['web_oview']}', 1);";

        $trnsaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'maker_model', '{$today}', '{$_SESSION['user_id']}')";


        mysql_query("START TRANSACTION");
        $insert = mysql_query($insert_query) or die(mysql_error());
        $transaction = mysql_query($trnsaction_query);
        if ($insert && $transaction) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Vehicle Model Added.")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Couldn't Add Vehicle Model.")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'model_select') {
        $model_id = $_POST['model_id'];
        $system->prepareSelectQueryForJSON("SELECT
        maker_model.mod_id,
        maker_model.mod_name,
        maker_model.mod_desc,
        maker_model.maker_id,
        maker_model.mod_overview
        FROM
        maker_model
        WHERE
        maker_model.mod_id = '{$model_id}'");
    } elseif ($_POST['action'] == 'delete_model') {
        $model_id = $_POST['model_id'];
        $today = date('Y-m-d');

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `maker_model` SET `mod_status` = '99' WHERE (`mod_id` = '{$model_id}')");
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'Model-{$model_id}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Model Deleted")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not delete")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'model_update') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['modle_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Model")));
            return;
        }
        if (empty($data['maker_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Maker")));
            return;
        }
        if (empty($data['model'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a Model name")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }


        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `maker_model`
          SET `maker_id` = '{$data['maker_id']}',
         `mod_name` = '{$data['model']}',
         `mod_desc` = '{$data['desc']}',
          mod_overview= '{$data['web_oview']}'
          WHERE
	(`mod_id` = '{$data['modle_id']}')") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Model-{$data['model']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Model saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'save_supp') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['sup_code'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a supplier code")));
            return;
        }
        if (empty($data['sup_name'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a Supplier name")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("INSERT INTO `supplier` (`supp_code`, `supp_name`, `inv_name`, `supp_address`, `inv_address`, `phone`, `inv_phone`, `supp_email`, `web`, `supp_fax`, `supp_status`,supp_currency,`bank_id`) VALUES "
                . "('{$data['sup_code']}', '{$data['sup_name']}', '{$data['sup_name_for_invo']}', '{$data['address']}', '{$data['address_for_invo']}', '{$data['phone_no']}', '{$data['phone_no_for_invo']}', '{$data['email']}', '{$data['web']}', '{$data['fax']}', '1','{$data['currency']}','{$data['suppbank_id']}')") or die(mysql_error());

        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'supplier-{$data['sup_code']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Supplier saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'get_selected_supp_data') {
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
        supplier.supp_fax,
        supplier.supp_currency,
        supp_bank.bank_id,
        supp_bank.bank_name
        FROM
        supplier
        LEFT JOIN supp_bank ON supp_bank.bank_id = supplier.bank_id
        WHERE
        supplier.supp_id = '{$_POST['sup_id']}'");
    } else if ($_POST['action'] == 'update_supp') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['sup_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Supplier")));
            return;
        }
        if (empty($data['sup_code'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a supplier code")));
            return;
        }
        if (empty($data['sup_name'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a Supplier name")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `supplier` SET `supp_code` = '{$data['sup_code']}',`supp_name` = '{$data['sup_name']}',`inv_name` = '{$data['sup_name_for_invo']}',`supp_address` = '{$data['address']}',`inv_address` = '{$data['address_for_invo']}',
        `phone` = '{$data['phone_no']}',`inv_phone` = '{$data['phone_no_for_invo']}',`supp_email` = '{$data['email']}',`web` = '{$data['web']}',`supp_fax` = '{$data['fax']}' ,`supp_currency` = '{$data['currency']}' ,`bank_id` = '{$data['suppbank_id']}' WHERE
        supplier.supp_id = '{$data['sup_id']}'");

        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'supplier-{$data['sup_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Supplier updated")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } elseif ($_POST['action'] == 'delete_supplier') {
        $supp_id = $_POST['supp_id'];
        $today = date('Y-m-d');

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `supplier` SET `supp_status` = '99' WHERE supplier.supp_id ='{$supp_id}'") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'Supplier-{$supp_id}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Supplier Deleted")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not delete")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'add_clear_entry') {

        $data = $_POST['vh_data'];

        mysql_query("START TRANSACTION");
        // delete 
        mysql_query("DELETE from vh_clearing WHERE clr_st= '98'");
        mysql_query("INSERT INTO `proforma_inv` ( `pi_date`, `cus_id`, `pi_status` ) VALUES (CURRENT_DATE(), 0, '98');");

        $ref_id = mysql_insert_id();
//        echo $ref_id;
        if (!empty($data) && $ref_id > 0) {
            foreach ($data as $key => $value) {
                $price_res = mysql_query("SELECT IF(vehicle.auc_display_price=0,vehicle.auc_real_price,vehicle.auc_display_price) AS vh_price
                            FROM vehicle
                            WHERE vehicle.vh_id = '{$value}'");
                $vh_price = mysql_fetch_assoc($price_res);
//                $ins = mysql_query("INSERT INTO `temp_entries` (`temp_id`, `sel_id`) VALUES ({$ref_id},'{$value}');") or die(mysql_error());
                $ins = mysql_query("INSERT INTO `pi_entries` (`pi_id`, `vh_id`) VALUES ({$ref_id},'{$value}');") or die(mysql_error());
            }
        }
        if ($ins) {
            mysql_query("COMMIT");
            echo json_encode($ref_id);
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(0);
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'add_coordinator') {

        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['co_category'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a category")));
            return;
        }
        if (empty($data['co_short_name'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a short Name")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("INSERT INTO `coordinator`(`coordinator_name`,`short_name`,`phone`,`phone2`,`email1`,`email2`,`address`,`category`,`coordinator_status`) VALUES "
                . "('{$data['co_name']}', '{$data['co_short_name']}', '{$data['co_phone1']}', '{$data['co_phone2']}', '{$data['co_email1']}', '{$data['co_email2']}', '{$data['co_address']}', '{$data['co_category']}', '1')") or die(mysql_error());

        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'coordinator-{$data['co_short_name']}', '{$today}', '{$_SESSION['user_id']}')")or die(mysql_error());
        $trn = true;
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Coordinator saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'coord_select') {
        $coord_id = $_POST['coord_id'];
        $system->prepareSelectQueryForJSON("SELECT
        coordinator.coordinator_id,
        coordinator.coordinator_name,
        coordinator.short_name,
        coordinator.phone,
        coordinator.category,
        coordinator.phone2,
        coordinator.email1,
        coordinator.email2,
        coordinator.address,
        coordinator.username
        FROM
        coordinator
        WHERE
        coordinator.coordinator_id= '{$coord_id}'");
    } elseif ($_POST['action'] == 'delete_coordintor') {
        $coord_id = $_POST['coord_id'];
        $today = date('Y-m-d');

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `coordinator` SET `coordinator_status` = '99' WHERE `coordinator_id`='{$coord_id}'") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'Coordinator-{$coord_id}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Coordinator Deleted")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not delete")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'vehicleModification_save') {
        $today = date('Y-m-d');
        $data = $_POST['data_arr'];
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        mysql_query("INSERT INTO `vehicle_modification`(`request_date`,`desc`,`vh_id`,`cus_id`,`sort_order`,`mod_status`,`options`,`other_opt`)VALUES ( '{$data['modi_date']}', '{$data['modi_desc']}', '{$data['modi_vehicle']}', '{$data['modi_custmr']}', '1', '{$data['modi_status']}','{$data['modi_options']}','{$data['modi_other_opt']}');") or die(mysql_error());
        $mod_row = mysql_affected_rows();
        mysql_query("UPDATE `vehicle` SET `vh_options` = '{$data['modi_options']}', `additional_options` = '{$data['modi_other_opt']}' WHERE (`vh_id` = '{$data['modi_vehicle']}');") or die(mysql_error());
        $vhupd_row = mysql_affected_rows();
        mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'vehicle_modification-{$data['modi_vehicle']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        $trn_row = mysql_affected_rows();
        if ($mod_row > 0 && $vhupd_row > 0 && $trn_row > 0) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Modification Saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save")));
        }
        MainConfig::closeDB();
//        $system->prepareCommandQueryForAlertify("", "Sussessfully saved data", "Error Saving data..!");
    } else if ($_POST['action'] == 'update_coordinator') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['co_category'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a category")));
            return;
        }
        if (empty($data['co_short_name'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a short Name")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `coordinator` SET `coordinator_name`='{$data['co_name']}',`short_name`='{$data['co_short_name']}',`phone`='{$data['co_phone']}',`phone2` = '{$data['co_phone2']}',`email1` = '{$data['co_email1']}',`email2` = '{$data['co_email2']}',`address` = '{$data['co_address']}',`category`='{$data['co_category']}' WHERE `coordinator_id`='{$data['coord_id']}'") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'coordinator-{$data['coord_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Coordinator saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'save_coordinator_login') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['coord_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Coordinator")));
            return;
        }
        if (empty($data['co_username'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a user name")));
            return;
        }
        if (empty($data['co_password'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a password")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }
        $res = mysql_query("SELECT coordinator.coordinator_id FROM coordinator WHERE coordinator.username = '{$data['co_username']}'");
        $user_count = mysql_num_rows($res);
        if ($user_count === 0) {
            $encriptedPass = sha1('MDCC' . $data['co_password'] . 'badboyes');
            mysql_query("START TRANSACTION");
            $ins = mysql_query("UPDATE `coordinator` SET `username`='{$data['co_username']}',`password`='$encriptedPass',`user_status`='1' WHERE `coordinator_id`='{$data['coord_id']}'") or die(mysql_error());
            $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'coordinator-user-{$data['co_username']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
            if ($ins && $trn) {
                mysql_query("COMMIT");
                echo json_encode(array(array("msgType" => 1, "msg" => "user account saved")));
            } else {
                mysql_query("ROLLBACK");
                echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
            }
            MainConfig::closeDB();
        } else {
            echo json_encode(array(array("msgType" => 2, "msg" => "User Name already exists")));
            return;
        }
    } elseif ($_POST['action'] == 'delete_coordintor_login') {
        $coord_id = $_POST['coord_id'];
        $today = date('Y-m-d');

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `coordinator` SET `username`='',`password`='',`user_status`='0' WHERE `coordinator_id`='$coord_id'") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'coordinator-user-{$coord_id}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Coordinator Deleted")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not delete")));
        }
        MainConfig::closeDB();
    }
    if ($_POST['action'] == 'order_save') {

        $order_data = $_POST['order_data'];
        foreach ($order_data as $key => $value) {
            $order_data[$key] = mysql_real_escape_string($order_data[$key]);
        }

        $query = "SELECT
        IFNULL(MAX(cus_order.order_no)+1,1) AS next_order_no
        FROM
        cus_order";
        $result = mysql_query($query);
        $nxtid = mysql_fetch_assoc($result);
        $nnxx = $nxtid['next_order_no'];
//        MainConfig::closeDB();
        $system->prepareCommandQueryForAlertify("INSERT INTO `cus_order` (`order_no`, `model_id`, `vh_year`, `vh_color`, `milage_max`, `vh_options`, `cus_conditions`, `order_actions`, `max_price`, `pay_advance`, `gb`, `cus_id`, `description`, `pay_comments`, `coordinator_id`, `order_date`,manual_bill, `order_status`, `order_handler`) VALUES ('$nnxx', '{$order_data['model_ComboBox']}', '{$order_data['vehicle_year']}', '{$order_data['vehicle_colour']}', '{$order_data['vehicle_milage']}', '{$order_data['vehicle_options']}', '{$order_data['vehicle_cus_con']}', '{$order_data['vehicle_action']}', '{$order_data['vehicle_price']}', '{$order_data['vehicle_advance']}', '{$order_data['vehicle_gb']}', '{$order_data['customer_ComboBox']}', '{$order_data['vehicle_desc']}', '{$order_data['vehicle_pay_op']}', '{$order_data['coordinator_ComboBox']}', '{$order_data['vehicle_ord_date']}', '{$order_data['manual_bill_num']}', '1', '{$_SESSION['user_id']}');", "Successfully added", "Sorry..! Could Not Be added");
    } else if ($_POST['action'] == 'order_reserve_save') {
        //

        $today = date('Y-m-d');
        mysql_query("START TRANSACTION");
        //
        $order_data = $_POST['order_data'];
        foreach ($order_data as $key => $value) {
            $order_data[$key] = mysql_real_escape_string($order_data[$key]);
        }
        $query = "SELECT
        IFNULL(MAX(cus_order.order_no)+1,1) AS next_order_no
        FROM cus_order";
        //
        $result = mysql_query($query);
        $nxtid = mysql_fetch_assoc($result);
        $nnxx = $nxtid['next_order_no'];
        mysql_query("INSERT INTO `cus_order`(`order_no`, `model_id`, `vh_year`, `vh_color`, `milage_max`, `vh_options`, `cus_conditions`, `order_actions`, `max_price`, `pay_advance`, `gb`, `cus_id`, `description`, `pay_comments`, `coordinator_id`, `order_date`, `order_status`, `order_handler`,vh_reserved,manual_bill)"
                . " VALUES ('$nnxx', '{$order_data['model_ComboBox']}', '{$order_data['vehicle_year']}', '{$order_data['vehicle_colour']}', '{$order_data['vehicle_milage']}', '{$order_data['vehicle_options']}', '{$order_data['vehicle_cus_con']}', '{$order_data['vehicle_action']}', "
                . " '{$order_data['vehicle_price']}', '{$order_data['vehicle_advance']}', '{$order_data['vehicle_gb']}', '{$order_data['customer_ComboBox']}', '{$order_data['vehicle_desc']}', '{$order_data['vehicle_pay_op']}', '{$order_data['coordinator_ComboBox']}', '{$order_data['vehicle_ord_date']}', '2', '{$_SESSION['user_id']}', '{$order_data['reserve_vh']}','{$order_data['manual_bill_num']}');");
        $rows = mysql_affected_rows();
        if ($rows > 0) {
            mysql_query("UPDATE `vehicle` SET `stock_status` = '2' WHERE `vh_id` ='{$order_data['reserve_vh']}'") or die(mysql_error());
            $upd = mysql_affected_rows();
            $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'cus_order-{$nnxx}-{{$order_data['reserve_vh']}}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
            if ($upd > 0 && $trn) {
                mysql_query("COMMIT");
                echo json_encode(array(array("msgType" => 1, "msg" => "Order saved")));
            } else {
                mysql_query("ROLLBACK");
                echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
            }
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'order_reserve_update') {
        //
        $today = date('Y-m-d');
        mysql_query("START TRANSACTION");
        //
        $order_data = $_POST['order_data'];
        foreach ($order_data as $key => $value) {
            $order_data[$key] = mysql_real_escape_string($order_data[$key]);
        }
        mysql_query("UPDATE `cus_order` SET `model_id` = '{$order_data['model_ComboBox']}', `vh_year` = '{$order_data['vehicle_year']}', `vh_color` = '{$order_data['vehicle_colour']}', `milage_max` = '{$order_data['vehicle_milage']}', `vh_options` = '{$order_data['vehicle_options']}', "
                . "`cus_conditions` = '{$order_data['vehicle_cus_con']}', `order_actions` = '{$order_data['vehicle_action']}', `max_price` = '{$order_data['vehicle_price']}', `pay_advance` = '{$order_data['vehicle_advance']}', `gb` = '{$order_data['vehicle_gb']}', `cus_id` = '{$order_data['customer_ComboBox']}', "
                . "`description` = '{$order_data['vehicle_desc']}', `pay_comments` = '{$order_data['vehicle_pay_op']}', `coordinator_id` = '{$order_data['coordinator_ComboBox']}', `order_date` = '{$order_data['vehicle_ord_date']}', `order_status` = '2', `order_handler` = '{$_SESSION['user_id']}', `manual_bill` = '{$order_data['manual_bill_num']}', `vh_reserved` = '{$order_data['reserve_vh']}' WHERE (`order_id` = '{$order_data['ord_id']}');");
        $rows = mysql_affected_rows();
        if ($rows > 0) {
            mysql_query("UPDATE `vehicle` SET `stock_status` = '2' WHERE `vh_id` ='{$order_data['reserve_vh']}'") or die(mysql_error());
            $upd = mysql_affected_rows();
            $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'cus_order-{$order_data['ord_id']}-{$order_data['reserve_vh']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
            if ($upd > 0 && $trn) {
                mysql_query("COMMIT");
                echo json_encode(array(array("msgType" => 1, "msg" => "Order saved")));
            } else {
                mysql_query("ROLLBACK");
                echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
            }
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'oorder_select') {
        $oorder_id = $_POST['oorder_id'];
        $system->prepareSelectQueryForJSON("SELECT
cus_order.order_id,
cus_order.order_no,
cus_order.model_id,
cus_order.vh_year,
cus_order.vh_color,
cus_order.milage_max,
cus_order.vh_options,
cus_order.cus_conditions,
cus_order.order_actions,
cus_order.max_price,
cus_order.pay_advance,
cus_order.gb,
cus_order.cus_id,
cus_order.description,
cus_order.pay_comments,
cus_order.coordinator_id,
cus_order.order_date,
maker.maker_id,
cus_order.vh_reserved
FROM
cus_order
INNER JOIN maker_model ON cus_order.model_id = maker_model.mod_id
INNER JOIN maker ON maker_model.maker_id = maker.maker_id
WHERE
cus_order.order_id = '{$oorder_id}'");
    } else if ($_POST['action'] == 'order_updates') {
        $today = date('Y-m-d');
        $data = $_POST['order_update'];
        if (empty($data['order_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select Order")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `cus_order` SET `model_id`='{$data['model_ComboBox']}', `vh_year`='{$data['vehicle_year']}', `vh_color`='{$data['vehicle_colour']}', `milage_max`='{$data['vehicle_milage']}', `vh_options`='{$data['vehicle_options']}', `cus_conditions`='{$data['vehicle_cus_con']}', `order_actions`='{$data['vehicle_action']}', `max_price`='{$data['vehicle_price']}', `pay_advance`='{$data['vehicle_advance']}', `gb`='{$data['vehicle_gb']}', `cus_id`='{$data['customer_ComboBox']}', `description`='{$data['vehicle_desc']}', `pay_comments`='{$data['vehicle_pay_op']}', `coordinator_id`='{$data['coordinator_ComboBox']}', `order_date`='{$data['vehicle_ord_date']}' WHERE (`order_id`='{$data['order_id']}')") or die(mysql_error());

        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'cus_order-{$data['order_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "order updated")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not update")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'order_cancel') {
        $today = date('Y-m-d');
        if (empty($_POST['order_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select Order")));
            return;
        }
        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE vehicle
        INNER JOIN cus_order ON vehicle.vh_id = cus_order.vh_reserved
        SET `stock_status` = '1'
        WHERE cus_order.order_id = '{$_POST['order_id']}'") or die(mysql_error());

        $upd = mysql_query("UPDATE `cus_order` SET `order_status` = '99' WHERE (`order_id` = '{$_POST['order_id']}')") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'cancel-cus_order-{$_POST['order_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn && $upd) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "order canceled")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not process")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'add_vehicle') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }
//get next index number for vehicle
        $query = "SELECT IFNULL(MAX(vehicle.vh_index_num)+1,1) AS next_vh_no FROM vehicle";
        $result = mysql_query($query);
        $arr_nxtid = mysql_fetch_assoc($result);
        $nextnum = $arr_nxtid['next_vh_no'];
//get next code number for vehicle
        $substring_len = strlen($data['supp_code']) + 1;

        $res_curr_vh_code = mysql_query("SELECT SUBSTRING(vehicle.vh_code,{$substring_len}) AS vh_code_num
        FROM vehicle WHERE vehicle.record_status = '1' AND vehicle.supp_id = '{$data['supp_id']}'
        ORDER BY CAST(SUBSTRING(vehicle.vh_code,{$substring_len}) AS UNSIGNED) DESC LIMIT 1");
        $curr_vh_codenum = mysql_fetch_assoc($res_curr_vh_code);
        if (empty($curr_vh_codenum['vh_code_num'])) {
            $curr_vh_codenum['vh_code_num'] = 0;
        }
        $next_v_num = $curr_vh_codenum['vh_code_num'] + 1;
//        $vh_code = $data['supp_code'] . '-' . $next_v_num;
        $vh_code = $data['supp_code'] . $next_v_num;
//
        $insert_query = "INSERT INTO `vehicle` (`vh_index_num`,	`vh_code`,`supp_id`,`vh_maker_model`,`vh_chassis_code`,`vh_chassis_num`,
	`engine_code`,`engine_num`,`engine_cc`,`package`,`vh_year`,`vh_color`,`vh_milage`,`vh_options`,`fuel_type`,
	`transmission`,`seats`,`doors`,`eval_grade`,`drive_wheels`,`additional_options`,
	`bid_date`,`auction_name`,`lot_no`,`auction_grade`,`auc_display_price`,`auc_real_price`,`stock_location`,
	`stock_status`,`coordinator_id`,currency_type,vh_is_reg,`record_status`)
        VALUES 
	({$nextnum},'{$vh_code}','{$data['supp_id']}','{$data['model_combo']}','{$data['v_ch_code']}','{$data['v_ch_num']}',"
                . "'{$data['v_eng_code']}','{$data['v_eng_num']}','{$data['v_eng_cc']}','{$data['v_pckg']}','{$data['v_year']}','{$data['v_color']}','{$data['v_milage']}','{$data['v_opt']}','{$data['v_fuel']}',"
                . "'{$data['v_trans']}','{$data['v_seats']}','{$data['v_doors']}','{$data['v_eval']}','{$data['v_drive']}','{$data['v_other']}',"
                . "'{$data['v_bid']}','{$data['v_auct']}','{$data['v_lot']}','{$data['v_auct_grade']}','{$data['v_disp_price']}','{$data['v_auct_price']}','{$data['v_supp_country']}',
        '1','{$data['coord_id']}','{$data['v_currency']}','{$data['vh_is_reg']}','1');";

//        $trnsaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'maker_model', '{$today}', '{$_SESSION['user_id']}')";
        mysql_query("START TRANSACTION");
        $insert = mysql_query($insert_query) or die(mysql_error());
        $id = mysql_insert_id();
        $insert_modification = mysql_query("INSERT INTO `vehicle_modification`(`request_date`,`desc`,`vh_id`,`cus_id`,`sort_order`,`mod_status`,`options`,`other_opt`)VALUES ( '{$today}', 'initial status of vehicle', '{$id}', '0', '0', 'Default','{$data['v_opt']}','{$data['v_other']}');") or die(mysql_error());
//        $transaction = mysql_query($trnsaction_query);
        if ($insert) {
//            echo $id;
            mysql_query("COMMIT");
            echo json_encode(array("msgType" => 1, "msg" => "Vehicle Added.", "resp" => $id));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array("msgType" => 2, "msg" => "Couldn't Add Vehicle."));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'add_vehicle_local') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }
//get next index number for vehicle
        $query = "SELECT IFNULL(MAX(vehicle.vh_index_num)+1,1) AS next_vh_no FROM vehicle";
        $result = mysql_query($query);
        $arr_nxtid = mysql_fetch_assoc($result);
        $nextnum = $arr_nxtid['next_vh_no'];
//get next code number for vehicle
        $substring_len = strlen($data['supp_code']) + 1;

        $res_curr_vh_code = mysql_query("SELECT SUBSTRING(vehicle.vh_code,{$substring_len}) AS vh_code_num
        FROM vehicle WHERE vehicle.record_status = '1' AND vehicle.supp_id = '{$data['supp_id']}'
        ORDER BY CAST(SUBSTRING(vehicle.vh_code,{$substring_len}) AS UNSIGNED) DESC LIMIT 1");
        $curr_vh_codenum = mysql_fetch_assoc($res_curr_vh_code);
        if (empty($curr_vh_codenum['vh_code_num'])) {
            $curr_vh_codenum['vh_code_num'] = 0;
        }
        $next_v_num = $curr_vh_codenum['vh_code_num'] + 1;
//        $vh_code = $data['supp_code'] . '-' . $next_v_num;
        $vh_code = $data['supp_code'] . $next_v_num;
//
        $insert_query = "INSERT INTO `vehicle` (`vh_index_num`,	`vh_code`,`supp_id`,`vh_maker_model`,`vh_chassis_code`,`vh_chassis_num`,
	`engine_code`,`engine_num`,`engine_cc`,`package`,`vh_year`,`vh_color`,`vh_milage`,`vh_options`,`fuel_type`,
	`transmission`,`seats`,`doors`,`eval_grade`,`drive_wheels`,`additional_options`,
	`bid_date`,`auction_name`,`lot_no`,`auction_grade`,`auc_display_price`,`auc_real_price`,`stock_location`,
	`stock_status`,`coordinator_id`,currency_type,vh_is_reg,`record_status`)
        VALUES 
	({$nextnum},'{$vh_code}','{$data['supp_id']}','{$data['model_combo']}','{$data['v_ch_code']}','{$data['v_ch_num']}',"
                . "'-','-','{$data['v_eng_cc']}','{$data['v_pckg']}','{$data['v_year']}','{$data['v_color']}','{$data['v_milage']}','{$data['v_opt']}','{$data['v_fuel']}',"
                . "'{$data['v_trans']}','{$data['v_seats']}','{$data['v_doors']}','{$data['v_eval']}','{$data['v_drive']}','-',"
                . "'-','-','-','-','0','0','{$data['v_supp_country']}',"
                . "'1','{$data['coord_id']}','{$data['v_currency']}','{$data['vh_is_reg']}','1');";

//        $trnsaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'maker_model', '{$today}', '{$_SESSION['user_id']}')";
        mysql_query("START TRANSACTION");
        $insert = mysql_query($insert_query) or die(mysql_error());
        $id = mysql_insert_id();
        $insert_other = mysql_query("INSERT INTO `vehicle_other` "
                . "( `vh_id`, `vh_cif_val`, `foreign_rate`, `import_date`, `vh_import_duty`, `vh_clearing_charge`, `tax_nbt`, `tot_cost`, `vh_reg_num`, `vh_purchase_type` ) "
                . "VALUES ({$id},'{$data['v_cif']}', '{$data['yen_rate']}', '{$data['import_date']}', '{$data['duty']}', '{$data['vh_clearing']}', '{$data['nbt_rate']}', '{$data['v_cost']}', '-', '{$data['isexch']}')") or die(mysql_error());
//        $transaction = mysql_query($trnsaction_query);
        if ($insert && $insert_other) {
//            echo $id;
            mysql_query("COMMIT");
            echo json_encode(array("msgType" => 1, "msg" => "Vehicle Added.", "resp" => $id));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array("msgType" => 2, "msg" => "Couldn't Add Vehicle."));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'update_vehicle') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }
//
        $insert_query = "UPDATE `vehicle`
        SET `vh_maker_model` = '{$data['model_combo']}',`vh_chassis_num` = '{$data['v_ch_num']}',`vh_chassis_code` = '{$data['v_ch_code']}', `engine_code` = '{$data['v_eng_code']}',
         `engine_num` = '{$data['v_eng_num']}', `engine_cc` = '{$data['v_eng_cc']}', `package` = '{$data['v_pckg']}', `vh_year` = '{$data['v_year']}', `vh_color` = '{$data['v_color']}', `vh_milage` = '{$data['v_milage']}',
         `vh_options` = '{$data['v_opt']}', `fuel_type` = '{$data['v_fuel']}', `transmission` = '{$data['v_trans']}', `seats` = '{$data['v_seats']}', `doors` = '{$data['v_doors']}', `eval_grade` = '{$data['v_eval']}',
         `drive_wheels` = '{$data['v_drive']}', `additional_options` = '{$data['v_other']}', `bid_date` = '{$data['v_bid']}',`vh_is_reg` = '{$data['vh_is_reg']}', `currency_type` ='{$data['v_currency']}',`stock_location` ='{$data['st_location']}',
         `auction_name` = '{$data['v_auct']}', `lot_no` = '{$data['v_lot']}', `auction_grade` = '{$data['v_auct_grade']}', `auc_display_price` = '{$data['v_disp_price']}', `auc_real_price` = '{$data['v_auct_price']}',
         `coordinator_id` = '{$data['coord_id']}'
        WHERE (`vh_id` = '{$data['vh_id']}');";

        $trnsaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'vehicle-{$data['vh_id']}', '{$today}', '{$_SESSION['user_id']}')";

        mysql_query("START TRANSACTION");
        $insert = mysql_query($insert_query) or die(mysql_error());
        $transaction = mysql_query($trnsaction_query);
        if ($insert && $transaction) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Vehicle updated.")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Couldn't update Vehicle.")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'update_vehicle_local') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }
//
        $update_query = "UPDATE `vehicle`
        SET `vh_maker_model` = '{$data['model_combo']}',`vh_chassis_num` = '{$data['v_ch_num']}', `vh_chassis_code` = '{$data['v_ch_code']}',`engine_code` = '-',
         `engine_num` = '-', `engine_cc` = '{$data['v_eng_cc']}', `package` = '-', `vh_year` = '{$data['v_year']}', `vh_color` = '{$data['v_color']}', `vh_milage` = '{$data['v_milage']}',
         `vh_options` = '-', `fuel_type` = '{$data['v_fuel']}', `transmission` = '{$data['v_trans']}', `seats` = '{$data['v_seats']}', `doors` = '{$data['v_doors']}', `eval_grade` = '{$data['v_eval']}',
         `drive_wheels` = '{$data['v_drive']}', `additional_options` = '-', `bid_date` = '',`vh_is_reg` = '{$data['vh_is_reg']}', `currency_type` ='{$data['v_currency']}',`stock_location` ='{$data['st_location']}',
         `coordinator_id` = '{$data['coord_id']}'
        WHERE (`vh_id` = '{$data['vh_id']}');";
        $trnsaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'vehicle-{$data['vh_id']}', '{$today}', '{$_SESSION['user_id']}')";
        mysql_query("START TRANSACTION");
        $insert = mysql_query($update_query) or die(mysql_error());
        $upd_other = mysql_query("UPDATE `vehicle_other` SET `vh_cif_val` = '{$data['v_cif']}', `foreign_rate` = '{$data['yen_rate']}', `import_date` = '{$data['import_date']}', `vh_import_duty` = '{$data['duty']}', `vh_clearing_charge` = '{$data['vh_clearing']}', `tax_nbt` = '{$data['nbt_rate']}', `tot_cost` = '{$data['v_cost']}', `vh_purchase_type` = '{$data['isexch']}' WHERE vh_id = '{$data['vh_id']}';") or die(mysql_error());
        $transaction = mysql_query($trnsaction_query);
        if ($insert && $upd_other && $transaction) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Vehicle updated.")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Couldn't update Vehicle.")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'delete_order') {
//        $system->prepareCommandQueryForAlertify("DELETE FROM `cus_order` WHERE `order_id` = '{$_POST['delid']}'", "Successfully Deleted", "Sorry Could Not Be Deleted");
    } else if ($_POST['action'] == 'delete_imageFrom_galary') {
        $uploaddir = "../vehicle_img";
//        delete picture by V!raj
        $picture_id = $_POST['pic_Id'];

        $pic_data = mysql_query("SELECT
vehicle_photo.file_1,
vehicle_photo.file_2,
vehicle_photo.file_3,
vehicle_photo.vh_id,
vehicle.vh_code
FROM
vehicle_photo
INNER JOIN vehicle ON vehicle_photo.vh_id = vehicle.vh_id
WHERE
vehicle_photo.ph_id ='{$picture_id}'");

        if ($pic_data) {
            if (mysql_num_rows($pic_data) > 0) {
//has data
                while ($row1 = mysql_fetch_array($pic_data)) {
                    $img_1 = $row1['file_1'];
                    $img_2 = $row1['file_2'];
                    $img_3 = $row1['file_3'];
                    $veh_dir = $row1['vh_code'] . '_' . $row1['vh_id'];
                }
/// delete images
                $f_1 = unlink($uploaddir . "/" . $veh_dir . "/" . $img_1);
                $f_2 = unlink($uploaddir . "/" . $veh_dir . "/" . $img_2);
                $f_3 = unlink($uploaddir . "/" . $veh_dir . "/" . $img_3);
                $files_removed = FALSE;
                if ($f_1 && $f_2 && $f_3) {
                    $files_removed = TRUE;
                }
                $delete_record = mysql_query("DELETE FROM `vehicle_photo` WHERE (`ph_id`='{$picture_id}')");
                if ($delete_record && $files_removed) {
                    echo json_encode(array(array("msgType" => 1, "msg" => "Successfully deleted")));
                } else if ($delete_record && !$files_removed) {
                    echo json_encode(array(array("msgType" => 2, "msg" => "Reference deleted,File may still exist")));
                } else {
                    echo json_encode(array(array("msgType" => 2, "msg" => "Could not Delete")));
                }
            } else {
//no data
                echo json_encode(array(array("msgType" => 2, "msg" => "No data to process..!")));
            }
        } else {
            echo json_encode(array(array("msgType" => 2, "msg" => "Internel error..!")));
        }
    } else if ($_POST['action'] == 'get_vh_mod_info') {

        $vh_id = $_POST['vh_id'];
        $system->prepareSelectQueryForJSON("SELECT vehicle.vh_options,vehicle.additional_options FROM vehicle WHERE vehicle.vh_id = '{$vh_id}'");
    } else if ($_POST['action'] == 'image_vicible_statusChange') {
        $system->prepareCommandQueryForAlertify("UPDATE `vehicle_photo` SET `p_visible`='{$_POST['vi_status']}' WHERE (`ph_id`='{$_POST['img_id']}')", "Successful", "Error..!");
    } else if ($_POST['action'] == 'get_vh_info') {
        $vh_id = $_POST['vh_id'];
        $system->prepareSelectQueryForJSON("SELECT
vehicle.vh_id,vehicle.vh_index_num,
vehicle.vh_code,vehicle.supp_id,
vehicle.vh_maker_model,vehicle.vh_chassis_code,
vehicle.vh_chassis_num,vehicle.engine_code,
vehicle.engine_num,vehicle.engine_cc,
vehicle.package,vehicle.vh_year,
vehicle.vh_color,vehicle.vh_milage,
vehicle.vh_options,vehicle.fuel_type,
vehicle.transmission,vehicle.seats,
vehicle.doors,vehicle.eval_grade,
vehicle.drive_wheels,vehicle.additional_options,
maker_model.mod_name,maker.maker_name,
vehicle.coordinator_id,stock_location,
maker_model.mod_id,
maker.maker_id,
vehicle.currency_type,
vehicle.bid_date,
vehicle.auction_name,
vehicle.lot_no,
vehicle.auction_grade,
vehicle.auc_display_price,
vehicle.auc_real_price,
vehicle.vh_is_reg
FROM vehicle
INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
INNER JOIN maker ON maker_model.maker_id = maker.maker_id WHERE vehicle.vh_id = '{$vh_id}'");
    } else if ($_POST['action'] == 'get_vh_info_local') {
//  **************** local vehicle sytem *************************************
        $vh_id = $_POST['vh_id'];
        $system->prepareSelectQueryForJSON("SELECT
        vehicle.vh_id,
        vehicle.vh_index_num,
        vehicle.vh_code,
        vehicle.supp_id,
        vehicle.vh_maker_model,
        vehicle.vh_chassis_code,
        vehicle.vh_chassis_num,
        vehicle.engine_cc,
        vehicle.package,
        vehicle.vh_year,
        vehicle.vh_color,
        vehicle.vh_milage,
        vehicle.vh_options,
        vehicle.fuel_type,
        vehicle.eval_grade,
        vehicle.drive_wheels,
        maker_model.mod_name,
        maker.maker_name,
        vehicle.coordinator_id,
        vehicle.stock_location,
        maker_model.mod_id,
        maker.maker_id,
        vehicle.currency_type,
        vehicle.bid_date,
        vehicle.auc_display_price,
        vehicle.auc_real_price,
        vehicle.vh_is_reg,
        vehicle_other.vh_cif_val,
        vehicle_other.foreign_rate,
        (vehicle_other.vh_cif_val * vehicle_other.foreign_rate) AS lkr_val,
        vehicle_other.import_date,
        vehicle_other.vh_import_duty,
        vehicle_other.vh_clearing_charge,
        vehicle_other.tax_nbt,
        vehicle_other.tot_cost,
        vehicle_other.vh_purchase_type
        FROM
        vehicle
        INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
        INNER JOIN maker ON maker_model.maker_id = maker.maker_id
        INNER JOIN vehicle_other ON vehicle_other.vh_id = vehicle.vh_id
        WHERE vehicle.vh_id = '{$vh_id}'");
    } else if ($_POST['action'] == 'get_selected_modd_data') {
        $modd_id = $_POST['modd_id'];
        $system->prepareSelectQueryForJSON("SELECT
vehicle_modification.mod_id,
vehicle_modification.request_date,
vehicle_modification.`desc` AS ddsc,
vehicle_modification.vh_id,
vehicle_modification.cus_id,
vehicle_modification.sort_order,
vehicle_modification.mod_status,
vehicle_modification.`options` AS opp,
vehicle_modification.other_opt
FROM
vehicle_modification
WHERE
vehicle_modification.mod_id = '{$modd_id}'");
    } else if ($_POST['action'] == 'vehModification_update') {
        $today = date('Y-m-d');
        $data = $_POST['forms_data'];
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `vehicle_modification` SET `request_date`='{$data['modi_date']}', `desc`='{$data['modi_desc']}', `vh_id`='{$data['modi_vehicle']}', `cus_id`='{$data['modi_custmr']}', `options`='{$data['modi_options']}', `other_opt`='{$data['modi_other_opt']}' WHERE (`mod_id`='{$data['modd_id']}')") or die(mysql_error());

        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'vehicle_modification-{$data['modd_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "order updated")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not update")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'delete_modific') {
//Sam_Rulz
        $today = date('Y-m-d');
        $moddi_id = $_POST['moddi_id'];
        $delete_query = "DELETE FROM `vehicle_modification` WHERE (`mod_id` = $moddi_id)";
        $transaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'vehicle_modification-{$moddi_id}', '{$today}', '{$_SESSION['user_id']}')";

        mysql_query("START TRANSACTION");
        $delete = mysql_query($delete_query);
        $transaction = mysql_query($transaction_query);
        if ($delete && $transaction) {
            mysql_query('COMMIT');
            echo json_encode(array(array("msgType" => 1, "msg" => "Successfully Deleted.")));
        } else {
            mysql_query('ROLLBACK');
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Be Deleted.")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'get_photo_count') {
        $vh_id = $_POST['vh_id'];
        $system->prepareSelectQueryForJSONSingleData("SELECT COUNT(vehicle_photo.ph_id) AS ph_count
FROM vehicle INNER JOIN vehicle_photo ON vehicle_photo.vh_id = vehicle.vh_id
WHERE vehicle_photo.vh_id = '{$vh_id}'");
    }
    //
    else if ($_POST['action'] == 'add_temp_entry') {
        $data = $_POST['vh_data'];

        mysql_query("START TRANSACTION");
        // delete 
        mysql_query("DELETE FROM proforma_inv WHERE proforma_inv.pi_date < CURRENT_DATE () AND proforma_inv.pi_status = '98'");
        mysql_query("INSERT INTO `proforma_inv` ( `pi_date`, `cus_id`, `pi_status` ) VALUES (CURRENT_DATE(), 0, '98');");

        $ref_id = mysql_insert_id();
//        echo $ref_id;
        if (!empty($data) && $ref_id > 0) {
            foreach ($data as $key => $value) {
                $price_res = mysql_query("SELECT IF(vehicle.auc_display_price=0,vehicle.auc_real_price,vehicle.auc_display_price) AS vh_price
                            FROM vehicle
                            WHERE vehicle.vh_id = '{$value}'");
                $vh_price = mysql_fetch_assoc($price_res);
//                $ins = mysql_query("INSERT INTO `temp_entries` (`temp_id`, `sel_id`) VALUES ({$ref_id},'{$value}');") or die(mysql_error());
                $ins = mysql_query("INSERT INTO `pi_entries` (`pi_id`, `vh_id`) VALUES ({$ref_id},'{$value}');") or die(mysql_error());
            }
        }
        if ($ins) {
            mysql_query("COMMIT");
            echo json_encode($ref_id);
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(0);
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'add_bank') {
        $data = $_POST['form_data'];
        if (strlen($data['bank_name']) > 0) {
            foreach ($data as $key => $value) {
                $data[$key] = mysql_real_escape_string($data[$key]);
            }

            $ins = mysql_query("INSERT INTO `supp_bank` (`bank_name`,`swift`,`branch`,`ac_num`) VALUES ( '{$data['bank_name']}',UPPER('{$data['bank_swift']}'),'{$data['branch']}','{$data['bank_account']}')") or die(mysql_error());

            if ($ins) {
                echo json_encode(array(array("msgType" => 1, "msg" => "Bank Added")));
            } else {
                echo json_encode(array(array("msgType" => 2, "msg" => "Could not add Bank")));
            }
            MainConfig::closeDB();
        }
    } else if ($_POST['action'] == 'suppbank_select') {
        $bank_id = $_POST['bank_id'];
        $system->prepareSelectQueryForJSON("SELECT
       supp_bank.bank_name,
        supp_bank.bank_id,
        supp_bank.swift,
        supp_bank.branch,
        supp_bank.ac_num
        FROM
        supp_bank
        WHERE
        supp_bank.bank_id= '{$bank_id}'");
        //
    } else if ($_POST['action'] == 'bank_update') {
        $today = date('Y-m-d');
        $form = $_POST['form_data'];
        if (empty($form['bank_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Bank to update")));
            return;
        }
        if (empty($form['bank_name'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a Bank Name")));
            return;
        }
        foreach ($form as $key => $value) {
            $form[$key] = mysql_real_escape_string($form[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `supp_bank`
        SET 
         `bank_name` = '{$form['bank_name']}',
         `swift` = '{$form['bank_swift']}',
         `branch` = '{$form['branch']}',
         `ac_num` = '{$form['bank_account']}'
        WHERE
	(`bank_id` = '{$form['bank_id']}');") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'supp_bank-{$form['bank_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Bank saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
        //
    } else if ($_POST['action'] == 'delete_supp_bank') {
//Sam_Rulz
        $today = date('Y-m-d');
        $bank_id = $_POST['bank_id'];
        $delete_query = "DELETE FROM supp_bank WHERE supp_bank.bank_id='$bank_id'";
        $transaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'Bank', '{$today}', '{$_SESSION['user_id']}')";

        mysql_query("START TRANSACTION");
        $delete = mysql_query($delete_query);
        $transaction = mysql_query($transaction_query);
        if ($delete && $transaction) {
            mysql_query('COMMIT');
            echo json_encode(array(array("msgType" => 1, "msg" => "Successfully Deleted.")));
        } else {
            mysql_query('ROLLBACK');
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Be Deleted.")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'add_proinv') {
        $data = $_POST['form_data'];
        $today = date('Y-m-d');
        if (empty($data['ref_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "cannot proceed.refresh the page or cancel and re-enter the invoice")));
            return;
        }
        if (empty($data['inv_date'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Invoice Data")));
            return;
        }
        if (empty($data['proinv_num'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Invalid Invoice Number")));
            return;
        }
        if (empty($data['cus_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Customer")));
            return;
        }
        if (empty($data['suppbank_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Bank")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `proforma_inv` SET
            `pi_no`='{$data['proinv_num']}',
            `pi_date`='{$data['inv_date']}',
            `cus_id`='{$data['cus_id']}',
            `currency`='{$data['inv_currency']}',
            `consignee_name`='{$data['consignee_name']}',
            `consignee_address`='{$data['consignee_address']}',
            `port_loading` ='{$data['port_loading']}',
            `port_discharge`='{$data['port_discharge']}',
            `shipment_time`='{$data['ship_time']}',
            `payment_term`='{$data['pay_term']}',
            `validity`='{$data['validity_time']}',
            `total_cif`={$data['tot_cif']},
            `partial_shipment`='{$data['inv_partial_ship']}',
            `transshipment`='{$data['inv_transship']}',
            `presentation_period`='{$data['presentaion_period']}',
            `last_shipment_date`='{$data['last_ship_date']}',
            `lc_charges`='{$data['lc_charges']}',
            `hs_code`='{$data['hs_code']}',
            `confirmation`= '{$data['confirm']}',
            `lc_advice`='{$data['advice_lc']}',`supp_id`='{$data['supp_id']}',pi_type='{$data['inv_type']}',
            `advising_bank_id` ='{$data['suppbank_id']}', pi_status='1', pi_sent='0' WHERE pi_id='{$data['ref_id']}'") or die(mysql_error());
        $upd = mysql_query("UPDATE vehicle SET stock_status='3'
            WHERE vehicle.vh_id IN (
                SELECT pi_entries.vh_id FROM
                proforma_inv INNER JOIN pi_entries ON pi_entries.pi_id = proforma_inv.pi_id
                WHERE proforma_inv.pi_id = '{$data['ref_id']}'
            )");
//        $insert_id = mysql_insert_id();
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'invoice_proForma-completed-{{$data['ref_id']}}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Invoice saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    }
    //
    else if ($_POST['action'] == 'get_inv_suppid') {
        $ref_id = $_POST['ref_id'];
        $system->prepareSelectQueryForJSON("SELECT
        vehicle.supp_id
        FROM pi_entries
        INNER JOIN vehicle ON pi_entries.vh_id = vehicle.vh_id
        WHERE pi_entries.pi_id = '{$ref_id}'
        ORDER BY vehicle.vh_code ASC
        LIMIT 1");
        //
    }//
    else if ($_POST['action'] == 'load_inv_foredit') {
        $ref_id = $_POST['ref_id'];
        $system->prepareSelectQueryForJSON("SELECT
        customer.cus_id,
        customer.cus_inv_name,
        proforma_inv.pi_id,
        proforma_inv.pi_no,
        proforma_inv.pi_date,
        proforma_inv.consignee_name,
        proforma_inv.consignee_address,
        proforma_inv.port_loading,
        proforma_inv.port_discharge,
        proforma_inv.shipment_time,
        proforma_inv.payment_term,
        proforma_inv.validity,
        proforma_inv.total_cif,
        proforma_inv.partial_shipment,
        proforma_inv.transshipment,
        proforma_inv.presentation_period,
        proforma_inv.last_shipment_date,
        proforma_inv.lc_charges,
        proforma_inv.hs_code,
        proforma_inv.confirmation,
        proforma_inv.lc_advice,
        proforma_inv.currency
        FROM
        proforma_inv
        INNER JOIN customer ON customer.cus_id = proforma_inv.cus_id
        WHERE
        proforma_inv.pi_id = '{$ref_id}'");
        //
    } else if ($_POST['action'] == 'load_supp_currency') {
        $supp_id = $_POST['supp_id'];
        $system->prepareSelectQueryForJSON("SELECT
        supplier.supp_currency
        FROM
        supplier
        WHERE
        supplier.supp_id = '{$supp_id}'");
    } else if ($_POST['action'] == 'load_supp_bank') {
        $supp_id = $_POST['supp_id'];
        $system->prepareSelectQueryForJSON("SELECT
        supp_bank.bank_name,
        supp_bank.bank_id,
        supp_bank.swift
        FROM
        supplier
        INNER JOIN supp_bank ON supp_bank.bank_id = supplier.bank_id
        WHERE
        supp_bank.bank_status = '1' AND
        supplier.supp_id = '{$supp_id}'");
    } //
    else if ($_POST['action'] == 'getInv_cif_values') {
        $ref_id = $_POST['ref_id'];
        $system->prepareSelectQueryForJSON("SELECT
        pi_entries.freight,
        pi_entries.insuarance
        FROM
        pi_entries
        WHERE
        pi_entries.pi_id = '$ref_id'
        LIMIT 1");
        //
    } elseif ($_POST['action'] == 'cancel_proforma_inv') {
        $pi_id = $_POST['pi_id'];
        $today = date('Y-m-d');

        mysql_query("START TRANSACTION");
        mysql_query("DELETE FROM proforma_inv WHERE proforma_inv.pi_id='$pi_id'") or die(mysql_error());
        $del = mysql_affected_rows();
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'ProForma Invoice canceled', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($del > 0 && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Invoice Canceled")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not cancel")));
        }
        MainConfig::closeDB();
    }
    // Customer LEASING Co
    else if ($_POST['action'] == 'add_lease_co') {
        $data = $_POST['form_data'];
        if (strlen($data['co_name']) > 0) {
            foreach ($data as $key => $value) {
                $data[$key] = mysql_real_escape_string($data[$key]);
            }

            $ins = mysql_query("INSERT INTO leasing(ls_name,ls_address,ls_contact,ls_status) VALUES ( '{$data['co_name']}','{$data['co_address']}','','1')") or die(mysql_error());

            if ($ins) {
                echo json_encode(array(array("msgType" => 1, "msg" => "Leasing Company Added")));
            } else {
                echo json_encode(array(array("msgType" => 2, "msg" => "Could not add")));
            }
            MainConfig::closeDB();
        }
    } else if ($_POST['action'] == 'lease_co_select') {
        $co_id = $_POST['co_id'];
        $system->prepareSelectQueryForJSON("SELECT
        leasing.ls_id,
        leasing.ls_name,
        leasing.ls_address,
        leasing.ls_contact,
        leasing.ls_status
        FROM
        leasing
        WHERE
        leasing.ls_id = '{$co_id}'");
        //
    } else if ($_POST['action'] == 'lease_co_update') {
        $today = date('Y-m-d');
        $form = $_POST['form_data'];
        if (empty($form['co_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select an entry update")));
            return;
        }
        if (empty($form['co_name'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a Name")));
            return;
        }
        foreach ($form as $key => $value) {
            $form[$key] = mysql_real_escape_string($form[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE leasing
            SET ls_name = '{$form['co_name']}',
             ls_address = '{$form['co_address']}'
            WHERE
            (`ls_id` = '{$form['co_id']}');") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Leasing Company', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Bank saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
        //
    } else if ($_POST['action'] == 'delete_lease_co') {
//Sam_Rulz
        $today = date('Y-m-d');
        $lease_id = $_POST['lease_id'];
        $delete_query = "DELETE FROM leasing WHERE leasing.ls_id ='$lease_id'";
        $transaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'Leasing Co-{$lease_id}', '{$today}', '{$_SESSION['user_id']}')";

        mysql_query("START TRANSACTION");
        $delete = mysql_query($delete_query);
        $transaction = mysql_query($transaction_query);
        if ($delete && $transaction) {
            mysql_query('COMMIT');
            echo json_encode(array(array("msgType" => 1, "msg" => "Successfully Deleted.")));
        } else {
            mysql_query('ROLLBACK');
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Be Deleted.")));
        }
        MainConfig::closeDB();
        //
    } else if ($_POST['action'] == 'cancel_proFormaInvoice') {
        //@viraj
        $today = date('Y-m-d');
        $err = 0;

        $update_status = mysql_query("UPDATE `proforma_inv` SET `pi_status` = '90' WHERE (`pi_id` = '{$_POST['inv_id']}')");
        if (!$update_status) {
            $err++;
        }

        $vehStatusChange = mysql_query("UPDATE vehicle SET stock_status='1' 
            WHERE vehicle.vh_id IN (SELECT pi_entries.vh_id FROM
                proforma_inv INNER JOIN pi_entries ON pi_entries.pi_id = proforma_inv.pi_id
                WHERE proforma_inv.pi_id = '{$_POST['inv_id']}' )");
        if (!$vehStatusChange) {
            $err++;
        }
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) "
                . "VALUES ('CANCEL', 'invoice_proFormacanceled', '{$today}', '{$_SESSION['user_id']}')");
        if (!$trn) {
            $err++;
        }
//        exit;
        ////// all done
        if ($err == 0) {
            mysql_query('COMMIT');
            echo json_encode(array(array("msgType" => 1, "msg" => "Successfully Canceled.")));
        } else {
            mysql_query('ROLLBACK');
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Be Cancel.")));
        }
    } else if ($_POST['action'] == 'add_syscode') {
        $data = $_POST['form_data'];
        if (empty($data['code_type'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a category")));
            return;
        }
        if (empty($data['syscode_desc'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a text")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        $select_nextcode = "SELECT IFNULL(MAX(syscode.`code`)+1,1) AS next_code
        FROM syscode
        WHERE syscode.type = '{$data['code_type']}'";
        $res_nextcode = mysql_query($select_nextcode);
        $nextcode_arr = mysql_fetch_assoc($res_nextcode);
        $insert_query = "INSERT INTO syscode(
            type,
            code,
            description,
            remarks
        ) VALUES ('{$data['code_type']}', '{$nextcode_arr['next_code']}', '{$data['syscode_desc']}', '{$data['syscode_remarks']}');";

        $insert = mysql_query($insert_query) or die(mysql_error());
        if ($insert) {
            echo json_encode(array(array("msgType" => 1, "msg" => "record added")));
        } else {
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not add")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'syscode_select') {
        $sys_id = $_POST['sys_code'];
        $system->prepareSelectQueryForJSON("SELECT
	syscode.description,
	syscode.sys_id,
	syscode.remarks,
	syscode.`code`,
	syscode.type
        FROM
	syscode
        WHERE
	syscode.type ='{$sys_id}'");
        //
    } else if ($_POST['action'] == 'syscode_update') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['sys_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a valid record")));
            return;
        }
        if (empty($data['code_type'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a category")));
            return;
        }
        if (empty($data['syscode_desc'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a text")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `syscode`
            SET `description` = '{$data['syscode_desc']}',`remarks` = '{$data['syscode_remarks']}'
            WHERE (`sys_id` = '{$data['sys_id']}');") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'System code', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Record updated")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not update")));
        }
        MainConfig::closeDB();
        //
    } else if ($_POST['action'] == 'delete_syscode') {
        $today = date('Y-m-d');
        $sys_id = $_POST['sys_id'];
        $delete_query = "DELETE FROM syscode WHERE `sys_id` = '$sys_id'";
        $transaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'System Code-{$sys_id}', '{$today}', '{$_SESSION['user_id']}')";

        mysql_query("START TRANSACTION");
        $delete = mysql_query($delete_query);
        $transaction = mysql_query($transaction_query);
        if ($delete && $transaction) {
            mysql_query('COMMIT');
            echo json_encode(array(array("msgType" => 1, "msg" => "Successfully Deleted.")));
        } else {
            mysql_query('ROLLBACK');
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Be Deleted.")));
        }
        MainConfig::closeDB();
        //
    } else if ($_POST['action'] == 'add_colors_for_trs') {
        $vh_data = $_POST['vh_data'];
        $color = $_POST['clr_code'];
        $err = 0;
        mysql_query("START TRANSACTION");
        foreach ($vh_data as $v) {
            $queryy = mysql_query("UPDATE `vehicle` SET `color_group` = '{$color}' WHERE (`vh_id` = '{$v}')");
            if (!$queryy) {
                $err++;
            }
        }
        if ($err == 0) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Color Added")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Error !")));
        }
    } else if ($_POST['action'] == 'add_clearing_item') {
        //@Ashan
        $vh_data = $_POST['vh_data'];
        $clearing_item = $_POST['clearing_item'];
        $item_value = $_POST['item_value'];
        $database_column = array('', 'shipped_date', 'vessel', 'refunds', 'arrival_date', 'duty', 'clr_date', 'lc_no');
        $err = 0;
        mysql_query("START TRANSACTION");
        foreach ($vh_data as $v) {
            $in_query = "INSERT INTO vh_clearing (vh_id,{$database_column[$clearing_item]}) VALUES ('{$v}', '{$item_value}')"
                    . " ON DUPLICATE KEY UPDATE {$database_column[$clearing_item]} = '$item_value'";
            $queryy = mysql_query($in_query) or die(mysql_error());
            if (!$queryy) {
                $err++;
            }
        }
        if ($err == 0) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Clearing Data Changed")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Error !")));
        }
    } else if ($_POST['action'] == 'vh_cif_update') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['ref_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "invalid invoice")));
            return;
        }
        if (empty($data['vh_ins'])) {
            $data['vh_ins'] = 0;
        }
        if (empty($data['vh_freight'])) {
            $data['vh_freight'] = 0;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `pi_entries`
            SET `freight` = '{$data['vh_freight']}',
             `insuarance` = '{$data['vh_ins']}',
             `tot_amt` = vh_amt+{$data['vh_freight']}+{$data['vh_ins']},
             `other` = '0'
            WHERE (`pi_id` = '{$data['ref_id']}');") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'pi_entries-amounts', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "CIF updated")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not update")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'vh_fob_update') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['ref_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "invalid selection")));
            return;
        }
        if (empty($data['vh_fob'])) {
            $data['vh_fob'] = 0;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `pi_entries`
            SET `vh_amt` = '{$data['vh_fob']}',
             `tot_amt` = freight+insuarance+{$data['vh_fob']}
            WHERE (`pi_entry_id` = '{$data['ref_id']}');") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'pi_entries-FOB', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "CIF updated")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not update")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'select_homepg_content') {
        $wh_id = $_POST['wh_id'];
        $system->prepareSelectQueryForJSON("SELECT
        web_homepg.wh_head1,
        web_homepg.wh_head2,
        web_homepg.wh_content,
        web_homepg.order,
        web_homepg.wh_id
        FROM
        web_homepg
        WHERE
        web_homepg.wh_id = '{$wh_id}'");
    } else if ($_POST['action'] == 'homepg_content_update') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['wh_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a valid record")));
            return;
        }
//        if (empty($data['heading_1'])) {
//            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a heading 1")));
//            return;
//        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE web_homepg SET wh_head1= '{$data['heading_1']}',`wh_head2`= '{$data['heading_2']}',`wh_content`='{$data['description']}',`order`= '{$data['content_order']}' WHERE (`wh_id`= '{$data['wh_id']}')") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Web-Homepg-{$data['wh_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Record updated")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not update")));
        }
        MainConfig::closeDB();
        //
    } else if ($_POST['action'] == 'delete_web_homepg') {
        $today = date('Y-m-d');
        $wh_id = $_POST['wh_id'];
        $imgfile = $_POST['imgfile'];

        if (empty($wh_id)) {
            echo json_encode(array(array("msgType" => 2, "msg" => "invalid content delete request")));
            return;
        }
//        if (empty($imgfile)) {
//            echo json_encode(array(array("msgType" => 2, "msg" => "invalid image file")));
//            return;
//        }
        $delete_query = "DELETE FROM web_homepg WHERE web_homepg.wh_id = '{$wh_id}'";
        $transaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'Web-Homepg-{$wh_id}', '{$today}', '{$_SESSION['user_id']}')";

        mysql_query("START TRANSACTION");
        $delete = mysql_query($delete_query);
        $uploaddir = "../images/web";
        $isdeleted = unlink($uploaddir . "/" . $imgfile);
        $transaction = mysql_query($transaction_query);
        if ($delete && $isdeleted && $transaction) {
            mysql_query('COMMIT');
            echo json_encode(array(array("msgType" => 1, "msg" => "Successfully Deleted.")));
        } else {
            mysql_query('ROLLBACK');
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not delete")));
        }
        MainConfig::closeDB();
        //
    } else if ($_POST['action'] == 'add_spec') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['spec_title'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a specification title")));
            return;
        }
        if (empty($data['spec_model'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a vehicle model")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        $insert_query = "INSERT INTO `vh_tech_spec` (`mod_id`,`spec_title`,`eng_cylinder`,`eng_cc`,`eng_layout`,`eng_hpower`,`eng_rpm`,
        `eng_torque`,`eng_comp_ratio`,`perf_max_speed`,`perf_accelration`,`trans_type`,`trans_desc`,
        `fuel_cons_city`,`fuel_cons_highway`,`bd_len`,`bd_wid`,`bd_hei`,`bd_wheelbase`,
        `bd_maxpayload`,`bd_curb_weight`,`cap_fuel_tank`,`cap_luggage`)
        VALUES
        ( '{$data['spec_model']}','{$data['spec_title']}', '{$data['eng_cylinder']}','{$data['eng_cc']}','{$data['eng_layout']}','{$data['eng_hpower']}','{$data['eng_rpm']}',
          '{$data['eng_torque']}','{$data['eng_comp_ratio']}', '{$data['perf_max_speed']}','{$data['perf_accelration']}','{$data['trans_type']}','{$data['trans_desc']}',"
                . "'{$data['fuel_cons_city']}', '{$data['fuel_cons_highway']}','{$data['bd_len']}','{$data['bd_wid']}','{$data['bd_hei']}', '{$data['bd_wheelbase']}',"
                . "'{$data['bd_maxpayload']}', '{$data['bd_curb_weight']}', '{$data['cap_fuel_tank']}', '{$data['cap_luggage']}'
         )";

        $trnsaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'V_Spec', '{$today}', '{$_SESSION['user_id']}')";


        mysql_query("START TRANSACTION");
        $insert = mysql_query($insert_query) or die(mysql_error());
        $transaction = mysql_query($trnsaction_query);
        if ($insert && $transaction) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Record Added.")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Couldn't save the record.")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'spec_select') {
        $spec_id = $_POST['spec_id'];
        $system->prepareSelectQueryForJSON("SELECT
            vh_tech_spec.spec_title,
            vh_tech_spec.spec_id,
            vh_tech_spec.eng_cc,
            vh_tech_spec.eng_rpm,
            vh_tech_spec.perf_max_speed,
            vh_tech_spec.trans_type,
            vh_tech_spec.fuel_cons_highway,
            vh_tech_spec.bd_curb_weight,
            vh_tech_spec.cap_fuel_tank,
            vh_tech_spec.mod_id,
            vh_tech_spec.eng_cylinder,
            vh_tech_spec.eng_layout,
            vh_tech_spec.eng_hpower,
            vh_tech_spec.eng_torque,
            vh_tech_spec.eng_comp_ratio,
            vh_tech_spec.perf_accelration,
            vh_tech_spec.trans_desc,
            vh_tech_spec.fuel_cons_city,
            vh_tech_spec.bd_len,
            vh_tech_spec.bd_wid,
            vh_tech_spec.bd_hei,
            vh_tech_spec.bd_wheelbase,
            vh_tech_spec.bd_maxpayload,
            vh_tech_spec.cap_luggage
            FROM
            vh_tech_spec
            WHERE
            vh_tech_spec.spec_id = '$spec_id'");
        //
    } elseif ($_POST['action'] == 'delete_spec') {
        $spec_id = $_POST['spec_id'];
        $today = date('Y-m-d');

        mysql_query("START TRANSACTION");
        $ins = mysql_query("DELETE FROM vh_tech_spec WHERE vh_tech_spec.spec_id = '$spec_id'");
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'V_spec-{$spec_id}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Specification Deleted")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not delete")));
        }
        MainConfig::closeDB();
        //
    } else if ($_POST['action'] == 'update_spec') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['spec_title'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a specification title")));
            return;
        }
        if (empty($data['spec_model'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a vehicle model")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }


        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `vh_tech_spec`
            SET 
             `mod_id` = '{$data['spec_model']}',
             `spec_title` ='{$data['spec_title']}' ,
             `eng_cylinder` ='{$data['eng_cylinder']}' ,
             `eng_cc` = '{$data['eng_cc']}',
             `eng_layout` = '{$data['eng_layout']}',
             `eng_hpower` ='{$data['eng_hpower']}' ,
             `eng_rpm` ='{$data['eng_rpm']}' ,
             `eng_torque` = '{$data['eng_torque']}',
             `eng_comp_ratio` = '{$data['eng_comp_ratio']}',
             `perf_max_speed` = '{$data['perf_max_speed']}',
             `perf_accelration` = '{$data['perf_accelration']}',
             `trans_type` = '{$data['trans_type']}',
             `trans_desc` = '{$data['trans_desc']}',
             `fuel_cons_city` = '{$data['fuel_cons_city']}',
             `fuel_cons_highway` = '{$data['fuel_cons_highway']}',
             `bd_len` = '{$data['bd_len']}',
             `bd_wid` = '{$data['bd_wid']}',
             `bd_hei` = '{$data['bd_hei']}',
             `bd_wheelbase` = '{$data['bd_wheelbase']}',
             `bd_maxpayload` = '{$data['bd_maxpayload']}',
             `bd_curb_weight` = '{$data['bd_curb_weight']}',
             `cap_fuel_tank` = '{$data['cap_fuel_tank']}',
             `cap_luggage` = '{$data['cap_luggage']}'
            WHERE
                    (`spec_id` = '{$data['spec_id']}');") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'V_Spec-{$data['spec_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Specification saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'add_vh_webdata') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['vh_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a vehicle")));
            return;
        }
        if (empty($data['display_price'])) {
            $data['display_price'] = 0;
//            echo json_encode(array(array("msgType" => 2, "msg" => "Enter Display Price")));
//            return;
        }
        if (empty($data['spec_id'])) {
            $data['spec_id'] = 0;
//            echo json_encode(array(array("msgType" => 2, "msg" => "Select technical specification")));
//            return;
        }
        $data['display_price'] = mysql_real_escape_string($data['display_price']);
        //
        $sel_data = $data['show_data'];
        $show_data_cus = 0;
        $show_data_coordinator = 0;
        //
        switch ($sel_data) {
            case 'da':
                $show_data_cus = 1;
                $show_data_coordinator = 1;
                break;
            case 'dc':
                $show_data_coordinator = 1;
                break;
            default:
                $show_data_cus = 0;
                $show_data_coordinator = 0;
                break;
        }
        $sel_price = $data['show_price'];
        $show_price_cus = 0;
        $show_price_coordinators = 0;
        switch ($sel_price) {
            case 'pa':
                $show_price_cus = 1;
                $show_price_coordinators = 1;
                break;
            case 'pc':
                $show_price_coordinators = 1;
                break;
            default:
                $show_price_cus = 0;
                $show_price_coordinators = 0;
                break;
        }
        //
        mysql_query("START TRANSACTION");
        $Qupd_vh_price = "UPDATE `vehicle` SET `vh_disp_price` = {$data['display_price']},stock_status={$data['stock_status']} WHERE (`vh_id` = '{$data['vh_id']}');";
        $Q1 = mysql_query($Qupd_vh_price) or die(mysql_error());
        //
        $Qins_vh_webdata = "INSERT INTO web_vh_data (vh_id,show_data_cus,show_price_cus,show_data_coordinator,show_price_coordinator,spec_id,disp_currency)
        VALUES ('{$data['vh_id']}', {$show_data_cus}, {$show_price_cus}, {$show_data_coordinator}, {$show_price_coordinators}, {$data['spec_id']},'{$data['currency']}') 
        ON DUPLICATE KEY UPDATE show_data_cus = {$show_data_cus},
	show_price_cus = {$show_price_cus}, show_data_coordinator = {$show_data_coordinator}, show_price_coordinator = {$show_price_coordinators}, spec_id = {$data['spec_id']},disp_currency='{$data['currency']}'";
        $Q2 = mysql_query($Qins_vh_webdata) or die(mysql_error());
        //
        echo $Qins_vh_webdata;
        $del_features = "DELETE FROM vh_features WHERE vh_features.vh_id = '{$data['vh_id']}'";
        $Q3 = mysql_query($del_features) or die(mysql_error());
        //
        if (!empty($data['featureIDs'])) {
            foreach ($data['featureIDs'] as $ft_id) {
                $Qins_vh_features = "INSERT INTO `vh_features` ( `vh_id`, `vh_ft_syscode`, `ft_status` ) VALUES ('{$data['vh_id']}', '{$ft_id}', '1');";
                $Q4 = mysql_query($Qins_vh_features) or die(mysql_error());
            }
        }
        //
        $trnsaction_query = "INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'Web', '{$today}', '{$_SESSION['user_id']}')";
        $transaction = mysql_query($trnsaction_query);


        if ($Q1 && $Q2 && $Q3 && $transaction) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Record Added.")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Couldn't save the record.")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'news_save') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];

        $news_head = mysql_real_escape_string($data['news_head']);
        $news_content = mysql_real_escape_string($data['news_content']);

        mysql_query("START TRANSACTION");
        mysql_query("UPDATE `web_news` SET `heading_1` = '{$news_head}', `content_all` = '{$news_content}', `posted_date` = '{$data['news_date']}' WHERE (`news_id` = '{$data['news_id']}');") or die(mysql_error());
        $mod_row = mysql_affected_rows();
        mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'News', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        $trn_row = mysql_affected_rows();
        if ($mod_row > 0 && $trn_row > 0) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "News Updated")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save")));
        }
    } else if ($_POST['action'] == 'select_news') {
        $sys_id = $_POST['news_id'];
        $system->prepareSelectQueryForJSON("SELECT
        web_news.news_id,
        web_news.heading_1,
        web_news.posted_date,
        web_news.content_all,
        web_news.image
        FROM
        web_news
        WHERE
        web_news.news_id ='{$sys_id}'");
    } else if ($_POST['action'] == 'syscode_default') {
        $system->prepareSelectQueryForJSON("SELECT
        syscode.`code`,
        syscode.description,
        syscode.remarks
        FROM
        syscode
        WHERE
        syscode.type = '{$_POST['sys_type']}'
        ORDER BY
        syscode.`code` ASC
        LIMIT 1");
    } elseif ($_POST['action'] == 'delete_news') {
        $news_id = $_POST['news_id'];
        $today = date('Y-m-d');
        $uploaddir = "../images/web_news";
        mysql_query("START TRANSACTION");
        $ins = mysql_query("DELETE FROM web_news WHERE web_news.news_id = '{$news_id}'");
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'News-{$news_id}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            unlink($uploaddir . "/" . $imgfile);
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Specification Deleted")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not delete")));
        }
        MainConfig::closeDB();
        //
    } else if ($_POST['action'] == 'prop_select_vht') {
        $vh_id = $_POST['vh_id'];
        $system->prepareSelectQueryForJSON("SELECT
        vehicle.stock_location,
        vehicle.stock_status,
        vehicle.vh_group,
        vehicle.vh_id,
        vehicle.vh_code,
        supplier.supp_code
        FROM
        vehicle
        INNER JOIN supplier ON supplier.supp_id = vehicle.supp_id
        WHERE
        vehicle.vh_id = '{$vh_id}'");
        //
    } else if ($_POST['action'] == 'vh_code_change') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];

        $news_head = mysql_real_escape_string($data['vh_code']);
        $news_content = mysql_real_escape_string($data['vh_id']);
        $result = mysql_query("SELECT
        vehicle.vh_code
        FROM
        vehicle
        WHERE
        vehicle.record_status = '1' AND
        vehicle.vh_code = '{$data['vh_code']}'");
//
        $row_count = mysql_num_rows($result);
        if (!$row_count) {
            mysql_query("START TRANSACTION");
            mysql_query("UPDATE `vehicle` SET `vh_code` = '{$data['vh_code']}' WHERE `vh_id` = '{$data['vh_id']}'") or die(mysql_error());
            $mod_row = mysql_affected_rows();
            mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Vehicle-{$data['vh_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
            $trn_row = mysql_affected_rows();
            if ($mod_row > 0 && $trn_row > 0) {
                mysql_query("COMMIT");
                echo json_encode(array(array("msgType" => 1, "msg" => "Vehicle Code Updated")));
            } else {
                mysql_query("ROLLBACK");
                echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save")));
            }
        } else {
            echo json_encode(array(array("msgType" => 2, "msg" => "Vehicle Code Exists")));
        }
    } else if ($_POST['action'] == 'vh_group_change') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];

        $group_name = mysql_real_escape_string($data['group_name']);
//
        mysql_query("START TRANSACTION");
        if (!empty($data['vh_id_list']) && isset($group_name)) {
            $up_count = 0;
            foreach ($data['vh_id_list'] as $value) {
                mysql_query("UPDATE `vehicle` SET `vh_group` = '{$group_name}' WHERE `vh_id` = '{$value}'") or die(mysql_error());
                $done = mysql_affected_rows();
                if ($done) {
                    $up_count++;
                    mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Vehicle-{$value}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
                }
            }
            if ($up_count === count($data['vh_id_list'])) {
                mysql_query("COMMIT");
                echo json_encode(array(array("msgType" => 1, "msg" => "Vehicle Info Updated")));
            } else {
                mysql_query("ROLLBACK");
                echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save")));
            }
        } else {
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save, Invalid Data")));
        }
    } else if ($_POST['action'] == 'vh_clr_manage') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];

        //   $clr_data = mysql_real_escape_string($data['clr_data']);
        //testing  240-242
        if (true) {
            echo json_encode(array(array("msgType" => 1, "msg" => "Vehicle Info Updated")));
        }
//
//        mysql_query("START TRANSACTION");
//        if (!empty($data['vh_id_list']) && isset($group_name)) {
//            $up_count = 0;
//            foreach ($data['vh_id_list'] as $value) {
//                mysql_query("UPDATE `vehicle` SET `vh_group` = '{$group_name}' WHERE `vh_id` = '{$value}'") or die(mysql_error());
//                $done = mysql_affected_rows();
//                if ($done) {
//                    $up_count++;
//                    mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Vehicle-{$value}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
//                }
//            }
//            if ($up_count === count($data['vh_id_list'])) {
//                mysql_query("COMMIT");
//                echo json_encode(array(array("msgType" => 1, "msg" => "Vehicle Info Updated")));
//            } else {
//                mysql_query("ROLLBACK");
//                echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save")));
//            }
//        } else {
//            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save, Invalid Data")));
//        }
    } else if ($_POST['action'] == 'vh_groupname_update') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];

        $group_name = mysql_real_escape_string($data['group_name']);
        $group_name_pre = mysql_real_escape_string($data['group_name_pre']);
//
        if (!empty($group_name) && !empty($group_name_pre)) {

            mysql_query("UPDATE `vehicle` SET `vh_group` = '{$group_name}' WHERE `vh_group` = '{$group_name_pre}'") or die(mysql_error());
            $done = mysql_affected_rows();
            if ($done) {
                mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Vehicle_group-{$group_name_pre}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
                mysql_query("COMMIT");
                echo json_encode(array(array("msgType" => 1, "msg" => "Group name updated")));
                return;
            } else {
                mysql_query("ROLLBACK");
                echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save")));
            }
        } else {
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save, Invalid Data")));
        }
    } else if ($_POST['action'] == 'vh_location_change') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];

        $vh_location = mysql_real_escape_string($data['vh_location']);
        $vh_id = mysql_real_escape_string($data['vh_id']);

        mysql_query("START TRANSACTION");
        mysql_query("UPDATE `vehicle` SET `stock_location` = '{$vh_location}' WHERE `vh_id` = '{$vh_id}'") or die(mysql_error());
        $mod_row = mysql_affected_rows();
        mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Vehicle-Location-{$data['vh_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        $trn_row = mysql_affected_rows();
        if ($mod_row > 0 && $trn_row > 0) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Vehicle location Updated")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save")));
        }
    } else if ($_POST['action'] == 'sel_vh_web_data') {
        $vh_id = $_POST['vh_id'];
        $system->prepareSelectQueryForJSON("SELECT
        web_vh_data.sdata_id,
        web_vh_data.vh_id,
        web_vh_data.show_data_cus,
        web_vh_data.show_price_cus,
        web_vh_data.show_data_coordinator,
        web_vh_data.show_price_coordinator,
        web_vh_data.disp_currency,
        vehicle.vh_disp_price,
        vehicle.stock_status
        FROM
        web_vh_data
        INNER JOIN vehicle ON web_vh_data.vh_id = vehicle.vh_id
        WHERE
        web_vh_data.vh_id = '{$vh_id}'");
        //
    } else if ($_POST['action'] == 'select_vh_web_features') {
        $vh_id = $_POST['vh_id'];
        $system->prepareSelectQueryForJSON("SELECT
        vh_features.vh_id,
        vh_features.vh_ft_syscode
        FROM
        vh_features
        WHERE
        vh_features.ft_status = 1 AND
        vh_features.vh_id ='{$vh_id}'");
        //
    } else if ($_POST['action'] == 'load_vehi_info') {
        $vh_id = $_POST['vh_id'];
        $system->prepareSelectQueryForJSONSingleData("SELECT
        maker_model.mod_name,
        maker.maker_name,
        vehicle.vh_chassis_code,
        vehicle.vh_chassis_num,
        vehicle_other.tot_cost,
        vehicle.stock_status,
        customer.cus_inv_name,
        customer.cus_id,
        vehicle_other.sold_price,
        vehicle_other.sold_date
        FROM
        vehicle
        INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
        INNER JOIN maker ON maker_model.maker_id = maker.maker_id
        INNER JOIN vehicle_other ON vehicle_other.vh_id = vehicle.vh_id
        LEFT JOIN customer ON customer.cus_id = vehicle_other.cus_id
        WHERE
        vehicle.vh_id ='{$vh_id}'");
        //
    } else if ($_POST['action'] == 'get_vehicle_paidamount') {
        $vh_id = $_POST['vh_id'];
        $system->prepareSelectQueryForJSONSingleData("SELECT
        vh_payment.vp_id,
        vh_payment.vh_id,
        vh_payment.cus_id,
        Sum(vh_payment.in_amount-vh_payment.out_amount) AS paid_amount,
        vh_payment.pay_confirmed
        FROM
        vh_payment
        WHERE vh_id='{$vh_id}'  AND pay_confirmed >'0'
        GROUP BY vh_id");
        //
    } elseif ($_POST['action'] == 'update_vehicl_other') {
        $err = 0;
        mysql_query("SET AUTOCOMMIT=0;");
        mysql_query("START TRANSACTION");

        $query = "UPDATE `vehicle_other` SET `sold_price`='{$_POST['vehicle_price']}', `sold_date`='{$_POST['sold_date']}',`cus_id`='{$_POST['cust_id']}' WHERE (`vh_id`='{$_POST['vh_id']}')";
//        echo $query;
        $done = mysql_query($query) or die(mysql_error());

        if (!$done) {
            $err ++;
        }
        $query = "UPDATE `vehicle` SET `stock_status` = '5' WHERE (`vh_id` = '{$_POST['vh_id']}')";
//        echo $query;
        $done = mysql_query($query)or die(mysql_error());
        if (!$done) {
            $err ++;
        }
        if ($err == 0) {
            mysql_query("COMMIT");
            $return_data['complete'] = 1;
            echo json_encode($return_data);
        } else {
            mysql_query("ROLLBACK");
            $return_data['complete'] = 0;
            echo json_encode($return_data);
        }
        mysql_query("SET AUTOCOMMIT=1;");
    } elseif ($_POST['action'] == 'update_vehicl_sale') {
        $err = 0;
        mysql_query("SET AUTOCOMMIT=0;");
        mysql_query("START TRANSACTION");

        $query = "UPDATE `vehicle_other` SET `sold_price`='{$_POST['vehicle_price']}', `sold_date`='{$_POST['sold_date']}' WHERE (`vh_id`='{$_POST['vh_id']}')";
//        echo $query;
        $done = mysql_query($query) or die(mysql_error());

        if (!$done) {
            $err ++;
        }
        if ($err == 0) {
            mysql_query("COMMIT");
            $return_data['complete'] = 1;
            echo json_encode($return_data);
        } else {
            mysql_query("ROLLBACK");
            $return_data['complete'] = 0;
            echo json_encode($return_data);
        }
        mysql_query("SET AUTOCOMMIT=1;");
    } else if ($_POST['action'] == 'cancel_vh_payment') {
        $today = date('Y-m-d');

        mysql_query("START TRANSACTION");
        mysql_query("UPDATE `vh_payment` SET `out_amount` = in_amount, in_amount = '0', `pay_confirmed` = '5' WHERE (`vp_id` = '{$_POST['vp_id']}')") or die(mysql_error());
        $mod_row = mysql_affected_rows();
        mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'Payment Cancel', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        $trn_row = mysql_affected_rows();
        if ($mod_row > 0 && $trn_row > 0) {
            mysql_query("COMMIT");
            echo json_encode((array("complete" => 1, "msg" => "success")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode((array("complete" => 1, "msg" => "Cannot Save")));
        }
    } else if ($_POST['action'] == 'is_vehicleAvailableforSell') {
        $vh_id = $_POST['vh_id'];
        $system->prepareSelectQueryForJSON("SELECT vehicle.vh_id, vehicle.stock_status FROM vehicle WHERE vehicle.vh_id ='{$vh_id}'");
        //
    } else if ($_POST['action'] == 'vh_add_payment') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];

        $cheque_bank = mysql_real_escape_string($data['cheque_bank']);

        mysql_query("START TRANSACTION");
        mysql_query("INSERT INTO `vh_payment` (`vh_id`,`cus_id`,`pay_desc`,`in_amount`,`out_amount`,`pay_category`,`pay_method`,`pay_ref`,`pay_date`,
        `chq_date`,`pay_bank`,`chq_num`,`pay_confirmed`,`leasing_comp`,`bank_account`)
        VALUES('{$data['vh_id']}','{$data['cust_id']}','-','{$data['pay_amount']}','0','{$data['payCategory_ComboBox']}','{$data['payMethod_ComboBox']}',"
                        . "'{$data['cheque_num']}','{$data['payment_date']}','{$data['pay_chq_date']}','{$data['cheque_bank']}','{$data['cheque_num']}','{$data['pay_confirmed']}','{$data['leasing_company']}','{$data['deposit_bank']}');") or die(mysql_error());
        $mod_row = mysql_affected_rows();
        mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'Payment-{$data['vh_id']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        $trn_row = mysql_affected_rows();
        if ($mod_row > 0 && $trn_row > 0) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Payment Added")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Cannot Save")));
        }
    } else if ($_POST['action'] == 'select_exch_vh') {
        $system->prepareSelectQueryForJSONSingleData("SELECT
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
        vehicle_other.vh_purchase_type = '1'  AND
        vehicle.vh_id = '{$_POST['vh_id']}'");
    } else if ($_POST['action'] == 'report_cheque_ipdate') {
        $system->prepareCommandQueryForAlertify("UPDATE `vh_payment` SET  `pay_confirmed`='1' WHERE (`vp_id`='{$_POST['up_c_val']}')", "Successfully updated", "Sorry Could Not Be updated");
    } elseif ($_POST['action'] == 'delete_vh_webdata') {
        $vh_id = $_POST['vh_id'];
        $today = date('Y-m-d');

        mysql_query("START TRANSACTION");
        $ins = mysql_query("DELETE FROM web_vh_data WHERE web_vh_data.vh_id='{$vh_id}'") or die(mysql_error());
        $ft = mysql_query("DELETE FROM vh_features WHERE vh_features.vh_id='{$vh_id}'") or die(mysql_error());
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('DELETE', 'Webdata-{$vh_id}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Vehicle Web Information Deleted")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not delete")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'select_cust_from_orders') {
//kitz
        $pi_id = $_POST['pi_id'];
        $query1 = "SELECT
        customer.cus_id,
        customer.cus_inv_name,
        customer.leasing_id,
        leasing.ls_name,
        leasing.ls_address
        FROM
        cus_order
        INNER JOIN customer ON cus_order.cus_id = customer.cus_id
        LEFT JOIN leasing ON leasing.ls_id = customer.leasing_id
        WHERE cus_order.vh_reserved IN
        (SELECT pi_entries.vh_id FROM pi_entries WHERE pi_entries.pi_id = '{$pi_id}') AND cus_order.order_status ='2'";
//        echo $query;
        $result = mysql_query($query1);
        $row = mysql_fetch_assoc($result);
        echo json_encode($row);
        MainConfig::closeDB();
    } //
    else if ($_POST['action'] == 'save_clr_entry') {
        //@Ashan
        $data = $_POST['form_data'];
           console.log($data);
        mysql_query("START TRANSACTION");
        
        $ref_id = mysql_insert_id();
        //echo $ref_id;
        $data = $_POST['form_data'];
        $today = date('Y-m-d');
        if (empty($data['ref_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "cannot proceed.refresh the page or cancel and re-enter the invoice")));
            return;
        }
        if (empty($data['inv_date'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Invoice Data")));
            return;
        }
        if (empty($data['proinv_num'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Invalid Invoice Number")));
            return;
        }
        if (empty($data['cus_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Customer")));
            return;
        }
        if (empty($data['suppbank_id'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Select a Bank")));
            return;
        }
        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("UPDATE `proforma_inv` SET
            `pi_no`='{$data['proinv_num']}',
            `pi_date`='{$data['inv_date']}',
            `cus_id`='{$data['cus_id']}',
            `currency`='{$data['inv_currency']}',
            `consignee_name`='{$data['consignee_name']}',
            `consignee_address`='{$data['consignee_address']}',
            `port_loading` ='{$data['port_loading']}',
            `port_discharge`='{$data['port_discharge']}',
            `shipment_time`='{$data['ship_time']}',
            `payment_term`='{$data['pay_term']}',
            `validity`='{$data['validity_time']}',
            `total_cif`={$data['tot_cif']},
            `partial_shipment`='{$data['inv_partial_ship']}',
            `transshipment`='{$data['inv_transship']}',
            `presentation_period`='{$data['presentaion_period']}',
            `last_shipment_date`='{$data['last_ship_date']}',
            `lc_charges`='{$data['lc_charges']}',
            `hs_code`='{$data['hs_code']}',
            `confirmation`= '{$data['confirm']}',
            `lc_advice`='{$data['advice_lc']}',`supp_id`='{$data['supp_id']}',pi_type='{$data['inv_type']}',
            `advising_bank_id` ='{$data['suppbank_id']}', pi_status='1', pi_sent='0' WHERE pi_id='{$data['ref_id']}'") or die(mysql_error());
        $upd = mysql_query("UPDATE vehicle SET stock_status='3'
            WHERE vehicle.vh_id IN (
                SELECT pi_entries.vh_id FROM
                proforma_inv INNER JOIN pi_entries ON pi_entries.pi_id = proforma_inv.pi_id
                WHERE proforma_inv.pi_id = '{$data['ref_id']}'
            )");
//        $insert_id = mysql_insert_id();
        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('UPDATE', 'invoice_proForma-completed-{{$data['ref_id']}}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Invoice saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    }
    
}
    