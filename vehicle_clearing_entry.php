<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<!-- @ASHAN-->
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
                            <h3>Vehicle Clearing</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-5">
                                <div class="form-horizontal">
                                    <input type="hidden" id="clearing_id">


                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Vehicle ID :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vh_id" class="form-control custom-text1 "  placeholder="Vehicle ID">
                                        </div>
                                    </div>

                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Shipped Date :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="shipped_date" class="form-control custom-text1 datepicker" value="<?php echo date("Y-m-d"); ?>" onkeyup="set_focus_next(event, '#driver_name')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">Driver Name :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="driver_name" class="form-control" placeholder="Driver Name">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">Vessel :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="vessel" class="form-control" placeholder="Vessel">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">Refunds:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="refund" class="form-control" placeholder="Refunds">

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Clearing Status:</label>
                                        <div class="col-lg-6">
                                            <!--<input type="text" id="v_fuel" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                            <select id="clearing_status">
                                                <option value="1">in stock</option>
                                                <option value="2">reserved</option>
                                                <option value="3" selected>clearing</option>
                                                <option value="4">cleared</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Arrival Date :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="arrival_date" class="form-control custom-text1 datepicker" value="<?php echo date("Y-m-d"); ?>" onkeyup="set_focus_next(event, '#driver_name')">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">Document Status:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="document_status" class="form-control "  placeholder="Document Status">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">To Clearing Agent:</label>
                                        <div class="col-lg-6">
                                            <textarea type="text" id="to_clearing_agent" rows="4" class="form-control" style="resize:none;" placeholder="Notes for Clearing Ages"> </textarea>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <!-- FORM COL 1 END -->
                            <div class="col-md-7">                                

                                <div class="form-horizontal">

                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">Duty:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="duty" class="form-control "  placeholder="Duty">
                                        </div>
                                    </div>

                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Clearing Date :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="clearing_date" class="form-control custom-text1 datepicker" value="<?php echo date("Y-m-d"); ?>" onkeyup="set_focus_next(event, '#carrier_by')">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">Carrier By:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="carrier_by" class="form-control" placeholder="Carrier By">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">LC No :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="lc_no" class="form-control" placeholder="LC Number">

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="save_div" class="">
                                                <button class="btn btn-custom-save" id="btn_clearing_add" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                            </span>
                                            <span  id="update_div">
                                                <button class="btn btn-custom-save hidden" id="btn_update_supp"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                                <button class="btn btn-custom-light" id="btn_clear_supp"><i class="fa fa-refresh fa-sm"></i>&nbsp;Clear</button>
                                            </span>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Load Java Script-->
            <?php require_once './include/systemFooter.php'; ?>
            <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.min.js"></script>
    </body>
    <script type="text/javascript">
                                                $(function () {
                                                    pageProtect();
                                                    checkurl();
//                                                    $('[data-toggle="tooltip"]').tooltip();
                                                    $('#logout').click(function () {
                                                        logout();
                                                    });

                                                    
                                                    load_syscode_values('21', '#port_loading');

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
                                                    //CLEARING LIST ACTIONS
                                                    $('#btn_clearing_add').click(function () {// save
                                                        save_clearing_list();
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

