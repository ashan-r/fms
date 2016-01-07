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
    <body class="green-back">
        <div id="wrap" class="" >
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">               
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header cutom-header">
                            <h3>System Settings</h3>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 50px;">
                        <div class="row">

                            <a href="run.php">
                                <div class="col-md-3">
                                    <div class="thumbnail btn-dashboard" style="border-radius:5px; padding: 10px;">
                                        <img src="img/dashbord/backup.png" style="width:80px; height:80px">
                                        <div class="caption text-center" style="margin-top:-20px;">
                                            <h3>System Backup</h3>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>                    
                </div>
            </div>
        </div>

        <?php require_once './include/systemFooter.php'; ?>
    </body>
    <script type="text/javascript">
        $(function () {
            pageProtect();
            $('#logout').click(function () {
                logout();
            });
            test_tbl_filter();
            $(document).ready(function ()
            {
                $(document).bind("contextmenu", function (e) {
                    return false;
                });
            });

            document.onkeypress = function (event) {
                event = (event || window.event);
                if (event.keyCode == 123) {
                    //alert('No F-12');
                    return false;
                }
            }
            document.onmousedown = function (event) {
                event = (event || window.event);
                if (event.keyCode == 123) {
                    //alert('No F-keys');
                    return false;
                }
            }
            document.onkeydown = function (event) {
                event = (event || window.event);
                if (event.keyCode == 123) {
                    //alert('No F-keys');
                    return false;
                }
            }
        });
    </script>
</html>

