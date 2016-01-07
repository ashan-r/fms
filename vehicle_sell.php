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
                            <h3>Sales & Payments</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-5">
                                <div class="form-horizontal">
                                    <input type="hidden" id="vh_reg_id" value="<?php
                                    if (isset($_REQUEST['vh_id'])) {
                                        echo $_REQUEST['vh_id'];
                                    }
                                    ?>">

                                    <div class="form-group">                                        
                                        <label class="col-lg-4 control-label custom-label">Vehicle * :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_code" class="form-control custom-text1" readonly="" disabled="">                        
                                            <input type="text" id="vehicle_info" class="form-control custom-text1" readonly="" disabled="">                        
                                            <input type="text" id="vehicle_stock_status" class="form-control custom-text1 hidden" readonly="" disabled="">                        
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Date * :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_sold_date" class="form-control custom-text1 datepicker"  value="<?php echo date("Y-m-d"); ?>">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Cost:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_cost" class="form-control custom-text1" readonly="" disabled=""> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Selling Price:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_price" class="form-control custom-text1">
                                            <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Balance Amount :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vehicle_balance" class="form-control custom-text1" readonly="">
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Customer* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="cus_name" class="form-control custom-text1" readonly="" disabled="">
                                            <input type="hidden" id="cust_id" class="form-control custom-text1" readonly="" disabled="">
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_cust_search" data-toggle="modal" data-target="#cus_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="vh_save_div">
                                                <button class="btn btn-custom-save" id="vh_sell_btn"><i class="fa fa-check-square-o fa-lg"></i>&nbsp;Sell Vehicle</button>
                                            </span>
                                            <span  id="vh_update_div">
                                                <button class="btn btn-custom-light" id="vh_update_btn"><i class="fa"></i>&nbsp;Update</button>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <!-- FORM END -->
                                <br/>

                            </div><!-- end of col-->
                            <div class="col-md-5">
                                <div class="form-horizontal">
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Payment method* :</label>
                                        <div class="col-lg-6 ">
                                            <select id="payMethod_ComboBox" class="">
                                                <option value="CASH">Cash</option>
                                                <option value="CHEQUE">Cheque</option>
                                                <option value="VEXCH">Vehicle Exchange</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">                                        
                                        <label class="col-lg-4 control-label custom-label">Payment category* :</label>
                                        <div class="col-lg-6 ">
                                            <select id="payCategory_ComboBox" class="">
                                                <option value="INSTALMENT">Instalment</option>
                                                <option value="ADVANCE">Advance</option>
                                                <option value="LEASING">Leasing</option>
                                                <option value="OTHER">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Payment Date* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="payment_date" class="form-control custom-text1 datepicker" value="<?php echo date("Y-m-d"); ?>">                        
                                        </div>
                                    </div>
                                    <div class="form-group hidden v_ex_group hid_cash hid_cheque" id="div_hidden_vhexch">                                        
                                        <label class="col-lg-4 control-label custom-label">Exchange Vehicle*:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="ex_vehicle_info" class="form-control custom-text1" readonly="" disabled="" >                        
                                            <input type="text" id="ex_vehicle_code" class="form-control custom-text1" readonly="" disabled="" >                        
                                            <input type="hidden" id="ex_vh_id" class="form-control custom-text1" readonly="" disabled="" >                        
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_cust_search" data-toggle="modal" data-target="#exvh_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                                    </div>                                    
                                    <div class="form-group hidden pay_cheque_group hid_cash hid_exch" id="hidden_chq">
                                        <label class="col-lg-4 control-label custom-label">Cheque No*:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="cheque_num" class="form-control custom-text1" onkeyup="">                        
                                        </div>
                                    </div>
                                    <div class="form-group hidden pay_cheque_group hid_cash hid_exch">                                        
                                        <label class="col-lg-4 control-label custom-label">Bank :</label>
                                        <div class="col-lg-6 ">
                                            <input type="text" id="cheque_bank" class="form-control custom-text1" readonly="" disabled="">                        
                                            <input type="hidden" id="cheque_bank_id" class="form-control custom-text1">                        
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_bank_search" data-toggle="modal" data-target="#lease_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                                    </div>                                     
                                    <div class="form-group hidden pay_cheque_group hid_cash hid_exch">                                        
                                        <label class="col-lg-4 control-label custom-label">Cheque Date :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="pay_chq_date" class="form-control custom-text1 datepicker" onkeyup="set_focus_next(event, '#model_save_btn')">                        
                                        </div>
                                    </div>
                                    <div class="form-group hidden vh_leasing">
                                        <label class="col-lg-4 control-label custom-label">Leasing Company:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="leaseCo_name" readonly="" class="form-control custom-text1" value="" onkeyup="set_focus_next(event, '#model_desc')">
                                            <input type="hidden" readonly=""  id="leaseCo_id" class="form-control custom-text1">
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_lease_search" data-toggle="modal" data-target="#lease_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Deposit Bank :</label>
                                        <div class="col-lg-6 deposit_bank">
                                            <select id="deposit_bank"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Amount*:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="pay_amount" class="form-control custom-text1">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="order_updateDiv" class="">
                                                <button class="btn btn-custom-save hidden" id="order_update"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                            </span>
                                            <!-- Button trigger modal -->
                                            <span id="addPayment_div">
                                                <button type="button" class="btn btn-custom-save" id="btn_addPayment"><i class="fa fa-plus-square fa-lg "></i>&nbsp;Add Payment</button>
                                            </span>
<!--                                            <span  id="order_reset_div" class="">
                                                <button class="btn btn-custom-light" id="order_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
                                            </span>-->
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="scrollable" style="overflow-y: auto">
                                    <table class="table table-bordered table-striped table-data table-hover datable vh_payments">
                                        <thead>
                                            <tr>
                                                <th>Pay date</th>
                                                <th>Pay method</th>
                                                <th>Pay Category</th>
                                                <th>Amount</th>
                                                <th>Bank Account</th>
                                                <th>Pay Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                                             
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
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
        <!-- Exchange vehicle search Modal -->
        <div class="modal fade" id="exvh_searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                        <table class="table table-bordered table-striped table-data table-hover datable exvh_search_result">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Maker</th>
                                                    <th>Model</th>
                                                    <th>Chassis Number</th>
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
        <!-- LEASING CO. MODAL -->
        <div class="modal fade" id="lease_searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 800px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Select Bank/Leasing Company</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Name :</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="co_name" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                                <input type="hidden" id="co_id" class="form-control custom-text1">
                                                <input type="hidden" id="form_request" readonly=""  disabled="" class="form-control custom-text1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Address :</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="co_address" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <span  id="mod_save_div" class="">
                                                    <button class="btn btn-custom-save" id="co_saveBtn" onkeyup=""  data-toggle="tooltip" data-placement="bottom" title="save new leasing company"><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                                </span>
                                                <span  id="mod_update_div" class="">
                                                    <button class="btn btn-custom-save hidden" id="co_updtBtn"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                                </span>
                                                <span  id="mod_reset_div" class="">
                                                    <button class="btn btn-custom-light" id="co_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel" style="border: 1px solid rgba(153, 150, 153, 1);">
                                        <div class="panel-body filterTableSearch" style="display: block; padding: 2px">
                                            <input type="text" placeholder="search" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".leasing_co_tbl"/>
                                        </div>                                    
                                        <div class="scrollable" style="height: 150px; overflow-y: auto">
                                            <table class="table table-bordered table-striped table-hover datable leasing_co_tbl">
                                                <thead>
                                                    <tr>
                                                        <th>Company Name</th>
                                                        <th>Address</th>
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

                                                        $('#logout').click(function () {
                                                            logout();
                                                        });

                                                        var vh_id = $('#vh_reg_id').val();
                                                        if (parseInt(vh_id) > 0) {
                                                            load_vehicle_info_data(vh_id);
                                                            // load vehicle info
                                                            vh_payments(vh_id);
                                                            load_syscode_values('41', '#deposit_bank');
                                                        }else{
                                                            load_syscode_values('41', '#deposit_bank');
                                                        }

                                                        $('#vh_sell_btn').click(function () {
                                                            update_vehicle_other_data();
                                                        });
                                                        $('#vh_update_btn').click(function () {
                                                            update_vehicle_sale();
                                                        });

                                                        $('#btn_addPayment').click(function () {
                                                            var vh_id = $('#vh_reg_id').val();
                                                            if (parseInt(vh_id) > 0) {
                                                                var bal = parseFloat($('#vehicle_balance').val()) - parseFloat($('#pay_amount').val());
                                                                if (bal >= 0) {
                                                                    vh_payment_save(vh_id);
                                                                } else {
                                                                    alertify.error('Could not save. check entered pay amount', 2500);
                                                                }
                                                            } else {
                                                                alertify.error('Select vehicle', 2000);
                                                            }
                                                        });
                                                        ///
                                                        leaseCoTable_local();
                                                        $(document).on('click', '#sel_leaseComp', function () {
                                                            var co_id = $(this).val();
                                                            var request = $('#form_request').val();
                                                            $.post("views/commenSettingView.php", {action: 'lease_co_select', co_id: co_id}, function (reply) {
                                                                if (reply === undefined || reply.length === 0 || reply === null) {
                                                                    alertify.error("No Data Found", 1000);
                                                                } else {
                                                                    $.each(reply, function (index, data) {
                                                                        if (request === 'L') {
                                                                            $('#leaseCo_id').val(data.ls_id);
                                                                            $('#leaseCo_name').val(data.ls_name);
                                                                        } else if (request === 'B') {
                                                                            $('#cheque_bank_id').val(data.ls_id);
                                                                            $('#cheque_bank').val(data.ls_name);
                                                                        }
                                                                    });
                                                                    $('#lease_searchModal').modal('hide');
                                                                }
                                                            }, 'json');
                                                        });

                                                        $('#btn_lease_search').click(function () {
                                                            $('#form_request').val('L');
                                                        });
                                                        $('#btn_bank_search').click(function () {
                                                            $('#form_request').val('B');
                                                        });

                                                        $('#payCategory_ComboBox').change(function () {
                                                            if ($('#payCategory_ComboBox').val() === 'LEASING') {
                                                                $('.vh_leasing').removeClass('hidden');
                                                            } else {
                                                                $('.vh_leasing').addClass('hidden');
                                                            }
                                                        });
                                                        $('#payMethod_ComboBox').change(function () {
                                                            if ($('#payMethod_ComboBox').val() === 'VEXCH') {
                                                                if ($('#div_hidden_vhexch').hasClass('hidden')) {
                                                                    $('#div_hidden_vhexch').removeClass('hidden');
                                                                }
                                                                $('.hid_exch').addClass('hidden');

                                                            } else if ($('#payMethod_ComboBox').val() === 'CHEQUE') {
                                                                if ($('#hidden_chq').hasClass('hidden')) {
                                                                    $('#hidden_chq').removeClass('hidden');
                                                                }
                                                                if (!$('#div_hidden_vhexch').hasClass('hidden')) {
                                                                    $('#div_hidden_vhexch').addClass('hidden');
                                                                }
                                                                $('.hid_exch').addClass('hidden');
                                                                $('.pay_cheque_group').removeClass('hidden');
                                                            } else {
                                                                if (!$('#div_hidden_vhexch').hasClass('hidden')) {
                                                                    $('#div_hidden_vhexch').addClass('hidden');
                                                                }
                                                                if (!$('#hidden_chq').hasClass('hidden')) {
                                                                    $('#hidden_chq').addClass('hidden');
                                                                }
                                                                $('.hid_exch').addClass('hidden');
                                                            }
                                                        });

                                                        search_cust_local("text", function () {
                                                            $('.cus_search_result').DataTable();
                                                        });
                                                        exvh_search_result("text", function () {
                                                            $('.exvh_search_result').DataTable();
                                                        });
                                                    });

                                                    // LEASING CO MODAL ACTIONS            
                                                    $('#co_saveBtn').click(function () {// save
                                                        leasingCo_save();
                                                    });
                                                    $('#co_updtBtn').click(function () {
                                                        leaseCo_update();
                                                    });

                                                    $('#co_reset').click(function () {
                                                        lease_form_reset();
                                                    });
//                                                function search_customer_keyUP(e) {
//                                                    e.which = e.which || e.keyCode;
//                                                    if (e.which === 13) {
//                                                        search_cust($('#search_term').val());
//                                                    }
//                                                }
                                                    $('.datepicker').datepicker({
                                                        format: 'yyyy-mm-dd',
                                                        autoclose: true
                                                    });
                                                    $('select').chosen({width: "100%"});
    </script>
</html>

