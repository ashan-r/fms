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
                        <h3>Imported Vehicles</h3>
                    </div>
                    <div class="form-horizontal hidden-print col-md-12">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="col-md-5 control-label">First Date</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control dp" id="firstDate">
                                </div>
                            </div>                        
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="col-md-5 control-label">End Date</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control dp" id="endDate" value="<?php echo date("Y-m-d"); ?>">
                                </div>
                            </div>                       
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">                           
                                <div class="col-md-12 btn-group">
                                    <button class="btn btn-primary col-md-8" id="genReport">Generate Report</button>
                                    <button class="btn btn-default col-md-4" onclick="print()" style="margin-left: 0px;">Print</button>
                                </div>
                            </div>                       
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span id="prnt_from"></span>
                        <span id="prnt_to"></span>
                        <table class="table table-bordered table-striped table-striped" id="tlReport">
                            <thead>
                                <tr>
                                    <th>import date</th>
                                    <th>Code</th>
                                    <th>Maker</th>
                                    <th>Model</th>
                                    <th>Chassis No.</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="12" class="text-center">Please select first,last date and other options,then click generate button for view report</th>
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
            function genarate_import_Report(firstDate, endDate, orderby, all) {
                var tableData = "";
                var tableDataFoot = "";
                var totalAmount = 0;
//                var totalVat = 0;
//                var totalNbt = 0;
//                var totalstamp = 0;
//                var totalPaidTotal = 0;
                $.post("views/loadTables.php", {table: "report_imported_vehicle", firstDate: firstDate, endDate: endDate, orderby: orderby, all: all}, function (e) {
                    if (e === undefined || e.lenght === 0 || e === null) {
                        tableData += '<tr>';
                        tableData += '<th colspan="12"> No Data Found ...</th>';
                        tableData += '</tr>';
                    } else {
                        $.each(e, function (index, qData) {
                            tableData += '<tr>';
                            tableData += '<td>' + qData.import_date + '</td>';
                            tableData += '<td>' + qData.vh_code + '</td>';
                            tableData += '<td>' + qData.maker_name + '</td>';
                            tableData += '<td>' + qData.mod_name + '</td>';
                            tableData += '<td>' + qData.vh_chassis_code + '-' + qData.vh_chassis_num + '</td>';
                            tableData += '<td style="text-align:right;">' + Number(qData.tot_cost).toFixed(2) + '</td>';
                            tableData += '</tr>';
                            totalAmount += parseFloat(qData.tot_cost);
                        });
                        tableDataFoot += "<tr>";
                        tableDataFoot += "<th colspan='5'></th>";
                        tableDataFoot += "<th style='text-align:right;'>" + Number(totalAmount).toFixed(2) + "</th>";
                        tableDataFoot += "</tr>";
                    }
                    $("#tlReport tbody").html("").append(tableData);
                    $("#tlReport tfoot").html("").append(tableDataFoot);
                    $("#prnt_from").html("from "+firstDate);
                    $("#prnt_to").html("to "+endDate);
                    
                }, "json");
            }

            $(function () {
//                setInterval(function () {
//                    accessControl();
//                }, 600000);

                $('select').chosen({width: "100%"});
                $(".dp").datepicker({
                    format: "yyyy-mm-dd"
                })

//                $(window).load(function () {
//                    genarateReport();
//                });


//                alert(x);

                $("#genReport").click(function () {
                    var all = 0;
                    if ($('#all').prop('checked')) {
                        all = 1;
                    }
//                    alert(all);
                    var firstDate = $("#firstDate").val();
                    var endDate = $("#endDate").val();
                    var orderby = $('.bank_name_ComboBox').val();
                    genarate_import_Report(firstDate, endDate, orderby, all);
                });
            });

        </script>
    </body>
</html>
