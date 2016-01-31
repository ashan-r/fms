<?php

session_start();
require_once '../config/dbc.php';
require_once '../class/database.php';
require_once '../class/systemSetting.php';
$system = new setting();
$database = new database();
MainConfig::connectDB();
if (array_key_exists("action", $_POST)) {

    if ($_POST['action'] == 'update_emp_data') {
        $emp_name = mysql_real_escape_string($_POST['emp_name']);
        $system->prepareCommandQueryForAlertify("UPDATE `r_employee` SET `emp_id`='{$_POST['emp_id']}', `name`='{$_POST['emp_name']}", "Successfully Updated Employee Data", "Sorry ! Could not be Update");
    } else if ($_POST['action'] == 'del_emp') {
        $system->prepareCommandQueryForAlertify("DELETE FROM `r_employee` WHERE (`emp_id`='{$_POST['emp_id']}')", "Successfully Deleted Employee", "Sorry ! Could not be Delete");
    } else if ($_POST['action'] == 'check_emp_no') {
        $data = $system->prepareSelectQuery("SELECT
                                            COUNT(r_employee.emp_id) AS tot
                                            FROM `employee`
                                            WHERE
                                            lms_emp_data.lms_emp_NO = '{$_POST['id']}'");
        if (!empty($data)) {
            echo $current_tot = $data[0]['tot'];
        }
    } else if ($_POST['action'] == 'select_emp') {
        $system->prepareSelectQueryForJSON("SELECT
                                            r_employee.emp_id,
                                            r_employee.name,
                                            r_employee.gender
                                            r_employee.nic,
                                            FROM r_employee
                                            WHERE
                                            r_employee.emp_id = {$_POST['emp_id']}");
    } else if ($_POST['action'] == 'save_paysheet') {
       // $query = "INSERT INTO `paysheet` (`paysheet_id`,`emp_id`,`emp_name`,`nicno`,`nopay`,`late`,`meal`,`hours`,`hourlyrate`,`advance`,`basic`,`epfno`,`sallary`,`date`)  VALUES ('{$_POST['paysheet_id']}','{$_POST['emp_id']}','{$_POST['name']}','{$_POST['nic']}','{$_POST['nopay']}','{$_POST['late']}','{$_POST['meal']}','{$_POST['othours']}','{$_POST['otrate']}','{$_POST['advance']}','{$_POST['basic']}','{$_POST['epfno']}',{$_POST['sallary']}','{$_POST['date']}')" ;                              
       $query = "INSERT INTO `r_paysheet` (`paysheet_id`,`emp_id`,`emp_name`,`nicno`,`nopay`,`late`,`meal`,`hours`,`hourlyrate`,`advance`,`basic`,`epfno`,`sallary`,`epfval`,`date`)  VALUES ('{$_POST['paysheet_id']}','{$_POST['emp_id']}','{$_POST['name']}','{$_POST['nic']}','{$_POST['nopay']}','{$_POST['late']}','{$_POST['meal']}','{$_POST['othours']}','{$_POST['otrate']}','{$_POST['advance']}','{$_POST['basic']}','{$_POST['epfno']}','{$_POST['salary']}','{$_POST['epfval']}','{$_POST['date']}')" ;                              
      
        $errMsg = "paysheet not added to the database";
        $succMsg = "employee paysheet was sucessfully added to the database";
        $system->prepareCommandQueryForAlertify($query, $succMsg, $errMsg);
    } else if ($_POST['action'] == 'max_id') {
        $system->prepareSelectQueryForJSON("SELECT
                                            MAX(paysheet_id) AS payid
                                            FROM
                                            r_paysheet");
    }
}
?>