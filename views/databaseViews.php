<?php

require_once '../config/defineVaribles.php';
require_once '../config/dbc.php';
require_once '../class/database.php';
require_once '../class/systemSetting.php';
$dbClass = new database();
$system = new setting();

if (array_key_exists("proccess", $_POST)) {
    if ($_POST['proccess'] == 'logout') {
        session_start();
        echo $dbClass->logout();
    }
}
if (array_key_exists("logSystem", $_POST)) {

    //3 = no user exist,2 = no username password,1 = sucesss and redirec
    if (isset($_POST['userName']) && !empty($_POST['userName']) && isset($_POST['password']) && !empty($_POST['password'])) {
        $user = $dbClass->filterData($_POST['userName']);
        $pass = $dbClass->filterData($_POST['password']);
        $userQuery = "SELECT
at_system_users.id,
at_system_users.user_name,
at_system_users.pwd,
at_system_users.approved,
at_system_users.user_level
FROM
at_system_users
WHERE
at_system_users.approved = '1' AND
at_system_users.user_name = '{$user}' LIMIT 1";
        $userAvailability = $system->getCountByQuery($userQuery);
        if ($userAvailability > 0) {
            $userDetails = $system->prepareSelectQuery($userQuery);
            foreach ($userDetails as $ud) {
                if ($ud['pwd'] == $dbClass->PasswordHash($pass, substr($ud['pwd'], 0, 9))) {
                    //Set Cookie if select remember btn
                    session_start();
                    $_SESSION['user_id'] = $ud['id'];
                    $_SESSION['user_name'] = $ud['user_name'];
                    $_SESSION['user_level'] = $ud['user_level'];
                    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

                    if (isset($_POST['remember']) && $_POST['remember'] == 'r') {
                        setcookie("user_id", $_SESSION['user_id'], time() + 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
                        setcookie("user_name", $_SESSION['user_name'], time() + 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
                    }
                    echo json_encode(array(array("msgType" => 0, "msg" => "Successfully Logged to the System")));
                } else {
                    echo json_encode(array(array("msgType" => 1, "msg" => "Password was incorrect.Please Check your Password")));
                }
            }
        } else {
            echo json_encode(array(array("msgType" => 2, "msg" => "User was not available in database,plase check your username")));
        }
    } else {
        echo json_encode(array(array("msgType" => 3, "msg" => "Please enter username or password")));
    }
}


if (array_key_exists("userActivation", $_POST)) {
    if ($_POST['userActivation'] == 'active') {
        echo $system->prepareCommandQueryForAlertify("UPDATE `at_system_users` SET `date`='" . date("Y-m-d") . "', `approved`='1' WHERE (`id`='{$_POST['uID']}')", "User Was Activated", "Sorry..! Could not be Activated this user");
    } else if ($_POST['userActivation'] == 'deactivate') {
        echo $system->prepareCommandQueryForAlertify("UPDATE `at_system_users` SET `date`='" . date("Y-m-d") . "', `approved`='0' WHERE (`id`='{$_POST['uID']}')", "User Was Deactivated", "Sorry..! Could not be Deactivated this user");
    }
}

if (array_key_exists("userLoginProccess", $_POST)) {
    if ($_POST['userLoginProccess'] == 'saveUser') {
        $modalUserName = $dbClass->filterData($_POST['modalUserName']);
        $modalUserLevel = $_POST['modalUserLevel'];
        $modalUserPassword = $dbClass->PasswordHash($dbClass->filterData($_POST['modalUserPassword']));
        $currentDate = date("Y-m-d");
        echo $system->prepareCommandQueryForAlertify("INSERT INTO `at_system_users` (`user_name`, `user_level`, `pwd`, `date`, `approved`) VALUES ('{$modalUserName}', '{$modalUserLevel}', '{$modalUserPassword}', '{$currentDate}', '1')", "Successfully Registered System User", "Sorry..! could not be registered system user");
    } else if ($_POST['userLoginProccess'] == 'deleteUser') {

        $deleteSystemUserID = $_POST['deleteSystemUserID'];
        echo $system->prepareCommandQueryForAlertify("DELETE FROM `at_system_users` WHERE `id` = '{$deleteSystemUserID}'", "Successfully Delete Registered System User", "Sorry..! could not be delete Registered system user");
    } else if ($_POST['userLoginProccess'] == 'updateUser') {

        $modalUserID = $_POST['modalUserID'];
        $modalUserName = $dbClass->filterData($_POST['modalUserName']);
        $modalUserLevel = $_POST['modalUserLevel'];
        $modalUserPassword = $dbClass->PasswordHash($dbClass->filterData($_POST['modalUserPassword']));
        $currentDate = date("Y-m-d");
        echo $system->prepareCommandQueryForAlertify("UPDATE `at_system_users` SET `user_name`='{$modalUserName}', `user_level`='{$modalUserLevel}', `pwd`='{$modalUserPassword}', `date`='{$currentDate}' WHERE (`id`='{$modalUserID}')", "Successfully Update Registered System User", "Sorry..! could not be update registered system user");
    } else if ($_POST['userLoginProccess'] == 'getUserDetailsByID') {
        echo $system->prepareSelectQueryForJSON("SELECT
at_system_users.user_name,
at_system_users.user_level,
at_system_users.pwd,
at_system_users.id
FROM
at_system_users
WHERE
at_system_users.id = '{$_POST['userID']}'");
    }
}


if (array_key_exists("databseBackup", $_POST)) {
    //set the default file name
    $dbname = DB_NAME;
    $bname = "tradeLicence_" . date("Y-m-d") . time() . "-" . uniqid();
    $starttime = time();
    $drop_table_if_exists = true; //should we drop table if exist?
    $somecontent = "--- Developed By RUWAN JAYAWARDENA --- \n\n";
    $dbClass->droptableifexists = $drop_table_if_exists; //set drop table if exists
    $dbClass->list_tables(); //list all tables
    $broj = count($dbClass->tables); //count all tables, $backup->tables will be array of table names
//echo "<pre>\n"; //start preformatted output
    $somecontent .= "-- Dumping tables for database: `$dbname`\n"; //write "intro" ;)
    $somecontent .= "\n\nSET FOREIGN_KEY_CHECKS=0; \n"; //write "intro" ;)
//dump all tables:
    for ($i = 0; $i < $broj; $i++) {
        $table_name = $dbClass->tables[$i]; //get table name
        if ($table_name != 'at_system_users') {
            $dbClass->dump_table($table_name); //dump it to output (buffer)
            $somecontent .= $dbClass->output; //write output
        }
    }

    $somecontent .= "\n\nSET FOREIGN_KEY_CHECKS=1; \n\n"; //write "intro" ;)
//create the zip archive
    $zip = new ZipArchive;
    $zipfilename = "backup/" . $bname . time() . ".zip";
    $res = $zip->open($zipfilename, ZipArchive::CREATE);
    if ($res === TRUE) {
        $zip->addFromString(($bname . '.sql'), $somecontent);
        $zip->close();
        echo '<span class="label label-success">Successfully Backup You System</span>&nbsp;&nbsp';
        echo '<a class="btn btn-link" href="' . $zipfilename . '">දත්ත උපස්තක ගොනුව</a>';
    } else {
        echo 'span class="label label-important">Backup file creating failed due to some reason.<br/>Please contact developers for assistance.</span>';
    }
}


