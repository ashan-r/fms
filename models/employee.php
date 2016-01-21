<?php

session_start();
require_once '../config/dbc.php';
require_once '../class/database.php';
require_once '../class/systemSetting.php';
$system = new setting();
$database = new database();
MainConfig::connectDB();
if (array_key_exists("action", $_POST)) {
    if ($_POST['action'] == 'get_selected_employee_data') {

        $emp_id = $_POST['emp_id'];
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
                    where r_employee.`status` = '1' AND
               r_employee.emp_id = '{$emp_id}'");
    } else if ($_POST['action'] == 'save_employee') {
        $today = date('Y-m-d');
        $data = $_POST['form_data'];
        if (empty($data['empno'])) {
            echo json_encode(array(array("msgType" => 2, "msg" => "Enter a supplier code")));
            return;
        }

        foreach ($data as $key => $value) {
            $data[$key] = mysql_real_escape_string($data[$key]);
        }

        mysql_query("START TRANSACTION");
        $ins = mysql_query("INSERT INTO `r_employee` (
	`emp_id`,
	`empno`,
	`name`,
	`nic`,
	`tel`,
	`gender`,
	`epfno`,
	`basic`,
	`reg_date`,
	`status`
)
VALUES" . "('{$data['emp_id']}', '{$data['empno']}', '{$data['name']}',  '{$data['nic']}', '{$data['tel']}', '{$data['gender']}', '{$data['epfno']}', '{$data['basic']}','{$data['reg_date']}','1')") or die(mysql_error());

        $trn = mysql_query("INSERT INTO `transaction` (`tr_type`, `tr_desc`, `tr_date`, `tr_user_id`) VALUES ('INSERT', 'employee-{$data['empno']}', '{$today}', '{$_SESSION['user_id']}')") or die(mysql_error());
        if ($ins && $trn) {
            mysql_query("COMMIT");
            echo json_encode(array(array("msgType" => 1, "msg" => "Employee saved")));
        } else {
            mysql_query("ROLLBACK");
            echo json_encode(array(array("msgType" => 2, "msg" => "Could not save")));
        }
        MainConfig::closeDB();
    } else if ($_POST['action'] == 'next_ai_emp') {
        $A = $system->getNextAutoIncrementID("r_employee");
        echo json_encode($A);
//        $system->prepareSelectQueryForJSONSingleData("SELECT `AUTO_INCREMENT` AS max_ai FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'carsale_db' AND TABLE_NAME = 'vehicle'");  
    }
}