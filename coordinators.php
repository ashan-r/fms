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
                            <h3>Coordinators</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <input type="hidden" id="coord_id">


                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Name* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="co_name" class="form-control custom-text1" onkeyup="set_focus_next(event, '#co_short_name')">
                                            <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Short Name* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="co_short_name" class="form-control custom-text1" onkeyup="set_focus_next(event, '#co_phone1')">
                                            <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Phone :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="co_phone1" class="form-control custom-text1" onkeyup="set_focus_next(event, '#co_phone2')">                        
                                            <input type="text" id="co_phone2" class="form-control custom-text1" onkeyup="set_focus_next(event, '#co_email1')">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">E-mail :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="co_email1" class="form-control custom-text1" onkeyup="set_focus_next(event, '#co_email2')">                        
                                            <input type="text" id="co_email2" class="form-control custom-text1" onkeyup="set_focus_next(event, '#co_address_name')">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Address :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="co_address" class="form-control custom-text1" onkeyup="set_focus_next(event, '#co_phone1')">
                                            <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Category * :</label>
                                        <div class="col-lg-6 coord_category_comboDiv">
                                            <select class="coord_category"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="co_save_div" class="">
                                                <button class="btn btn-custom-save" id="co_save_btn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                            </span>
                                            <span  id="co_updateDiv" class="hidden">
                                                <button class="btn btn-custom-save" id="co_update_btn"><i class="fa fa-pencil fa-lg"></i>&nbsp;Update</button>
                                                <button class="btn btn-custom-light" id="btn_coord_login" data-toggle="modal" data-target="#coord_loginModal"><i class="fa fa-key"></i>&nbsp;Login</button>
                                            </span>
                                            <span  id="co_reset_div" class="">
                                                <button class="btn btn-custom-light" id="co_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
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
                                        <h3 class="panel-title title-custom">Coordinators</h3>

                                        <div class="pull-right">
                                            <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                <i class="glyphicon glyphicon-filter"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="panel-body filterTableSearch">
                                        <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".coordinator_tbl"/>
                                    </div>
                                    <div class="scrollable" style="height: 300px; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-hover datable coordinator_tbl">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Short Name</th>
                                                    <th>Phone</th>
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
                <!-- Vehicle CIF Modal -->
        <div class="modal fade" id="coord_loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Enter Coordinator Login</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">User Name:</label>
                                            <div class="col-lg-6">
                                                <input type="text" id="coord_uname" class="form-control custom-text1" onkeyup="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Password:</label>
                                            <div class="col-lg-6">
                                                <input type="text" id="coord_password" class="form-control custom-text1" onkeyup="">                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-save" id="save_coord_user" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-custom-light" id="del_coord_user" onkeyup=""><i class="fa fa-trash-o fa-lg"></i>&nbsp;Remove</button>
                        <button type="button" class="btn btn-custom-light" data-dismiss="modal">Cancel</button>
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
            load_coordinator_types();
            load_coordinator_table();

            $('#co_save_btn').click(function () {
                coordinator_add();
            });
            $('#co_update_btn').click(function () {
                update_coordinator();
            });
            $('#co_reset').click(function () {
                reset_coordinator();
            });
            $('#save_coord_user').click(function () {
                save_coordinator_login();
            });
            $('#del_coord_user').click(function () {
                delete_coordinator_login($('#coord_id').val());
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

