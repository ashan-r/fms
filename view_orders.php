<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<!-- @sampath wijesinghe -->
<html>
    <head> 
        <!--load CSS styles-->
        <?php require_once './include/systemHeader.php'; ?>   
        <!-- DataTables CSS -->
    </head>
    <body class="green-back">
        <div id="wrap">
            <!--load navigation bar-->
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">               
                <div class="row">                                 
                    <div class="col-md-12">
                        <div class="page-header cutom-header" style="">
                            <span style="padding-right: 20px; font-size: 14px; font-weight: bold;">Order Informations</span>
                            <span>
                                <label class="control-label custom-label">Show: </label>
                                <select id="cmb_inv_status">
                                    <option value="1">Pending</option>
                                    <option value="2">Won</option>
                                    <option value="99">Canceled</option>
                                </select>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- MAIN CATEGORIES TABLE START-->
                                <div class="panel">
                                    <div class="scrollable" style="height: 520px; overflow-y: auto">
                                        <table class="view_order_table table table-bordered table-data table-striped">
                                            <!--table table-bordered table-data table-striped datable-->
                                            <thead>
                                                <tr>
                                                    <th>Order No</th>
                                                    <th>Order Date</th>
                                                    <th>Maker</th>
                                                    <th>Model</th>
                                                    <th>Year</th>
                                                    <th>Color</th>
                                                    <th>Milage</th>
                                                    <th>Options</th>
                                                    <th>Conditions</th>
                                                    <th>Actions</th>
                                                    <th>Price</th>
                                                    <th>Advance</th>
                                                    <th>Coordinator Name</th>
                                                    <th>GB</th>
                                                    <th>Customer Name</th>
                                                    <th>Comments</th>
                                                    <th>Description</th>
                                                    <th>Action Keys</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--MAIN CATEGORIES TABLE END-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php // require_once './include/footerBar.php'; ?>
        <!-- load JavaScript-->
        <?php require_once './include/systemFooter.php'; ?>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.min.js"></script>
    </body>
    <script type="text/javascript">

        $(function () {
//            $('select').chosen({width: "100%"});
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            pageProtect();
            checkurl();
            load_view_orders_table($('#cmb_inv_status').val(),function () {
//                $('.view_order_table').DataTable();
            });

            $('#logout').click(function () {
                logout();
            });

//            $('select').chosen({width: "100%"});

            $('#cmb_inv_status').change(function () {
                load_view_orders_table($('#cmb_inv_status').val(),function () {
//                $('.view_order_table').DataTable();
                });
            });

//            $('#save').click(function () {
//                save_sim_issue_details();
//            });
//            $('#update').click(function () {
//                update_sim_data();
//            });

        });

        function set_focus_next(e, next_comp) {
            e.which = e.which || e.keyCode;
            if (e.which === 13) {
                save_sim_issue_details();
                setTimeout(function () {
                    $('#mob_number').val("");
                }, 100);
                $(next_comp).focus();
            }
        }



    </script>
</html>

