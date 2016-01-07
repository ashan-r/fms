<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<!-- @SACHITH -->
<html>
    <head>  
        <!--load CSS styles-->
        <?php require_once './include/systemHeader.php'; ?>        
    </head>
    <body class="green-back">
        <input type="hidden"  class="text" id="ref_id" value="<?php
        if (isset($_POST['ref_id'])) {
            echo $_POST['ref_id'];
        }
        ?>"/>
        <input type="hidden"  class="text" id="is_edit" value="<?php
        if (isset($_POST['is_edit'])) {
            echo '1';
        } else {
            echo '0';
        }
        ?>" />
        <input type="hidden" id="supp_id" readonly="">
        <input type="hidden" id="is_one_vh" readonly="">
        <div id="wrap">
            <!--load navigation bar-->
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">               
                <div class="row">                                 
                    <div class="col-md-12">
                        <div class="page-header cutom-header">
                            <h3>Prepare Pro-Forma Invoice</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Invoice No.:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="proinv_num" readonly="" class="form-control custom-text1" value="" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Date* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="inv_date" class="form-control custom-text1 datepicker" value="<?php echo date("Y-m-d"); ?>" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Invoice Currency:</label>
                                        <div class="col-lg-6">
                                            <select id="inv_currency" class="inv_currency"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Invoice Print Type:</label>
                                        <div col-lg-6>
                                            <label class="radio-inline">
                                                <input type="radio" class="rbt_normal" id="rbt_inv_normal" name="rbt_invType" checked="checked" value="N">Normal
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" class="rbt_leased" id="rbt_inv_leased" name="rbt_invType" value="L">Leased
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Consignee* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" readonly="readonly" id="consignee_name" class="form-control custom-text1 disabled" placeholder="" onkeyup="set_focus_next(event, '#model_desc')">
                                            <input type="text" readonly="readonly" id="consignee_address" class="form-control custom-text1 disabled" placeholder="" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Customer* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="c_inv_name" readonly="readonly"  class="form-control custom-text1" placeholder="Name" onkeyup="set_focus_next(event, '#model_desc')">
                                            <input type="hidden" id="cus_id" readonly="" class="form-control custom-text1">
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_cust_search" data-toggle="modal" data-target="#cus_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Port* :</label>
                                        <div class="col-lg-6">
                                            <select id="port_loading" ></select>
                                            <select id="port_discharge" ></select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Time of Shipment:</label>
                                        <div class="col-lg-6">
                                            <select id="ship_time" class="ship_time"></select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Term of Payment:</label>
                                        <div class="col-lg-6">
                                            <select id="pay_term" class="pay_term"></select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Validity:</label>
                                        <div class="col-lg-6">
                                            <select id="validity_time" class="validity_time"></select>
                                        </div>
                                    </div>
                                    <!-- --------------------LC SHOULD STATE BOX--------------------- -->

                                    <!-- end of col-->
                                </div>
                                <hr/>
                            </div>
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Partial Shipment:</label>
                                        <div class="col-lg-6">
                                            <select id="inv_partial_ship" class="">
                                                <option value="ALLOWED">Allowed</option>
                                                <option value="NOT ALLOWED">Not Allowed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Transshipment:</label>
                                        <div class="col-lg-6">
                                            <!--<input type="text" id="inv_transship" class="form-control custom-text1" value="" onkeyup="set_focus_next(event, '#model_desc')">-->
                                            <select id="inv_transship" class="">
                                                <option value="ALLOWED">Allowed</option>
                                                <option value="NOT ALLOWED">Not Allowed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Presentation Period :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="presentaion_period" class="form-control custom-text1" placeholder="No. of Days" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Last Shipment Date :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="last_ship_date" class="form-control custom-text1 datepicker" value="<?php echo date("Y-m-d"); ?>" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">LC Charges:</label>
                                        <div class="col-lg-6">
                                            <!--<input type="text" id="lc_charges" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                            <select id="lc_charges" class="lc_charges">
                                                <option value="APPLICANT">Applicant</option>
                                                <option value="BENEFICIARY">Beneficiary</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">H.S Code:</label>
                                        <div class="col-lg-6">
                                            <!--<input type="text" id="hs_code" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                            <select id="hs_code" class="hs_code"></select>
                                        </div>
                                    </div>                                    
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Confirmation:</label>
                                        <div class="col-lg-6">
                                            <!--<input type="text" id="confirm" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                            <select id="confirm" class="codeType_ComboBox">
                                                <option value="REQUIRED">Required</option>
                                                <option value="NOT REQUIRED">Not Required</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Advice L/C Through:</label>
                                        <div class="col-lg-6">
                                            <!--<input type="text" id="advice_lc" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                            <select id="advice_lc" class=""></select>
                                        </div>
                                    </div>   
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-6">
                                            <span  id="mod_save_div" class="">
                                                <button class="btn btn-custom-save" id="btn_proinv_add" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Create</button>
                                            </span>
                                            <span  id="mod_update_div" class="hidden">
                                                <button class="btn btn-custom-save" id="btn_proinv_edit"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                            </span>
                                            <span  id="mod_reset_div" class="">
                                                <button class="btn btn-custom-light" id="btn_proinv_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Cancel</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FORM END -->

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Advising Bank:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="suppbank_name" readonly="" class="form-control custom-text1" value="" onkeyup="set_focus_next(event, '#model_desc')">
                                            <input type="hidden" readonly=""  id="suppbank_id" class="form-control custom-text1">
                                            <input type="text" id="sup_bankswift" readonly="" class="form-control custom-text1" value="">
                                        </div>
                                        <!--<button class="btn btn-custom-light" id="btn_bank_search" data-toggle="modal" data-target="#bank_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>-->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6 col-lg-offset-4">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Freight Charge:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="freight_disp" readonly="" class="form-control custom-text1" value="" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_bank_search" data-toggle="modal" data-target="#vh_chargesModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Insurance:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="insurance_disp" readonly="" class="form-control custom-text1" value="" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel" style="">
                                    <input type="hidden" readonly=""  id="tot_cif" class="form-control custom-text1">
                                    <div class="scrollable" style="height: 450px; overflow-y: auto">
                                        <table class="table table-data table-bordered table-striped table-hover datable proinv_vh_table">
                                            <thead>
                                                <tr>
                                                    <th>Actions</th>
                                                    <th>Remarks</th>
                                                    <th>Maker</th>
                                                    <th>Model</th>
                                                    <th>Chassis No</th>
                                                    <th>Engine Capacity</th>
                                                    <th>Year</th>
                                                    <th>Amount</th>
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
            </div>
        </div>
        <!-- CUSTOMER SEARCH MODAL -->
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
                                    <div class="scrollable" style="height: 250px; overflow-y: auto">
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

        <!-- Vehicle CIF Modal -->
        <div class="modal fade" id="vh_chargesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Enter Amounts</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Freight :</label>
                                            <div class="col-lg-6">
                                                <input type="text" id="vh_freight" class="form-control custom-text1" onkeyup="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Insurance :</label>
                                            <div class="col-lg-6">
                                                <input type="text" id="vh_ins" class="form-control custom-text1" onkeyup="">                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-save" id="save_amt_btn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-custom-light" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vehicle Amount Modal -->
        <div class="modal fade" id="vh_amount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Enter Amount</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Vehicle FOB :</label>
                                            <div class="col-lg-6">
                                                <input type="text" id="vh_fob" class="form-control custom-text1" onkeyup="">                        
                                                <input type="hidden" id="pi_entry_id" class="form-control custom-text1" onkeyup="">                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-save" id="save_fob_btn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-custom-light" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- load JavaScript-->
        <?php require_once './include/systemFooter.php'; ?>
        <script type = "text/javascript" charset = "utf8" src = "js/jquery.dataTables.min.js" ></script>
    </body>
    <script type="text/javascript">
                                                $(function () {
                                                    pageProtect();
                                                    checkurl();
//                                                    $('[data-toggle="tooltip"]').tooltip();
                                                    $('#logout').click(function () {
                                                        logout();
                                                    });

                                                    bankTable();
                                                    load_makers_cmb();
                                                    load_syscode_values('21', '#port_loading');
                                                    load_syscode_values('22', '#port_discharge');
                                                    load_syscode_values('22', '#port_discharge');
                                                    load_syscode_values('23', '#validity_time');
                                                    load_syscode_values('25', '#advice_lc');
                                                    load_syscode_values('26', '#ship_time');
                                                    load_syscode_values('27', '#pay_term');
                                                    load_syscode_values('28', '#inv_currency');
                                                    //
                                                    load_syscode_default('51', '#vh_freight');
                                                    load_syscode_default('52', '#vh_ins');
                                                    load_syscode_default('53', '#presentaion_period');
                                                    load_syscode_withRemarks('24', '#hs_code');
                                                    search_cust_proInv("text", function () {
                                                        $('.cus_search_result').DataTable();
                                                    });
                                                    if (parseInt($('#ref_id').val()) > 0) {
                                                        load_PI_vehicle_table($('#ref_id').val());
                                                        get_inv_suppid($('#ref_id').val(), function () {
                                                            load_supp_bank($('#supp_id').val());
                                                        });
                                                        getInv_cif_values($('#ref_id').val());
                                                        // load customer for pre orders
                                                        select_customer_order($('#ref_id').val());
                                                        if (parseInt($('#is_edit').val()) === 1) {
                                                            load_inv_forEdit($('#ref_id').val(), function () {
                                                                select_customer_consignee($('#cus_id').val());
                                                            });
                                                        }
                                                    }
                                                    
                                                    // BANK MODAL ACTIONS            
                                                    $('#bank_saveBtn').click(function () {// save
                                                        bank_save();
                                                    });
                                                    $('#bank_updtBtn').click(function () {
                                                        bank_update();
                                                    });

                                                    $('#bank_reset').click(function () {
                                                        bank_form_reset();
                                                    });
                                                    //INVOICE ACTIONS
                                                    $('#btn_proinv_add').click(function () {// save
                                                        proinv_add();
                                                    });
                                                    $('#btn_proinv_reset').click(function () {// cancel
                                                        cancel_proForma_invoice($('#ref_id').val());
                                                    });
                                                    $('#save_amt_btn').click(function () {
                                                        update_proinv_cif($('#ref_id').val(), function () {
                                                            getInv_cif_values($('#ref_id').val());
                                                            load_PI_vehicle_table($('#ref_id').val());
                                                        });
                                                    });
                                                    // FOB MODAL
                                                    $('#save_fob_btn').click(function () {
                                                        update_proinv_fob($('#pi_entry_id').val(), function () {
                                                            load_PI_vehicle_table($('#ref_id').val());

                                                        });
                                                    });
                                                });
                                                function set_focus_next(e, next_comp) {
                                                    e.which = e.which || e.keyCode;
                                                    if (e.which === 13) {
                                                        $(next_comp).focus();
                                                    }
                                                }
                                                $('.datepicker').datepicker({
                                                    format: 'yyyy-mm-dd'
                                                });

                                                $('select').chosen({width: "100%"});
    </script>
</html>

