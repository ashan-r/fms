<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<!-- @Ashan Rajapaksha -->
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
                            <h3>Employee Registration</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-5">
                                <div class="form-horizontal">
                                    <input type="hidden" id="supp_id">

                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Employee ID :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="emp_id" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">EMP Code:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="emp_no" class="form-control" placeholder="EMP Code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">Employee Name :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="address" class="form-control" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">Designation. :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="phone_no" class="form-control" placeholder="General">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">NIC :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="fax" class="form-control" placeholder="Fax">
                                            <input type="text" id="email" class="form-control" placeholder="E-mail">
                                            <input type="text" id="web" class="form-control" placeholder="Web">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Gender:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="suppbank_name" readonly="" class="form-control custom-text1" value="" onkeyup="set_focus_next(event, '#model_desc')">
                                            <input type="hidden" readonly=""  id="suppbank_id" class="form-control custom-text1">
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_bank_search" data-toggle="modal" data-target="#bank_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">EPF No:</label>
                                        <div class="col-lg-6">
                                            <!--<input type="text" id="v_fuel" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                            <select id="sup_currency">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Basic Sallary:</label>
                                        <div class="col-lg-6">
                                            <!--<input type="text" id="v_fuel" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                            <select id="sup_currency">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Basic Sallary:</label>
                                        <div class="col-lg-6">
                                            <!--<input type="text" id="v_fuel" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                            <select id="sup_currency">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Reg Date:</label>
                                        <div class="col-lg-6">
                                            <!--<input type="text" id="v_fuel" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                            <select id="sup_currency">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="save_div" class="">
                                                <button class="btn btn-custom-save" id="btn_supp_add" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Save Employee</button>
                                            </span>
                                            <span  id="update_div">
                                                <button class="btn btn-custom-save hidden" id="btn_update_supp"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                                <button class="btn btn-custom-light" id="btn_clear_supp"><i class="fa fa-refresh fa-sm"></i>&nbsp;Clear</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FORM END -->
                            <div class="col-md-7">
                                <div class="panel" style="">
                                    <div class="panel-heading panel-custom">
                                        <h3 class="panel-title title-custom">Registered Supplier Details</h3>

                                        <div class="pull-right">
                                            <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                <i class="glyphicon glyphicon-filter"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="panel-body filterTableSearch">
                                        <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".contact_info_table"/>
                                    </div>
                                    <div class="scrollable" style="height: 65vh; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-hover datable reg_sup_details_tbl">
                                            <thead>
                                                <tr>
                                                    <th>Supplier Code</th>
                                                    <th>Supplier Name</th>
                                                    <th>Address</th>
                                                    <th>Telephone No.</th>
                                                    <th>Fax</th>
                                                    <th>e-mail</th>
                                                    <th>Web</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                             
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="system_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADVISING BANK MODAL -->
        <div class="modal fade" id="bank_searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 800px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Select Bank</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Bank :</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="bank_name" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                                <input type="hidden" id="bank_id" class="form-control custom-text1">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">SWIFT :</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="bank_swift" maxlength="8" style="text-transform: uppercase;" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Branch :</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="branch" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Account :</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="bank_account" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <span  id="mod_save_div" class="">
                                                    <button class="btn btn-custom-save" id="bank_saveBtn" onkeyup=""  data-toggle="tooltip" data-placement="bottom" title=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                                </span>
                                                <span  id="mod_update_div" class="">
                                                    <button class="btn btn-custom-save hidden" id="bank_updtBtn"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                                </span>
                                                <span  id="mod_reset_div" class="">
                                                    <button class="btn btn-custom-light" id="bank_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
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
                                            <input type="text" placeholder="search" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".bank_tbl"/>
                                        </div>                                    
                                        <div class="scrollable" style="height: 150px; overflow-y: auto">
                                            <table class="table table-bordered table-striped table-hover datable bank_tbl">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>SWIFT code</th>
                                                        <th>Branch</th>
                                                        <th>Account No</th>
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
    </body>
    <script type="text/javascript">
        $(function() {
            // pageProtect();
            // checkurl();
            load_sup_reg_tbl();
            load_currency_types();
            bankTable();
            $('#logout').click(function() {
                logout();
            });
            // BANK MODAL ACTIONS            
            $('#bank_saveBtn').click(function() {
                //// save
                bank_save();
            });
            $('#bank_updtBtn').click(function() {
                bank_update();
            });

            $('#bank_reset').click(function() {
                bank_form_reset();
            });
            //
            $('#btn_supp_add').click(function() {
                save_supp();
            });
            $('#btn_clear_supp').click(function() {
                clear_sup_form();
            });
            $('#btn_update_supp').click(function() {
                update_supp();
            });
        });

        $('select').chosen({width: "100%"});
    </script>
</html>

