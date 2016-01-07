<?php
include './config/dbc.php';
$conn = new MainConfig();
session_start();
?>
<!DOCTYPE html>
<!-- Ashan Rajapaksha -->
<html>
    <head>        
        <?php require_once './include/systemHeader.php'; ?>          
    </head>
    <body class="green-back">
        <div id="wrap" style="margin-top:0;margin-bottom:0;">
            <?php require_once './include/navBar.php'; ?>
            <div class="container">               
                <div class="row">                                   
                    <div class="col-md-12" style="margin-top: 60px;">
                        <div class="row">
                            <div style="margin-bottom: 10px;text-align: center; color: #999999; font-weight: bold;font-size: larger">
                               RMK Engineering
                            </div>
                            <div>
                                <!--<img src="img/starterSlides/Part 3.png" style="display: block; margin-left: auto;margin-right: auto;">-->
                                <img src="img/starterSlides/car_sale_icon1.png" style="display: block; margin-left: auto;margin-right: auto;">
                            </div>

                            <!--                            <div class="alert alert-warning" style="margin:20px; text-align: center;font-weight:bold"role="alert">
                                                            Notice: Software Update available. contact us for more details
                                                        </div>-->
                            <?php
//                            $data = array();
//                            $quary = "SELECT
//                            in_usrprvlg.usrID,
//                            in_sysprvlg.usrPrvMnuName,
//                            in_sysprvlg.usrPrvMnuIcon,
//                            in_sysprvlg.usrPrvMnuPath,
//                            in_usrprvlg.usrPrvCode
//                            FROM
//                            in_sysprvlg
//                            INNER JOIN in_usrprvlg ON in_usrprvlg.usrPrvCode = in_sysprvlg.prvCode
//                            WHERE in_usrprvlg.usrID = '{$_SESSION['user_id']}' AND in_sysprvlg.usrPrnt != 0";
//                            MainConfig::connectDB();
//                            $getLogeduser = mysql_query($quary)or die(mysql_error());
//                            MainConfig::closeDB();
//                            if (!empty($getLogeduser)) {
//                                while ($row = mysql_fetch_assoc($getLogeduser)) {
//                                    $data[] = $row;
//                                }
//                                foreach ($data AS $aa) {
//                                    echo '<a href="' . $aa['usrPrvMnuPath'] . '" class="fontChang">
//                                           <div class="col-md-3">
//                                             <div class="thumbnail btn-dashboard" style="border-radius:5px;">
//                                              <img src="img/dashbord/' . $aa['usrPrvMnuIcon'] . '" style="width:80px; height:80px">
//                                              <div class="caption text-center" style="margin-top:-20px;">
//                                              <h3>' . $aa['usrPrvMnuName'] . '</h3>
//                                                  <p></p>
//                                                 </div>
//                                                  </div>
//                                                 </div>
//                                              </a>';
//                                }
//                            }
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
            <div style="margin-bottom: 20px;text-align: center; color: #999999">
                Designed And Developed By Ashan Rajapaksha
            </div>
        </div>     
        <?php require_once './include/systemFooter.php'; ?>
    </body>
    <script type="text/javascript">
        $(function() {
            pageProtect();
            $('#logout').click(function() {
                logout();
            });

            $(document).ready(function()
            {
                $(document).bind("contextmenu", function(e) {
//                    return false;
                });
            });

            document.onkeypress = function(event) {
                event = (event || window.event);
                if (event.keyCode == 123) {
                    //alert('No F-12');
//                    return false;
                }
            }
            document.onmousedown = function(event) {
                event = (event || window.event);
                if (event.keyCode == 123) {
                    //alert('No F-keys');
//                    return false;
                }
            }
            document.onkeydown = function(event) {
                event = (event || window.event);
                if (event.keyCode == 123) {
                    //alert('No F-keys');
//                    return false;
                }
            }
        });
    </script>
</html>

