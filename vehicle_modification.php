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
                            <h3>Vehicle Modifications</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <input type="hidden" id="modd_id">
                                    <input type="hidden" id="vh_reg_id" value="<?php
                                    if (isset($_REQUEST['vh_id'])) {
                                        echo $_REQUEST['vh_id'];
                                    }
                                    ?>">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Date* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="modi_date" class="form-control custom-text1 datepicker" value="<?php echo date("Y-m-d"); ?>" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Description* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="modi_desc" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Vehicle :</label>
                                        <div class="col-lg-6">
                                            <select id="modi_vehicle" class="vahicle_code_combo"></select>
                                        </div>
                                        <!--<button class="btn btn-custom-light" id="btn_vh_search" data-toggle="modal" data-target="#vh_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>-->
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Requested Customer :</label>
                                        <div class="col-lg-6 coord_category_comboDiv">
                                            <select id="modi_custmr" class="customer_ComboBox"></select>
                                        </div>
                                        <button class="btn btn-custom-light" id="btn_cust_search" data-toggle="modal" data-target="#cus_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Options:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="modi_options" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Accessories:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="modi_other_options" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group hidden">                                        
                                        <label class="col-lg-4 control-label custom-label">Status :</label>
                                        <div class="col-lg-6 coord_category_comboDiv">
                                            <select id="modi_status" class="modification_statusCombo"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="mod_save_div" class="">
                                                <button class="btn btn-custom-save" id="deh_modi_saveBtn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                            </span>
                                            <span  id="mod_update_div" class="hidden">
                                                <button class="btn btn-custom-save" id="deh_modi_updtBtn"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                            </span>
                                            <span  id="mod_reset_div" class="">
                                                <button class="btn btn-custom-light" id="deh_modi_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
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
                                        <h3 class="panel-title title-custom">Modifications History</h3>

                                        <div class="pull-right">
                                            <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                <i class="glyphicon glyphicon-filter"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="panel-body filterTableSearch">
                                        <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".coord_info_table"/>
                                    </div>
                                    <div class="scrollable" style="height: 300px; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-hover datable vehicleModiTable">
                                            <thead>
                                                <tr>
                                                    <th>Vehicle</th>
                                                    <th>Customer</th>
                                                    <th>Description</th>
                                                    <th>Options</th>
                                                    <th>Other Options</th>
                                                    <th>Date</th>
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
        <!-- vehicle search Modal -->
        <div class="modal fade" id="vh_searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Search Vehicle</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="scrollable" style="height: 300px; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-data table-hover datable vh_search_result">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Maker</th>
                                                    <th>Model</th>
                                                    <th>Chassis No</th>
                                                    <th>Colour</th>
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
                                                    //
                                                    var vh_id = $('#vh_reg_id').val();
                                                    if (parseInt(vh_id) > 0) {
                                                        $('#modi_vehicle').html('').append('<option value="' + vh_id + '">SELCTED VEHICLE</option>');
                                                        vehicleModiTable(vh_id);
                                                    } else {
                                                        vahicle_code_combo(false, function () {
                                                            load_vh_info($('.vahicle_code_combo').val());
                                                            vehicleModiTable($('.vahicle_code_combo').val());
                                                        });

                                                    }
                                                    modification_statusCombo();
                                                    load_customer_cmb();

                                                    search_cust("text", function () {
                                                        $('.cus_search_result').DataTable();
                                                    });

                                                    search_vehicle(function () {
                                                        $('.vh_search_result').DataTable();
                                                    });
//
                                                    $('#deh_modi_saveBtn').click(function () {// save
                                                        vehicleModification_save();
                                                    });
                                                    $('.vahicle_code_combo').change(function () {
                                                        load_vh_modinfo($('.vahicle_code_combo').val());
                                                        vehicleModiTable($('.vahicle_code_combo').val());
                                                    });
                                                    $('#deh_modi_reset').click(function () {
                                                        vehModification_reset();
                                                    });


                                                    $('#deh_modi_updtBtn').click(function () {
                                                        vehModification_update();
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

