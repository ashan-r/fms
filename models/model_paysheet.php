<?php

session_start();
require_once '../config/dbc.php';
require_once '../class/database.php';
require_once '../class/systemSetting.php';
$system = new setting();
$database = new database();
MainConfig::connectDB();
if (array_key_exists("action", $_POST)) {
    if ($_POST['action'] == 'save_paysheet') {
       // $query = "INSERT INTO `paysheet` (`paysheet_id`,`emp_id`,`emp_name`,`nicno`,`nopay`,`late`,`meal`,`hours`,`hourlyrate`,`advance`,`basic`,`epfno`,`sallary`,`date`)  VALUES ('{$_POST['paysheet_id']}','{$_POST['emp_id']}','{$_POST['name']}','{$_POST['nic']}','{$_POST['nopay']}','{$_POST['late']}','{$_POST['meal']}','{$_POST['othours']}','{$_POST['otrate']}','{$_POST['advance']}','{$_POST['basic']}','{$_POST['epfno']}',{$_POST['sallary']}','{$_POST['date']}')" ;                              
       $query = "INSERT INTO `paysheet` (`paysheet_id`,`emp_id`,`emp_name`,`nicno`,`nopay`,`late`,`meal`,`hours`,`hourlyrate`,`advance`,`basic`,`epfno`,`sallary`,`epfval`,`date`)  VALUES ('{$_POST['paysheet_id']}','{$_POST['emp_id']}','{$_POST['name']}','{$_POST['nic']}','{$_POST['nopay']}','{$_POST['late']}','{$_POST['meal']}','{$_POST['othours']}','{$_POST['otrate']}','{$_POST['advance']}','{$_POST['basic']}','{$_POST['epfno']}','{$_POST['salary']}','{$_POST['epfval']}','{$_POST['date']}')" ;                              
      
        $errMsg = "paysheet not added to the database";
        $succMsg = "employee paysheet was sucessfully added to the database";
        $system->prepareCommandQueryForAlertify($query, $succMsg, $errMsg);
    }
    
}