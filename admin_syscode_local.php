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
        <div id="wrap">
            <!--load navigation bar-->
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">               
                <div class="row">                                 
                    <div class="col-md-12">
                        <div class="page-header cutom-header">
                            <h3>Manage System Codes</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <input type="hidden" id="sys_id">

                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Category* :</label>
                                        <div class="col-lg-6">
                                            <select class="codeType_ComboBox">
                                                <option value="8">Drive</option>
                                                <option value="9">Fuel</option>
                                                <option value="10">Transmission</option>
                                                <option value="35">Stock Location</option>
                                                <option value="41">Bank Accounts</option>
                                                <option value="5">NBT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Text* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="syscode_desc" class="form-control custom-text1" onkeyup="">
                                            <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Remarks :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="syscode_remarks" class="form-control custom-text1" onkeyup="">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="syscode_save_div" class="">
                                                <button class="btn btn-custom-save" id="syscode_save_btn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                            </span>
                                            <span  id="syscode_updateDiv" class="hidden">
                                                <button class="btn btn-custom-save" id="syscode_update_btn"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                            </span>
                                            <span  id="syscode_reset_div" class="">
                                                <button class="btn btn-custom-light" id="syscode_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- FORM END -->
                                <br/>

                            </div><!-- end of col-->
                            <div class="col-md-6">
                                <div class="panel" style="">
                                    <div class="panel-heading panel-custom">
                                        <h3 class="panel-title title-custom">System Codes</h3>

                                        <div class="pull-right">
                                            <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                <i class="glyphicon glyphicon-filter"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="panel-body filterTableSearch">
                                        <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".syscode_info_tbl"/>
                                    </div>
                                    <div class="scrollable" style="height: 300px; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-hover datable syscode_info_tbl">
                                            <thead>
                                                <tr>
                                                    <th>Text</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>
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
        <!-- load JavaScript-->
        <?php require_once './include/systemFooter.php'; ?>
    </body>
    <script type="text/javascript">
        $(function () {
            pageProtect();
            checkurl();
            $('#logout').click(function () {
                logout();
            });
            load_syscode_table($('.codeType_ComboBox').val());
            $('.codeType_ComboBox').change(function () {
                // load table
                load_syscode_table($('.codeType_ComboBox').val());
            });
            $('#syscode_save_btn').click(function () {
                syscode_save();
            });
            $('#syscode_update_btn').click(function () {
                syscode_update();
            });
            $('#syscode_reset').click(function () {
                reset_syscode();
            });
        });
        function set_focus_next(e, next_comp) {
            e.which = e.which || e.keyCode;
            if (e.which === 13) {
                $(next_comp).focus();
            }
        }
        $('select').chosen({width: "100%"});
    </script>
</html>

