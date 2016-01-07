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
                            <h3>Set Web site data<small> &nbsp; Select vehicles from Vehicle List</small></h3>
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

                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label required">Vehicle Marks* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" disabled="" id="v_code_num" class="form-control custom-text1">
                                            <input type="hidden" disabled="" id="vh_id">
                                        </div>
                                    </div>
                                    <!--                                <div class="form-group ">                                        
                                                                            <label class="col-lg-4 control-label custom-label">Maker* :</label>
                                                                            <div class="col-lg-6 maker_comboDiv">
                                                                                <select class="maker_ComboBox"></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">                                        
                                                                            <label class="col-lg-4 control-label custom-label">Model * :</label>
                                                                            <div class="col-lg-6 ">
                                                                                <select class="model_ComboBox"></select>
                                                                            </div>
                                                                        </div>    -->
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Currency:</label>
                                        <div class="col-lg-6 ">
                                            <select class="cmb_currency">
                                                <option value="LKR">LKR</option>
                                                <option value="JPY">JPY</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Display Price :</label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <input type="text" id="vh_disp_price" class="form-control custom-text1" onkeyup="set_focus_next(event, '#company_tel1')">
                                                <span class="input-group-addon currency" id="currency1"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Select Specification :</label>
                                        <div class="col-lg-6 spec_comboDiv">
                                            <select class="spec_ComboBox"></select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Stock Status:</label>
                                        <div class="col-lg-6 ">
                                            <select id="cmb_stock_status">
                                                <option value="1">in stock</option>
                                                <option value="2">reserved</option>
                                                <option value="3">clearing</option>
                                                <option value="4">cleared</option>
                                                <option value="5">sold</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio col-lg-offset-4">
                                            <label>
                                                <input type="radio" name="rbt_data_visible" id="rbt_data_all" value="da"/>Record visible to all
                                            </label>
                                        </div>
                                        <div class="radio col-lg-offset-4">
                                            <label>
                                                <input type="radio" name="rbt_data_visible" id="rbt_data_coord" value="dc"/>Record visible to Coordinators only
                                            </label>
                                        </div>
                                        <div class="radio col-lg-offset-4">
                                            <label>
                                                <input type="radio" name="rbt_data_visible" id="rbt_data_hidden" value="dh" checked/>Record Hidden
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio col-lg-offset-4">
                                            <label>
                                                <input type="radio" name="rbt_price_visible" id="rbt_price_all" value="pa"/>Price visible to all
                                            </label>
                                        </div>
                                        <div class="radio col-lg-offset-4">
                                            <label>
                                                <input type="radio" name="rbt_price_visible" id="rbt_price_coord" value="pc"/>Price visible to Coordinators only
                                            </label>
                                        </div>
                                        <div class="radio col-lg-offset-4">
                                            <label>
                                                <input type="radio" name="rbt_price_visible" id="rbt_price_hidden" checked="" value="ph"/>Price Hidden
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <button class="btn btn-custom-light" id="btn_vh_ft" data-toggle="modal" data-target="#vh_features_mod">Select Vehicle Features <i class="fa fa-hand-o-up fa-sm"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
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
                                    </div>
                                </div>
                                <!-- FORM END -->
                            </div>
                            <div class="col-md-6">
                                <!--                                <div class="row" id="feature_boxDiv">
                                                                    <div class="scrollable">
                                                                        <table class="table features_table table-data">
                                                                            <tbody>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>-->
                                <div class="row">
                                    <div class="panel" style="">
                                        <div class="panel-heading panel-custom">
                                            <h3 class="panel-title title-custom">Select Vehicle</h3>
                                        </div>
                                        <div class="scrollable" style="height: 200px; overflow-y: auto">
                                            <table id="send_web_selected" class="table table-bordered table-striped table-data">
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
                                    <div class="panel" style="">
                                        <div class="panel-heading panel-custom">
                                            <h3 class="panel-title title-custom">Vehicles in Web</h3>

                                            <div class="pull-right">
                                                <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                    <i class="glyphicon glyphicon-filter"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="panel-body filterTableSearch">
                                            <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".tbl_vh_web"/>
                                        </div>
                                        <div class="scrollable" style="height: 65vh; overflow-y: auto">
                                            <table class="table table-bordered table-striped table-hover datable tbl_vh_web">
                                                <thead>
                                                    <tr>
                                                        <th>Maker</th>
                                                        <th>Model</th>
                                                        <th>Chassis Code</th>
                                                        <th>Code</th>
                                                        <th>Year</th>
                                                        <th>&nbsp;</th>
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
        <!-- customer search Modal -->
        <div class="modal fade" id="vh_features_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Select features</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row" id="feature_boxDiv">
                                <div class="scrollable">
                                    <table class="table features_table table-data">
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-light" data-dismiss="modal">OK</button>
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
            if ($('#vh_list').val().length > 0) {
                sendWeb_selectedVh($('#vh_list').val());
            }
//                                                    load_makers_cmb(false, function() {
//                                                        load_model_cmb($('.maker_ComboBox').val(), false, function() {
////                                                            load_spec_list($('.model_ComboBox').val());
//                                                        });
//                                                    });
            $("input[type='radio'][name='rbt_price_visible']").prop("disabled", true);
            //
            load_vh_features_table();
            vh_inweb();

            $('#logout').click(function () {
                logout();
            });

            $('#webvh_save_btn').click(function () {
                vehicle_webdata_save();
            });

            $('.cmb_currency').change(function () {
                $('.currency').html($('.cmb_currency').val());
            });

            $("input[type='radio'][name='rbt_data_visible']").change(function () {
//                if ($('#rbt_data_hidden').is(':checked')) {
//                    $('#rbt_price_hidden').prop('checked', true);
//                    $("input[type='radio'][name='rbt_price_visible']").prop("disabled", true);
//                } else if ($('#rbt_data_coord').is(':checked')) {
//                    $('#rbt_price_hidden').prop("disabled", false);
//                    $('#rbt_price_coord').prop("disabled", false);
//                    $('#rbt_price_all').prop("disabled", true);
//                    $('#rbt_price_hidden').prop('checked', true);
//                } else {
//                    $('#rbt_price_coord').prop("disabled", false);
//                    $('#rbt_price_all').prop("disabled", false);
//                    $('#rbt_price_hidden').prop('checked', false);
//                }
                webdata_switch_rbt(1);
            });
            $('#rbt_data_all').change(function () {
                if ($('#rbt_data_all').is(':checked')) {
                    $("input[type='radio'][name='rbt_price_visible']").prop("disabled", false);
                }
            });
            $('#webvh_reset').click(function () {
                reset_web_vhdata_form();
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

