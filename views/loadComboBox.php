<?php

require_once '../config/dbc.php';
require_once '../class/database.php';
require_once '../class/systemSetting.php';
$dbClass = new database();
$system = new setting();

if (array_key_exists("comboBox", $_POST)) {
    if ($_POST['comboBox'] == 'makers') {
        $system->prepareSelectQueryForJSON("SELECT
        maker.maker_id,
        maker.maker_name
        FROM maker
        WHERE maker.maker_status = '1'");
    } else if ($_POST['comboBox'] == 'coordinator_category') {
        $system->prepareSelectQueryForJSON("SELECT
        syscode.`code`,
        syscode.description
        FROM
        syscode
        WHERE
        syscode.type = '11'");
    } else if ($_POST['comboBox'] == 'transmission_types') {
        $system->prepareSelectQueryForJSON("SELECT
        syscode.`code`,
        syscode.description
        FROM
        syscode
        WHERE
        syscode.type = '10'");
    } else if ($_POST['comboBox'] == 'fuel_types') {
        $system->prepareSelectQueryForJSON("SELECT
        syscode.`code`,
        syscode.description
        FROM
        syscode
        WHERE
        syscode.type = '9'");
    } else if ($_POST['comboBox'] == 'currency_types') {
        $system->prepareSelectQueryForJSON("SELECT
        syscode.`code`,
        syscode.description
        FROM
        syscode
        WHERE
        syscode.type = '6'");
    } else if ($_POST['comboBox'] == 'drive_types') {
        $system->prepareSelectQueryForJSON("SELECT
        syscode.`code`,
        syscode.description
        FROM
        syscode
        WHERE
        syscode.type = '8'");
    } else if ($_POST['comboBox'] == 'syscode_types') {
        $system->prepareSelectQueryForJSON("SELECT
        syscode.`code`,
        syscode.description,
        syscode.remarks
        FROM
        syscode
        WHERE
        syscode.type = '{$_POST['sys_type']}'");
    } else if ($_POST['comboBox'] == 'vahicle_code_combo') {
        $system->prepareSelectQueryForJSON("SELECT
vehicle.vh_id,
vehicle.vh_code
FROM
vehicle
WHERE
vehicle.record_status = '1' AND
vehicle.stock_status = '1'");
    } else if ($_POST['comboBox'] == 'vehicle_code_latest') {
        $system->prepareSelectQueryForJSON("SELECT
vehicle.vh_id,
vehicle.vh_code
FROM
vehicle
WHERE
vehicle.record_status = '1' AND
vehicle.stock_status != '5'
ORDER BY
vehicle.vh_id DESC
LIMIT 20");
    } else if ($_POST['comboBox'] == 'modification_statusCombo') {
        $system->prepareSelectQueryForJSON("SELECT
syscode.description
FROM
syscode
WHERE
syscode.type = '12'
ORDER BY syscode.`code` ASC");
    } else if ($_POST['comboBox'] == 'vehicle_model') {
        $system->prepareSelectQueryForJSON("SELECT
maker_model.mod_id,
maker_model.mod_name
FROM
maker_model
WHERE
maker_model.mod_status = '1' AND
maker_model.maker_id = {$_POST['maker']}");
    } else if ($_POST['comboBox'] == 'cordinator_combo') {
        $system->prepareSelectQueryForJSON("SELECT
coordinator.coordinator_id,
coordinator.coordinator_name
FROM
coordinator
WHERE
coordinator.coordinator_status = '1'");
    } else if ($_POST['comboBox'] == 'cordinator_jp_combo') {
        $system->prepareSelectQueryForJSON("SELECT
coordinator.coordinator_id,
coordinator.coordinator_name
FROM
coordinator
WHERE
coordinator.coordinator_status = '1'  AND
coordinator.category = 'foreign'");
    } else if ($_POST['comboBox'] == 'customer_combo') {
        $system->prepareSelectQueryForJSON("SELECT
customer.cus_id,
customer.cus_name
FROM
customer
WHERE
customer.cus_status = '1'");
    } else if ($_POST['comboBox'] == 'supplier_combo') {
        $system->prepareSelectQueryForJSON("SELECT
supplier.supp_code,
supplier.supp_id
FROM
supplier
WHERE
supplier.supp_status != '99'");
    } else if ($_POST['comboBox'] == 'vehicle_code_combo_filtered') {
        $system->prepareSelectQueryForJSON("SELECT
vehicle.vh_id,
vehicle.vh_code
FROM
vehicle
WHERE
vehicle.record_status = '1' AND
vehicle.stock_status = '1' AND
vehicle.vh_maker_model = '{$_POST['vh_model']}'");
    } else if ($_POST['comboBox'] == 'vehicle_stock_status_types') {
        $system->prepareSelectQueryForJSON("SELECT
        syscode.`code`,
        syscode.description
        FROM
        syscode
        WHERE
        syscode.type = '7'");
    } else if ($_POST['comboBox'] == 'spec_cmb') {
        $system->prepareSelectQueryForJSON("SELECT
        vh_tech_spec.spec_id,
        vh_tech_spec.spec_title
        FROM
        vh_tech_spec
        WHERE vh_tech_spec.mod_id = '{$_POST['mod_id']}'");
    } else if ($_POST['comboBox'] == 'vh_groups') {
        $system->prepareSelectQueryForJSON("SELECT DISTINCT(vh_group) FROM
        (SELECT
        vehicle.vh_group
        FROM
        vehicle
        ORDER BY
        vehicle.vh_id DESC
        LIMIT 200) AS vehicle");
    } else if ($_POST['comboBox'] == 'clr_data') {
        $system->prepareSelectQueryForJSON("
        SELECT
        vh_clearing.clr_id,
	vh_clearing.shipped_date,
	vh_clearing.coordinator,
	vh_clearing.vessel,
	vh_clearing.refunds,
	vh_clearing.arrival_date,
	vh_clearing.duty,
	vh_clearing.clr_date,
	vh_clearing.vh_marks_invoice,
	vh_clearing.insurance,
	vh_clearing.transport_method,
	vh_clearing.transporter_id,
	vh_clearing.cust_id,
	vh_clearing.lc_no
        FROM
            vh_clearing
        ORDER BY
	    vh_clearing.shipped_date DESC
        ");
    }
}
