<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<!-- @SAMPATH -->
<html>
    <head>  
        <!--load CSS styles-->
        <?php require_once './include/systemHeader.php'; ?>        
    </head>
    <body class="green-back">
        <div id="wrap">
            <!--load navigation bar-->
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">               
                <div class="row">                                 
                    <div class="col-md-12">
                        <div class="page-header cutom-header">
                            <h3>Customer Orders</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-5">
                                <div class="form-horizontal">

                                    <input type="hidden" id="order_id" value="<?php
                                    if (isset($_GET['order_id'])) {
                                        echo $_GET['order_id'];
                                    }
                                    ?>"/>
                                    <input type="hidden" id="res_vh_id">

                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Customer * :</label>
                                        <div class="col-lg-6 maker_comboDiv">
                                            <select class="customer_ComboBox"></select>
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_cust_search" data-toggle="modal" data-target="#cus_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Vehicle Maker * :</label>
                                        <div class="col-lg-6 maker_comboDiv">
                                            <select class="maker_ComboBox"></select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Model * :</label>
                                        <div class="col-lg-6 maker_comboDiv">
                                            <select class="model_ComboBox"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Year :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_year" class="form-control custom-text1" onkeyup="set_focus_next(event, '#vehicle_colour')">
                                            <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Colour:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_colour" class="form-control custom-text1" onkeyup="set_focus_next(event, '#vehicle_milage')">
                                            <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Milage :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_milage" class="form-control custom-text1" onkeyup="set_focus_next(event, '#vehicle_options')">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Vehicle Options :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_options" class="form-control custom-text1" onkeyup="set_focus_next(event, '#vehicle_cus_con')">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Customer Requirements :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_cus_con" class="form-control custom-text1" onkeyup="set_focus_next(event, '#vehicle_action')">                        
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Actions required :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_action" class="form-control custom-text1" onkeyup="set_focus_next(event, '#vehicle_price')">
                                        </div>
                                    </div>

                                </div>
                                <!-- FORM END -->
                                <br/>

                            </div><!-- end of col-->
                            <div class="col-md-5">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Price :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_price" class="form-control custom-text1" onkeyup="set_focus_next(event, '#vehicle_advance')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Advance :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_advance" class="form-control custom-text1" onkeyup="set_focus_next(event, '#vehicle_gb')">
                                            <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">GB :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_gb" class="form-control custom-text1" onkeyup="set_focus_next(event, '#vehicle_desc')">
                                            <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Description:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_desc" class="form-control custom-text1" onkeyup="set_focus_next(event, '#vehicle_pay_op')">
                                            <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Payment Options :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_pay_op" class="form-control custom-text1" onkeyup="set_focus_next(event, '#manual_bill_num')">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Manual Bill Number :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="manual_bill_num" class="form-control custom-text1">                        
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Coordinator * :</label>
                                        <div class="col-lg-6 maker_comboDiv">
                                            <select class="coordinator_ComboBox"></select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Order Date :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_ord_date" class="form-control custom-text1 datepicker" value="<?php echo date("Y-m-d"); ?>">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="order_save_div" class="">
                                                <button class="btn btn-custom-save" id="order_save_btn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                            </span>
                                            <span  id="order_updateDiv" class="">
                                                <button class="btn btn-custom-save hidden" id="order_update"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                            </span>
                                            <!-- Button trigger modal -->
                                            <span>
                                                <button type="button" class="btn btn-custom-save" id="btn_reserve" data-toggle="modal" data-target="#vh_reserveModal"><i class="fa fa-check-square-o fa-lg"></i>&nbsp;Reserve...</button>
                                            </span>
                                            <span  id="order_reset_div" class="">
                                                <button class="btn btn-custom-light" id="order_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vehicle Reserve Modal -->
        <div class="modal fade" id="vh_reserveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Select a Vehicle to reserve</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-horizontal">
                                        <!--                                        <div class="form-group">
                                                                                    <label class="col-md-3 control-label custom-label">Vehicle :</label>
                                                                                    <div class="col-md-5">
                                                                                        <select id="reserve_vehicle" class="vahicle_code_combo_filtered"></select>
                                                                                    </div>
                                                                                </div>-->
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Vehicle :</label>
                                            <div class="col-lg-6">
                                                <select id="modi_vehicle" class="vahicle_code_combo_filtered"></select>
                                            </div>
                                            <!--<button class="btn btn-custom-light" id="btn_vh_search" data-toggle="modal" data-target="#vh_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>-->
                                        </div>
                                            <!--<input type="text" readonly="" id="cOrder_txtMaker" class="form-control custom-text1 disabled">--> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="scrollable" style="height: 300px; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-data table-hover datable vh_search_result" id="tbl_result">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Phone-1</th>
                                                    <th>Phone-2</th>
                                                    <th>E-mail-1</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-save" id="order_reserve_btn"><i class="fa fa-plus-square fa-lg"></i>&nbsp;Reserve & Add</button>
                        <button type="button" class="btn btn-custom-save hidden" id="vh_reserve_update"><i class="fa fa-check-square-o fa-lg"></i>&nbsp;Reserve</button>
                        <button type="button" class="btn btn-custom-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- customer search Modal -->
        <div class="modal fade" id="cus_searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Search Customer</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="scrollable" style="height: 300px; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-data table-hover datable cus_search_result">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Phone-1</th>
                                                    <th>Phone-2</th>
                                                    <th>E-mail-1</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- load JavaScript-->
        <?php require_once './include/systemFooter.php'; ?>
        <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.min.js"></script>
    </body>
    <script type="text/javascript">
                                                $(function () {
                                                    pageProtect();
                                                    checkurl();
                                                    load_makers_cmb(false, function () {
                                                        load_model_cmb($('.maker_ComboBox').val());
                                                    });
                                                    load_coordinator_cmb();
                                                    load_customer_cmb();
                                                    search_cust("text", function () {
                                                        $('.cus_search_result').DataTable();
                                                    });
                                                    var oorder_id = $('#order_id').val();
                                                    if (oorder_id) {
                                                        select_order_details(oorder_id);
                                                    } else {
                                                    }
                                                    $('#logout').click(function () {
                                                        logout();
                                                    });
                                                    $('#btn_reserve').click(function () {
                                                        var param = {
                                                            maker: $('.maker_ComboBox').val(),
                                                            model: $('.model_ComboBox').val()
                                                        };
                                                        search_vehicle2(param, function () {
                                                            $('#tbl_result').DataTable();
                                                        });
                                                        vehicle_code_filtered_combo(param, function () {
                                                            set_vhInfo_cusOrder($('#reserve_vehicle').val());
                                                        });
                                                    });
//                                                    vahicle_code_combo();
                                                    $('.maker_ComboBox').change(function () {
                                                        load_model_cmb($('.maker_ComboBox').val());
                                                    });
                                                    $('#reserve_vehicle').change(function () {
                                                        set_vhInfo_cusOrder($('#reserve_vehicle').val());
                                                    });

                                                    $('#order_save_btn').click(function () {
                                                        order_save();
                                                    });
                                                    $('#custSearch_btn').click(function () {
                                                        search_cust($('#search_term').val());
                                                    });
                                                    $('#order_reserve_btn').click(function () {
                                                        order_reserve_save();
                                                    });
                                                    $('#vh_reserve_update').click(function () {
                                                        order_reserve_update();
                                                    });

                                                    $('#order_update').click(function () {
                                                        order_update();
                                                    });

                                                    $('#order_reset').click(function () {
                                                        reset_order();
                                                    });
                                                    $('#order_delete').click(function () {
                                                        delete_order();
                                                    });

                                                });
                                                function set_focus_next(e, next_comp) {
                                                    e.which = e.which || e.keyCode;
                                                    if (e.which === 13) {
                                                        $(next_comp).focus();
                                                    }
                                                }
                                                function search_customer_keyUP(e) {
                                                    e.which = e.which || e.keyCode;
                                                    if (e.which === 13) {
                                                        search_cust($('#search_term').val());
                                                    }
                                                }
                                                $('.datepicker').datepicker({
                                                    format: 'yyyy-mm-dd'
                                                });
                                                $('select').chosen({width: "100%"});
    </script>
</html>

