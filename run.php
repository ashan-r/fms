<?php
include './config/dbc.php';
$conn = new MainConfig();
session_start();
?>
<!DOCTYPE html>
<html>
    <head>        
        <?php require_once './include/systemHeader.php'; ?>          
    </head>
    <body>
        <div id="green-back" class="" >
            <?php require_once './include/navBar.php'; ?>
            <div class="content">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box" style="padding-left: 10px">
                            <div class="box-head">
                                <h4> System Backup</h4>
                            </div>

                            <p>&nbsp;</p>
                            <p>&nbsp;</p>

                            <p><font size="+1" > Click the button below to start data backup process. </p>
                            <p> 
                                After successful completion of the backup file, we advise you to copy the file to a secure data storage location.
                                In case of an emergency breakdown, backup file can be used  to restore your system back to the previous state where the backup was taken.
                            </p>
                            <p>Example backup file name : backup2014-03-30.zip</p>

                            <p>&nbsp;</p>
                            <?php
                            error_reporting(0);
//set the default file name
                            $backupName = "backup_" . date("Y-m-d") . "-";

//include [require] mysql dump engine
                            require_once('MySQLDump.class.php');
                            $starttime = time();
//mysql info
                            $dbhost = $db_HOST; //db host
                            $dbuser = $db_USER; //db user name
                            $dbpass = $db_PASS; //db password
                            $dbname = $db_NAME; //db to work with

                            $drop_table_if_exists = true; //should we drop table if exist?

                            $somecontent = "/*\n
+-------------------------------------------------------------+\n
+-------------------------------------------------------------+\n
+---------By:Amila Jayasinghe (amilaplus@gmail.com)-----------+\n
+-------------------------------------------------------------+\n
*/\n\n";


// no need for editing further
                            $backup = new MySQLDump(); //create new instance of MySQLDump

                            $backup->droptableifexists = $drop_table_if_exists; //set drop table if exists

                            $backup->connect($dbhost, $dbuser, $dbpass, $dbname); //connect
                            if (!$backup->connected) {
                                die('Error: ' . $backup->mysql_error);
                            } //if not connected, display error
                            $backup->list_tables(); //list all tables

                            $broj = count($backup->tables); //count all tables, $backup->tables will be array of table names
//echo "<pre>\n"; //start preformatted output
                            $somecontent .= "-- Dumping tables for database: `$dbname`\n"; //write "intro" ;)
                            $somecontent .= "\n\nSET FOREIGN_KEY_CHECKS=0; \n"; //write "intro" ;)
//dump all tables:
                            for ($i = 0; $i < $broj; $i++) {
                                $table_name = $backup->tables[$i]; //get table name
                                if ($table_name != 'at_system_users') {
                                    $backup->dump_table($table_name); //dump it to output (buffer)
                                    $somecontent .= $backup->output; //write output
                                }
                            }

                            $somecontent .= "\n\nSET FOREIGN_KEY_CHECKS=1; \n\n"; //write "intro" ;)
//create the zip archive
                            $zip = new ZipArchive;
                            $zipfilename = "backup/" . $backupName;
                            $res = $zip->open($zipfilename, ZipArchive::CREATE);
                            if ($res === TRUE) {
                                $zip->addFromString(($backupName . '.sql'), $somecontent);
                                $zip->close();





                                echo '&nbsp&nbsp<a href="' . $zipfilename . '"><button name="backup" type="button" class="btn btn-primary btn-lg"> Click Here to Download System Backup</button></a>';
                               
                            } else {
                                echo 'Backup file creating failed due to some reason.<br/>Please contact developers for assistance.';
                            }
                            ?>
                            <br/>
                            <div class="alert alert-warning" role="alert">
                                Note: This will only create a backup of the database (i.e text data). To backup images and files, please use a FTP client and download  contents of '\vehicle_img' folder
                            </div>

                            <p>&nbsp;</p>
                            <p>&nbsp;</p> 

                        </div>
                    </div>
                </div>
            </div>
        </div>	
        <?php require_once './include/systemFooter.php'; ?>
    </body>
</html>