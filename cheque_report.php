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
                        <h3>Recived Cheques</h3>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="col-md-5 control-label">Cheque Type</label>
                                <div class="col-md-7">
                                    <select id="cmb_chq_type">
                                        <option value="0">Unrealized</option>
                                        <option value="1">Realized</option>
                                    </select>
                                </div>
                            </div>                       
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">                           
                                <div class="col-md-12 btn-group">
                                    <button class="btn btn-primary col-md-8" id="gencheque_report">Generate Report</button>
                                    <button class="btn btn-default col-md-4" onclick="print()" style="margin-left: 0px;">Print</button>
                                </div>
                            </div>                       
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped table-striped" id="chequeReport">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Pay Date</th>
                                    <th>Cheque Date</th>
                                    <th>Cheque Number</th>
                                    <th>Amount</th>
                                    <!--<th>Chassis No.</th>-->
                                    <th>Bank Name</th>
                                    <th>Transfered account</th>
                                    <th>Action key</th>
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
            function genarate_cheque_Report() {
                var firstDate = $("#firstDate").val();
                var endDate = $("#endDate").val();
                var chq_type = parseInt($("#cmb_chq_type").val());
                var tableData = "";
                $.post("views/loadTables.php", {table: "report_cheque", firstDate: firstDate, endDate: endDate,chq_type:chq_type}, function (e) {
                    if (e === undefined || e.lenght === 0 || e === null) {
                        tableData += '<tr>';
                        tableData += '<th colspan="12"> No Data Found ...</th>';
                        tableData += '</tr>';
                    } else {
                        $.each(e, function (index, qData) {
                            tableData += '<tr>';
                            tableData += '<td>' + qData.cus_inv_name + '</td>';
                            tableData += '<td>' + qData.pay_date + '</td>';
                            tableData += '<td>' + qData.chq_date + '</td>';
                            tableData += '<td>' + qData.chq_num + '</td>';
                            tableData += '<td>' + qData.in_amount + '</td>';
//                            tableData += '<td>' + qData.pay_confirmed + '</td>';
                            tableData += '<td>' + qData.pay_bank + '</td>';
                            tableData += '<td>' + qData.bank_account + '</td>';
                            tableData += '<td>';
                                    if (parseInt(qData.pay_confirmed)===0) {
                                      tableData += '<div class="btn-group">'
                                        + '<button class="btn btn-custom-save update_cheque" value="' + qData.vp_id + '"><i class="fa fa-usd"></i>&nbsp;Confirm</button></div></td>';
                                    }else{
                                         tableData +='Realized</td>';
                                    }
                            tableData += '</tr>';
                        });

                    }
                    $("#chequeReport tbody").html("").append(tableData);
                }, "json");
            }

            $(function () {


                $('select').chosen({width: "100%"});
                $(".dp").datepicker({
                    format: "yyyy-mm-dd"
                });


                $("#gencheque_report").click(function () {
                    genarate_cheque_Report(firstDate, endDate);
                });


                $(document).on('click', '.update_cheque', function () {
                    update_cheque_Report($(this).val());
                });


            });

            function update_cheque_Report(up_c_val) {
                var tableData = "";
                $.post("views/commenSettingView.php", {action: "report_cheque_ipdate", up_c_val: up_c_val}, function (e) {
                    if (e === undefined || e.lenght === 0 || e === null) {
                        alertifyMsgDisplay(e, 1000);
                    } else {
                        alertifyMsgDisplay(e, 1000);
                        genarate_cheque_Report();
                    }
                }, "json");
            }


        </script>
    </body>
</html>
