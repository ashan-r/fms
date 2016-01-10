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
    }
}