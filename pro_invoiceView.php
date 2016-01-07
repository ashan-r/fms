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
        <!-- DataTables CSS -->
    </head>
    <body class="green-back">
        <div id="wrap">
            <!--load navigation bar-->
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">               
                <div class="row">                                 
                    <div class="col-md-12">
                        <div class="page-header cutom-header" style="">
                            <span style="padding-right: 20px; font-size: 14px; font-weight: bold;">View Pro-forma Invoices</span>
                            <span>
                                <label class="control-label custom-label">Show: </label>
                                <select id="cmb_inv_status">
                                    <option value="1">Valid Invoices</option>
                                    <option value="90">Canceled Invoices</option>
                                </select>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- MAIN CATEGORIES TABLE START-->
                                <div class="panel">
                                    <div class="scrollable" style="height: 510px; overflow-y: auto">
                                        <table class="table table-bordered table-data table-striped load_proInvoiceView_table" id="">
                                            <thead>
                                                <tr>
                                                    <th>Invoice No.</th>
                                                    <th>Invoice Date</th>
                                                    <th>Customer</th>
                                                    <th>Consignee</th>
                                                    <th>Shipment Date</th>
                                                    <th>Port - Discharge</th>
                                                    <th>Validity</th>
                                                    <!--<th>Presentation Period</th>-->
                                                    <th>Total CIF</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--MAIN CATEGORIES TABLE END-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- load JavaScript-->
        <?php require_once './include/systemFooter.php'; ?>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.min.js"></script>
    </body>
    <script type="text/javascript">

        $(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            pageProtect();
            checkurl();
            load_proInvoiceView_table(function() {
                $('.load_proInvoiceView_table').DataTable();
            });

            $('#logout').click(function() {
                logout();
            });

//            $('select').chosen({width: "100%"});

            /// cansel invoice
            $(document).on("click", ".cansel_prIn", function() {
                cancel_proFormaInvoice($(this).val());
            });
            //// re print invoice
            $(document).on("click", ".reprint_inv", function() {
                var inv_ID = $(this).val();
                var inv_type = $(this).data("invtype");
                if (inv_type === "L") {
                    submitSingleDataByPost("pro_invoicePrint2.php", "pi_id", inv_ID);
                } else {
                    submitSingleDataByPost("pro_invoicePrint.php", "pi_id", inv_ID);
                }
            });
            /// edit invoice
            $(document).on("click", ".edit_prInv", function() {
                var inv_ID = $(this).val();
                confirm("Edit Pro-forma Invoice", "Are You Sure You Want To Edit This record", "No", "Yes", function() {
                    submitSingleDataByPostSpecial("pro_forma_inv.php", "ref_id", inv_ID, "is_edit", 1);
                });
            });
            $('#cmb_inv_status').change(function() {
                load_proInvoiceView_table(function() {
                    $('.load_proInvoiceView_table').DataTable();
                });
            });
//            $(document).on("click", ".print_prIn", function () {
//                // how to select format1/format2 ????
//                var inv_ID = $(this).val();
//                submitSingleDataByPostNewTab("pro_forma_inv.php", "ref_id", inv_ID, "is_edit", 1);
//                cancel_proFormaInvoice($(this).val());
//            });

        });

    </script>
</html>

