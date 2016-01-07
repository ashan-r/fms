<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once './include/systemHeader.php'; ?>        
    </head>
    <body class="green-back">
        <div id="">
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="page-header cutom-header">
                        <h3>Stock Report</h3>
                    </div>
                    <div class="form-horizontal hidden-print col-md-6">
                        <div class="form-group ">                                        
                            <label class="col-lg-4 control-label custom-label">Stock Location :</label>
                            <div class="col-lg-6 v_location_cmbDiv">
                                <select class="v_location_cmb"></select>
                            </div>
                        </div>
                        <div class="form-group">                           
                            <div class="col-lg-offset-4 col-lg-8">
                                <button class="btn btn-primary col-md-4" id="genReport">Generate Report</button>
                                <button class="btn btn-default col-md-4" onclick="print()" style="margin-left: 0px;">Print</button>
                            </div>
                        </div>                       

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span id="rep_date"> As at <?php echo date('Y-m-d, h:i:s A')?></span>
                        <table class="table table-bordered table-striped table-striped" id="tlReport">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Maker</th>
                                    <th>Model</th>
                                    <th>Code</th>
                                    <th>import date</th>
                                    <th>Chassis No.</th>
                                    <th>Purchase Type</th>
                                    <!--<th>Cost</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="12" class="text-center">click Generate button to view report</th>
                                </tr>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once './include/systemFooter.php'; ?>
        <script>
            //
            function genarate_stock_Report(st_location, all) {
                var tableData = "";
                var tableDataFoot = "";
                var totalAmount = 0;
                $.post("views/loadTables.php", {table: "report_vh_stock", st_location: st_location, all: all}, function (e) {
                    if (e === undefined || e.lenght === 0 || e === null) {
                        tableData += '<tr>';
                        tableData += '<th colspan="12"> No Data Found ...</th>';
                        tableData += '</tr>';
                    } else {
                        $.each(e, function (index, qData) {
                            tableData += '<tr>';
                            tableData += '<td>' + qData.stock_location + '</td>';
                            tableData += '<td>' + qData.maker_name + '</td>';
                            tableData += '<td>' + qData.mod_name + '</td>';
                            tableData += '<td>' + qData.vh_code + '</td>';
                            tableData += '<td>' + qData.import_date + '</td>';
                            tableData += '<td>' + qData.vh_chassis_code + '-' + qData.vh_chassis_num + '</td>';
                            if (qData.vh_purchase_type == '0') {
                                tableData += '<td>Purchased</td>';
                            } else {
                                tableData += '<td>Exchange</td>';
                            }
//                            tableData += '<td style="text-align:right;">' + Number(qData.tot_cost).toFixed(2) + '</td>';
                            tableData += '</tr>';
//                            totalAmount += parseFloat(qData.tot_cost);
                        });
//                        tableDataFoot += "<tr>";
//                        tableDataFoot += "<th colspan='5'></th>";
//                        tableDataFoot += "<th style='text-align:right;'>" + Number(totalAmount).toFixed(2) + "</th>";
//                        tableDataFoot += "</tr>";
                    }
                    $("#rep_date").html("As at: "+new Date().toString().slice(0,24));
                    $("#tlReport tbody").html("").append(tableData);
                    $("#tlReport tfoot").html("").append(tableDataFoot);
                }, "json");
            }
            
            function load_stock_values(sys_type, combo, callBack) {
                var comboData = '';
                $.post("views/loadComboBox.php", {comboBox: 'syscode_types', sys_type: sys_type}, function (e) {
                    if (e === undefined || e.length === 0 || e === null) {
                        comboData += '<option value="0"> -- No Data Found -- </option>';
                    } else {
                            comboData += '<option value="0">All</option>';
                        $.each(e, function (index, qData) {
                            comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                        });
                    }
                    $(combo).html('').append(comboData);
                    chosenRefresh();
                    if (callBack !== undefined) {
                        if (typeof callBack === 'function') {
                            callBack();
                        }
                    }
                }, "json");
            }

            $(function () {
                $('select').chosen({width: "100%"});
                $(".dp").datepicker({
                    format: "yyyy-mm-dd"
                });

                $("#genReport").click(function () {
                    var all = 0;
                    var location = $('.v_location_cmb').val();
                    genarate_stock_Report(location, all);
                });
                load_stock_values('35', '.v_location_cmb');
            });
        </script>
    </body>
</html>
