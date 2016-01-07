<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<!-- @sampath wijesinghe -->
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
                            <span style="padding-right: 20px; font-size: 14px; font-weight: bold;">Vehicle List</span>
                            <span>
                                <label class="control-label custom-label">Supplier: </label>
                                <select id="cmb_supp"></select>
                            </span>
                            <span>
                                <label class="control-label custom-label">Status: </label>
                                <select id="cmb_stock_status">
                                    <option value="1">in stock</option>
                                    <option value="5">Sold</option>
                                    <option value="0">All</option>
                                </select>
                            </span>
                            <span class="">
                                <label class="control-label custom-label">records per page </label>
                                <select id="page_records">
                                    <option value="10">10</option>
                                    <option value="15" selected>15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <!--<input type="text" id="page_records" style="width: 40px" value="10"/>-->
                            </span>
                            <span>
                                <label class="control-label custom-label">Search by keywords: </label>
                                <input type="text" id="txt_search_key" class="custom-text1" data-toggle="tooltip" data-placement="bottom" title="type keywords seperated by spaces" style="width: 250px" onkeyup="set_focus_next(event, '#co_short_name')">
                            </span>
                            <button class="btn btn-custom-light" id="btn_stock_search" ><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                            <span class="pull-right">
                                <button class="btn btn-custom-save btn-sm" data-toggle="modal" data-target="#vh_actionsModal" id="btn_action" data-toggle="tooltip" data-placement="bottom" title="Perform actions on selected vehicles" >Actions</button>
                                <!--<button class="btn btn-custom-save btn-sm" id="genReport">Refresh Data</button>-->
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- MAIN CATEGORIES TABLE START-->
                                <div class="panel">
                                    <div class="scrollable" style="height:75vh; overflow-y: auto">
                                        <table class="view_vh_table table-data table-bordered datable searchable" border="1px">
                                            <!----> 
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>#</th>
                                                    <th>index</th>
                                                    <th>Marks</th>
                                                    <th>Sup</th>
                                                    <th>Maker</th>
                                                    <th>Model</th>
                                                    <th>CH_code</th>
                                                    <th>CH_Num</th>
<!--                                                    <th>En_Code</th>
                                                    <th>En Num</th>-->
                                                    <th>CC</th>
                                                    <th>Package</th>
                                                    <th>Year</th>
                                                    <th>Color</th>
                                                    <th>Milage</th>
<!--                                                    <th>Options</th>
                                                    <th>Other</th>
                                                    <th>Bided Date</th>
                                                    <th>Auction</th>
                                                    <th>Grade</th>-->
                                                    <!--<th>Coordinator</th>-->
                                                </tr>
                                            </thead>
                                            <tbody>                                                             
                                            </tbody>
                                        </table>
                                        <!--</div>-->
                                        <div>
                                            <div class="btn-group vh_view_pg" role="group" aria-label="...">
                                            </div>
                                        </div>
                                    </div>
                                    <!--MAIN CATEGORIES TABLE END-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vehicle Actions Modal -->
            <div class="modal fade" id="vh_actionsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Select an action</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label><input id="rbt_sell" type="radio" name="optradio">Sales & Payments</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label><input id="color" type="radio" name="optradio">Change Back Color</label>
                                                    <span id="clor_area" class="">&nbsp;<input type="text" id="selectedColor" class="color" disabled=""></span>
                                                </div>
                                            </div>
                                            <!--                                            <div class="form-group">
                                                                                            <div class="radio">
                                                                                                <label><input id="rbt_group" type="radio" name="optradio">Add to group</label>
                                                                                                <select id="cmb_vh_group"></select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <div class="radio">
                                                                                                <label><input id="rbt_set_properties" type="radio" name="optradio">Change Properties</label>
                                                                                            </div>
                                                                                        </div>
                                            -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-custom-save" id="continue_btn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Continue</button>
                            <button type="button" class="btn btn-custom-light" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php // require_once './include/footerBar.php'; ?>
            <!-- load JavaScript-->
            <?php require_once './include/systemFooter.php'; ?>
            <script type="text/javascript" src="js/jscolor/jscolor.js"></script>
    </body>
    <script type="text/javascript">
                                    $(function () {
//            $('select').chosen({width: "100%"});
                                        $('.datepicker').datepicker({
                                            format: 'yyyy-mm-dd'
                                        });
                                        pageProtect();
                                        checkurl();
                                        $('#color').click(function () {
                                            if ($(this).is(':checked')) {
                                                $('#selectedColor').removeAttr('disabled');
                                            }
                                        });

                                        $('#logout').click(function () {
                                            logout();
                                        });
                                        $('#btn_stock_search').click(function () {
                                            vehicle_keyword_search_local();
                                        });
                                        $('#cmb_supp').change(function () {
                                            load_vehicle_table_local();
                                            
//                                            load_vh_stock_types(null, function() {
//                                            });
                                        });
                                        $('#cmb_stock_status').change(function () {
                                            load_vehicle_table_local();
                                        });


                                        load_vhGroups();
                                        load_suppliers_vhlist(null, function () {
                                                load_vehicle_table_local();
//                                            load_vh_stock_types(null, function () {
//                                            });
                                        });

                                        $("#page_records").change(function () {
                                            load_vehicle_table_local(function () {
                                            });
                                        });

                                        $('#btn_action').click(function () {
                                            if ($('#cmb_stock_status').val() === '1' || $('#cmb_stock_status').val() === '2') {
                                                $('#rbt_inv').prop("disabled", false);
                                            } else {
                                                $('#rbt_inv').prop('checked', false);
                                                $('#rbt_inv').prop("disabled", true);
                                            }
                                        });
                                    });
                                    $('#continue_btn').click(function () {
//            $("#rbt_other").prop("checked", true)
                                        var searchIDs = $(".view_vh_table input:checkbox:checked").map(function () {
                                            return $(this).val();
                                        }).get(); // <----
//            console.log(searchIDs);
                                        if (parseInt(searchIDs.length) > 0) {
                                            if ($('#rbt_inv').is(':checked')) {
                                                selected_cars_temp_save(searchIDs);
                                            } else if ($('#color').is(':checked')) {
                                                add_colors_for_trs(searchIDs, $('#selectedColor').val());
                                            } else if ($('#rbt_web').is(':checked')) {
                                                submitSingleDataByPost("web_setvh_data.php", "vh_id_list", searchIDs);
                                            } else if ($('#rbt_modification').is(':checked')) {
                                                submitSingleDataByPost("vehicle_modification.php", "vh_id", searchIDs[0]);
                                            } else if ($('#rbt_set_properties').is(':checked')) {
                                                submitSingleDataByPost("vehicle_set_properties.php", "vh_id_list", searchIDs);
                                            } else if ($('#rbt_group').is(':checked')) {
                                                vh_group_save(searchIDs, $('#cmb_vh_group').val());
                                            } else if ($('#rbt_sell').is(':checked')) {
//                                                is_vehicleAvailableforSell(searchIDs[0]);
                                                submitSingleDataByPost("vehicle_sell.php", "vh_id", searchIDs[0]);
                                            }
                                        } else {
                                            alertify.error("No Vehicles Selected", 2000);
                                        }
                                    });
                                    function set_focus_next(e, next_comp) {
                                        e.which = e.which || e.keyCode;
                                        if (e.which === 13 && $('#txt_search_key').val().length > 1) {
                                            vehicle_keyword_search_local();
                                        }else if($('#txt_search_key').val().length ===0){
                                            load_vehicle_table_local();
                                        }
                                    }



    </script>
</html>

