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
                            <h3>Vehicle Technical Specification</h3>
                        </div>
                        <div class="row">
                            <ul class="nav nav-tabs">
                                <li id="link_one" class="elementToggle active"><a href="#spec_data_tab" data-toggle="tab">Specification Data</a></li>
                                <li id="link_two" class="elementToggle"><a href="#spec_view_tab" data-toggle="tab">View Data</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="spec_data_tab">
                                    <br/>
                                    <div class="col-md-6">
                                        <div class="form-horizontal">
                                            <input type="hidden" id="spec_id">

                                            <div class="form-group ">                                        
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
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Specification Title :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="spec_title" class="form-control custom-text1"  onkeyup="set_focus_next(event, '#v_eng_num')">                        
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Engine:</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="eng_cylinder" class="form-control custom-text1"  placeholder="Layout / number of cylinders"onkeyup="set_focus_next(event, '#v_eng_num')" >                        
                                                    <input type="text" id="eng_cc" class="form-control custom-text1"  placeholder="Displacement/Capacity"onkeyup="set_focus_next(event, '#v_eng_num')" >                        
                                                    <input type="text" id="eng_layout" class="form-control custom-text1"  placeholder="Engine Layout" onkeyup="set_focus_next(event, '#v_eng_num')" >                        
                                                    <input type="text" id="eng_hpower" class="form-control custom-text1"  placeholder="Horespower"onkeyup="set_focus_next(event, '#v_eng_num')" >                        
                                                    <input type="text" id="eng_rpm" class="form-control custom-text1"  placeholder="Max rpm"  onkeyup="set_focus_next(event, '#v_eng_num')" >                        
                                                    <input type="text" id="eng_torque" class="form-control custom-text1"  placeholder="Torque" onkeyup="set_focus_next(event, '#v_eng_num')" >                        
                                                    <input type="text" id="eng_comp_ratio" class="form-control custom-text1"  placeholder="Compression ratio" onkeyup="set_focus_next(event, '#v_eng_num')" >                        
                                                </div>
                                            </div>                                           
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Performance :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="perf_max_speed" class="form-control custom-text1" onkeyup="set_focus_next(event, '#perf_accelration')" placeholder="Top Track Speed">                        
                                                    <input type="text" id="perf_accelration" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_eng_num')" placeholder="0 - 60 mph"     >                                           
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Transmission :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="trans_type" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_eng_num')" placeholder="Transmission Type">                        
                                                    <input type="text" id="trans_desc" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_eng_num')" placeholder="Description">                                           
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Fuel Consumption :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="fuel_cons_city" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_eng_num')" placeholder="City">                        
                                                    <input type="text" id="fuel_cons_highway" class="form-control custom-text1" onkeyup="set_focus_next(event, '#bd_len')" placeholder="Highway">                                           
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Body :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="bd_len" class="form-control custom-text1" onkeyup="set_focus_next(event, '#bd_wid')" placeholder="Length">                        
                                                    <input type="text" id="bd_wid" class="form-control custom-text1" onkeyup="set_focus_next(event, '#bd_hei')" placeholder="Width">                                           
                                                    <input type="text" id="bd_hei" class="form-control custom-text1" onkeyup="set_focus_next(event, '#bd_wheelbase')" placeholder="Height">                                           
                                                    <input type="text" id="bd_wheelbase" class="form-control custom-text1" onkeyup="set_focus_next(event, '#bd_maxpayload')" placeholder="Wheelbase">                                           
                                                    <input type="text" id="bd_maxpayload" class="form-control custom-text1" onkeyup="set_focus_next(event, '#bd_curb_weight')" placeholder="Maximum payload">                                           
                                                    <input type="text" id="bd_curb_weight" class="form-control custom-text1" onkeyup="set_focus_next(event, '#cap_fuel_tank')" placeholder="Curb weight">                                           
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Capacities :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="cap_fuel_tank" class="form-control custom-text1" onkeyup="set_focus_next(event, '#cap_luggage')" placeholder="Fuel Tank Capacity">                        
                                                    <input type="text" id="cap_luggage" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_eng_num')" placeholder="Luggage compartment volume">                                           
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-4 col-lg-8">
                                                    <span  id="spec_save_div" class="">
                                                        <button class="btn btn-custom-save" id="spec_save_btn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                                    </span>
                                                    <span  id="spec_updateDiv" class="hidden">
                                                        <button class="btn btn-custom-save" id="spec_update_btn"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                                    </span>
                                                    <span  id="spec_reset_div" class="">
                                                        <button class="btn btn-custom-light" id="spec_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="spec_view_tab">
                                    <div>
                                        <div class="panel" style="">
                                            <div class="panel-heading panel-custom">
                                                <h3 class="panel-title title-custom">Vehicle Specifications</h3>
                                            </div>
                                            <div class="scrollable" style="height: 200px; overflow-y: auto">
                                                <table class="table table-bordered table-striped table-hover datable spec_info_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Spec Title</th>
                                                            <th>Engine CC</th>
                                                            <th>Engine RPM</th>
                                                            <th>Max Speed</th>
                                                            <th>Transmission Type</th>
                                                            <th>Fuel Consumption</th>
                                                            <th>Curb Weight</th>
                                                            <th>Fuel Tank capacity</th>
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
//            load_maker_table();
            load_makers_cmb(false, function () {
                load_model_cmb($('.maker_ComboBox').val(), false, function () {
                    spec_table();
                });
            });
            $('.maker_ComboBox').change(function () {
                load_model_cmb($('.maker_ComboBox').val(), false, function () {
                    spec_table();
                });
            });
            $('.model_ComboBox').change(function () {
                spec_table();
            });
            $('#spec_save_btn').click(function () {
                vehicle_spec_save();
            });
            $('#spec_update_btn').click(function () {
                vehicle_spec_update();
            });
            $('#spec_reset').click(function () {
                reset_spec();
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

