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
                            <h3>Edit Vehicle Properties<small> &nbsp; Select vehicles from Vehicle List</small></h3>
                        </div>
                        <div class="row">
                            <input type="hidden"  class="" id="vh_list" value="<?php
                            if (isset($_POST['vh_id_list'])) {
                                echo $_POST['vh_id_list'];
                            }
                            ?>" />
                            <!-- FORM START -->
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <input type="hidden" id="maker_id">
                                    <div class="form-group hidden">                                        
                                        <label class="col-lg-4 control-label custom-label required">Vehicle Marks* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" disabled="" id="v_code_num" class="form-control custom-text1">
                                            <input type="hidden" disabled="" id="vh_id">
                                        </div>
                                        <!--<button class="btn btn-custom-light" id="btn_vh_code" data-toggle="modal" data-target="#vh_codeModal"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>-->
                                    </div>
                                    <div class="form-group hidden">                                        
                                        <label class="col-lg-4 control-label custom-label">Vehicle Group: </label>
                                        <div class="col-lg-6 ">
                                            <select id="cmb_vh_group"></select>
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_vh_group" data-toggle="modal" data-target="#vh_groupModal"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>
                                    </div>
                              
                                    <div class="form-group">                                        
                                        <label class="col-lg-4 control-label custom-label">Status: </label>
                                        <div class="col-lg-6 ">
                                            <select id="cmb_stock_status"></select>
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_vh_status"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Location :</label>
                                        <div class="col-lg-6 ">
                                            <select class="location_ComboBox">
                                                <option value="LKR">Sri Lanka</option>
                                                <option value="JPY">Japan</option>
                                                <option value="0" selected="selected">- Select -</option>
                                            </select>
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_vh_location"><i class="fa fa-floppy-o fa-sm"></i>&nbsp;</button>
                                    </div>
                                   
<!--                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-8">
                                            <span  id="save_div" class="">
                                                <button class="btn btn-custom-save" id="webvh_save_btn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Save</button>
                                            </span>
                                            <span  id="updateDiv" class="">
                                                <button class="btn btn-custom-save hidden" id="webvh_update_btn"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                            </span>
                                            <span  id="reset_div" class="">
                                                <button class="btn btn-custom-light" id="webvh_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
                                            </span>
                                        </div>
                                    </div>-->
                                </div>
                                <!-- FORM END -->
                            </div>
                            <div class="col-md-6">
                                <div class="row" id="feature_boxDiv">
                                    <div class="scrollable">
                                        <table class="table features_table table-data">
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="panel" style="">
                                        <div class="panel-heading panel-custom">
                                            <h3 class="panel-title title-custom">Selected Vehicles</h3>
                                        </div>
                                        <div class="scrollable" style="height: 200px; overflow-y: auto">
                                            <table id="properties_selected_tbl" class="table table-bordered table-striped table-data">
                                                <thead>
                                                    <tr>
                                                        <th>Marks</th>
                                                        <th>Model</th>
                                                        <th>Package</th>
                                                        <th>Year</th>
                                                        <th>Colour</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                             
                                                </tbody>
                                            </table>
                                            <input type="hidden" id="system_id">
                                        </div>
                                    </div>    
                                </div>

                            </div><!-- end of col-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vehicle Code Modal -->
        <div class="modal fade" id="vh_codeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Change Vehicle Code</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-inline">
                                    <div class="alert alert-warning" role="alert">
                                       <i class="fa fa-exclamation-triangle"></i> Warning! Any Images/files uploaded for this vehicle will be lost. Backup the files first, and re-upload them after changing the code
                                    </div>
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Vehicle Code :</label>
                                            <div class="col-lg-5 input-group">
                                                <span class="input-group-addon" id="vh_supp_code">@</span>
                                                <input type="text" id="vh_code" class="form-control custom-text1" maxlength="4">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-save" id="upd_vh_code" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Change Code</button>
                        <button type="button" class="btn btn-custom-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vehicle Code Modal -->
        <!-- Vehicle group Modal -->
        <div class="modal fade" id="vh_groupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add/Edit Vehicle Group</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label custom-label">Group Name :</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="group_name" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                                <input type="hidden" id="group_name_pre" class="form-control custom-text1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel" style="border: 1px solid rgba(153, 150, 153, 1);">
                                        <div class="panel-body filterTableSearch" style="display: block; padding: 2px">
                                            <input type="text" placeholder="search" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".bank_tbl"/>
                                        </div>                                    
                                        <div class="scrollable" style="height: 200px; overflow-y: auto">
                                            <table class="table table-bordered table-striped table-hover datable vh_group_tbl">
                                                <thead>
                                                    <tr>
                                                        <th>Group Name</th>
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
                        <button type="button" class="btn btn-custom-save hidden" id="update_group" onkeyup=""><i class="fa fa-pencil fa-sm"></i>&nbsp;Update group</button>
                        <button type="button" class="btn btn-custom-save" id="save_group" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add to group</button>
                        <button type="button" class="btn btn-custom-light" id="cancel_group" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vehicle Code Modal -->
        <!-- load JavaScript-->
        <?php require_once './include/systemFooter.php'; ?>
    </body>
    <script type="text/javascript">
        $(function () {
            pageProtect();
            checkurl();
            if ($('#vh_list').val().length > 0) {
                properties_selectedVh($('#vh_list').val());
            }
            load_vhGroups();
            load_stock_type_edit();
            vh_group_tbl();
            $('#logout').click(function () {
                logout();
            });

            $('#upd_vh_code').click(function () {
                vh_code_update($('#vh_id').val());
            });
            $('#save_group').click(function () {
                var searchIDs = $("#properties_selected_tbl .btn_sel").map(function () {
                    return $(this).val();
                }).get();
                vh_group_save(searchIDs,$('#group_name').val());
            });
            $('#update_group').click(function () {
                vh_group_update();
            });
//            $('#btn_vh_status').click(function () {
//                
//            });
            $('#btn_vh_location').click(function () {
                vh_location_update($('#vh_id').val());
            });

            $('#cancel_group').click(function () {
                $('#group_name_pre').val('');
                $('#group_name').val('');
                hide_group_btn();
                
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

