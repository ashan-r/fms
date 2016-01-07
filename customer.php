<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<!-- Kitz -->
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
                            <h3>Customer</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-5">
                                <div class="form-horizontal">
                                    <input type="hidden" id="cus_id" value="">

                                    <div class="form-group ">
                                        <label class="col-lg-4 control-label custom-label" for="c_name">Name :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="c_name" class="form-control custom-text1" maxlength="150" onkeyup="set_focus_next(event, '#c_inv_name')">
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label class="col-lg-4 control-label custom-label" for="c_inv_name">Invoice Name :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="c_inv_name" class="form-control custom-text1" maxlength="150" onkeyup="set_focus_next(event, '#c_addr')" >
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label class="col-lg-4 control-label custom-label" for="c_addr">Address :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="c_addr" class="form-control custom-text1" maxlength="255" >
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label class="col-lg-4 control-label custom-label" for="c_inv_addr">Invoice Address :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="c_inv_addr" class="form-control custom-text1" maxlength="255" required>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label class="col-lg-4 control-label custom-label" for="c_phone1">Phone No:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="c_phone1" class="form-control custom-text1" maxlength="11" required>
                                        </div>
                                        <div class="col-lg-6  col-lg-offset-4">
                                            <input type="text" id="c_phone2" class="form-control custom-text1" maxlength="11" required>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-lg-4 control-label custom-label" for="c_phone1">E-mail:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="c_email1" class="form-control custom-text1" maxlength="50" >
                                        </div>
                                        <div class="col-lg-6 col-lg-offset-4">
                                            <input type="text" id="c_email2" class="form-control custom-text1" maxlength="50" >
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-lg-4 control-label custom-label" for="c_other">Other :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="c_other" class="form-control custom-text1" maxlength="45" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Leasing Company:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="leaseCo_name" readonly="" class="form-control custom-text1" value="" onkeyup="set_focus_next(event, '#model_desc')">
                                            <input type="hidden" readonly=""  id="leaseCo_id" class="form-control custom-text1">
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_lease_search" data-toggle="modal" data-target="#lease_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-lg-4 control-label custom-label" for="c_comments">Comments :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="c_comments" class="form-control custom-text1" maxlength="150" required>
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin-top: 30px;">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <button class="btn btn-custom-save" id="c_add_btn"><i class="fa fa-plus-square fa-lg"></i>&nbsp;&nbsp;Add</button>
                                            <button class="btn btn-custom-save hidden" id="c_update_btn"><i class="fa fa-pencil fa-sm"></i>&nbsp;&nbsp;Update</button>
                                            <button class="btn btn-custom-light" id="c_cancel_btn"><i class="fa fa-refresh fa-lg"></i>&nbsp;&nbsp;Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FORM END -->
                            <div class="col-md-7">
                                <div class="panel" style="">
                                    <div class="panel-heading panel-custom">
                                        <h3 class="panel-title title-custom">Customers</h3>

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
                                        <table class="table table-bordered table-striped table-hover datable c_customers_table">
                                            <thead>
                                                <tr>
                                                    <!--<th>#</th>-->
                                                    <th>Name</th>
                                                    <th>Invoice Name</th>
                                                    <th>Address</th>
                                                    <!--<th>Invoice Address</th>-->
                                                    <th>Phone No 1</th>
                                                    <th>Phone No 2</th>
                                                    <th>Other</th>
                                                    <!--<th>Comments</th>-->
                                                    <th></th>
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
        <!-- LEASING CO. MODAL -->
        <div class="modal fade" id="lease_searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 800px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Select Leasing Company</h4>
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
    </body>
    <script type="text/javascript">
        $(function () {
            pageProtect();
            checkurl();
            kitz_load_customers();
            $('#logout').click(function () {
                logout();
            });
            leaseCoTable();
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
            //
            $('#c_add_btn').click(function () {
                kitz_customer_save();
            });
            $('#c_update_btn').click(function () {
                customer_update();
            });
            $('#c_cancel_btn').click(function () {
                reset_customer();
            });

        });

        function set_focus_next(e, next_comp) {
            e.which = e.which || e.keyCode;
            if (e.which === 13) {
                $(next_comp).focus();
            }
        }
    </script>
</html>



