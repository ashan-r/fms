<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<!-- @SACHITH -->
<html>
    <head>  
        <!--load CSS styles-->     
        <style>
            @page {
                size: A4;
                margin-left: 2cm;;
            }
            @media print {
                .page {
                    margin: 2cm;
                    border: initial;
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    box-shadow: initial;
                    background: initial;
                    /*page-break-after: always;*/
                }
                .hide_content{
                    display: none;  
                }  
            }

            #tbl2 {
                border-collapse: collapse;
            }
            #tbl2 thead th {
                border-bottom: 1px solid black;
            }
            #tbl2 tbody td{
                border-right: 1px solid black;
            }
            .font-small{
                font-size: 9pt;
            }
            .font-xsmall{
                font-size: 8pt;
            }
        </style>
    </head>
    <body>
        <button class="hide_content" onclick="window.print()" id="print"><b>Print</b></button>
         <a href="view_vehicle_list.php" class="hide_content" id="back">Vehicle List</a>
        <?php
        $numrows = 0;
        $pinv_data_arr;
        if (isset($_POST['pi_id'])) {

            MainConfig::connectDB();
            $query = "SELECT
            proforma_inv.pi_no,
            proforma_inv.pi_date,
            proforma_inv.consignee_name,
            proforma_inv.consignee_address,
            proforma_inv.port_loading,
            proforma_inv.port_discharge,
            proforma_inv.shipment_time,
            proforma_inv.payment_term,
            proforma_inv.validity,
            proforma_inv.total_cif,
            proforma_inv.currency,
            proforma_inv.partial_shipment,
            proforma_inv.transshipment,
            proforma_inv.presentation_period,
            proforma_inv.last_shipment_date,
            proforma_inv.lc_charges,
            proforma_inv.hs_code,
            proforma_inv.confirmation,
            proforma_inv.lc_advice,
            proforma_inv.advising_bank_id,
            proforma_inv.pi_status,
            proforma_inv.supp_id,
            supp_bank.bank_name,
            supp_bank.swift,
            supp_bank.branch,
            supp_bank.ac_num,
            customer.cus_inv_name,
            customer.cus_inv_address,
            supplier.inv_name,
            supplier.inv_address,
            supplier.supp_email,
            supplier.web,
            supplier.supp_fax,
            supplier.inv_phone
            FROM proforma_inv
            INNER JOIN customer ON proforma_inv.cus_id = customer.cus_id
            INNER JOIN supp_bank ON proforma_inv.advising_bank_id = supp_bank.bank_id
            INNER JOIN supplier ON supplier.supp_id = proforma_inv.supp_id
            WHERE proforma_inv.pi_id = '{$_POST['pi_id']}'";
            $pinv_res = mysql_query($query);
            $numrows = mysql_num_rows($pinv_res);
            MainConfig::closeDB();
            if ($numrows === 1) {
                $pinv_data_arr = mysql_fetch_assoc($pinv_res);
            }
//            print_r($pinv_data_arr);
        } else {
            echo 'invalid invoice';
        }
        ?>
        <div style="text-align: center; border-bottom: 2px solid black;">
            <div><h3 style="font-style: italic;"><?php echo $pinv_data_arr['inv_name']; ?></h3>
            </div>
            <div class="font-small" style="font-weight: bold;">

                <div>
                    <span> <?php
                        echo
                        $pinv_data_arr['inv_address'];
                        ?></span>
                </div>
                <div>
                    <span>TEL:&nbsp; <?php echo $pinv_data_arr['inv_phone']; ?></span>&nbsp;&nbsp;<span>FAX: &nbsp; <?php echo $pinv_data_arr['supp_fax']; ?></span>
                </div>
                <div>
                    <span>EMAIL: &nbsp; <?php echo $pinv_data_arr['supp_email']; ?></span>&nbsp;&nbsp;<span>WEB: &nbsp; <?php echo $pinv_data_arr['web']; ?></span>
                </div>
                <div style="padding-top: 15px; padding-bottom: 10px;">
                    <span>PRO-FORMA INVOICE</span>
                </div>
            </div>
        </div>
        <!---------------------------- body --------------------------------------------------->
        <div>
            <div style="padding-top: 10px;"><span class="font-small" style="font-weight: bold;">DATE :  <?php echo $pinv_data_arr['pi_date']; ?></span><span style="float: right; margin-right: 10%; font-weight: bold;" class="font-small">INVOICE NO : <?php echo $pinv_data_arr['pi_no']; ?></span></div>
            <div style="padding-top: 18px;" class="font-small">
                <table style="width: 100%;">
                    <colgroup>
                        <col style="width: 30%;" />
                        <col style="width: 70%;" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <td>CUSTOMER NAME</td>
                            <td><?php echo $pinv_data_arr['cus_inv_name']; ?></td>
                        </tr>
                        <tr>
                            <td>ADDRESS</td>
                            <td>
                                <?php echo $pinv_data_arr['cus_inv_address']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>CONSIGNEE</td>
                            <td><?php echo $pinv_data_arr['consignee_name']; ?></td>
                        </tr>
                        <tr>
                            <td>ADDRESS</td>
                            <td>
                                <?php echo $pinv_data_arr['consignee_address']; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%; margin-top: 10px;">
                    <colgroup>
                        <col style="width: 30%;" />
                        <col style="width: 70%;" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <td>PORT OF LOADING</td>
                            <td><?php echo $pinv_data_arr['port_loading']; ?></td>
                        </tr>
                        <tr>
                            <td>PORT OF DISCHARGE</td>
                            <td><?php echo $pinv_data_arr['port_discharge']; ?></td>
                        </tr>
                        <tr>
                            <td>TIME OF SHIPMENT</td>
                            <td><?php echo $pinv_data_arr['shipment_time']; ?></td>
                        </tr>
                        <tr>
                            <td>TIME OF PAYMENT</td>
                            <td><?php echo $pinv_data_arr['payment_term']; ?></td>
                        </tr>
                        <tr>
                            <td>VALIDITY</td>
                            <td><?php echo $pinv_data_arr['validity']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--<div style="text-align: center; padding-top: 20px; text-decoration: underline;">DESCRIPTION OF MOTOR VEHICLE</div>-->
            <div style="padding-top: 20px;">
                <table style="width: 100%; border: 1px solid black;" class="font-small" id="tbl2">
                    <thead>
                        <tr>
                            <th>REMARKS</th>
                            <th colspan="3">DESCRIPTION OF MOTOR VEHICLE</th>
                            <th colspan="2">AMOUNT</th>
<!--                            <th colspan="2">CHASSIS NO</th>
                            <th>ENGINE CAPACITY</th>
                            <th>YEAR</th>
                            <th colspan="2">Q'TY</th>
                            <th colspan="2">AMOUNT</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $units = 0;
                        $total_cif = 0;
                        $vh_data;
                        MainConfig::connectDB();
                        $vh_data;
                        if ($numrows > 0) {
                            $query2 = "SELECT
                        vehicle.vh_code,
                        vehicle.vh_chassis_code,
                        vehicle.vh_chassis_num,
                        vehicle.engine_cc,
                        vehicle.vh_year,
                        pi_entries.tot_amt,
                        pi_entries.vh_amt,
                        pi_entries.insuarance,
                        pi_entries.freight,
                        maker_model.mod_name,
                        maker.maker_name,
                        vehicle.engine_code,
                        vehicle.engine_num
                        FROM
                        pi_entries
                        INNER JOIN vehicle ON pi_entries.vh_id = vehicle.vh_id
                        INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
                        INNER JOIN maker ON maker_model.maker_id = maker.maker_id
                        WHERE
                        pi_entries.pi_id = '{$_POST['pi_id']}'";
                            $pientries_res = mysql_query($query2);
                            if (mysql_num_rows($pientries_res) > 0) {
                                $vh_data = mysql_fetch_assoc($pientries_res);
                            }
                        }
                        MainConfig::closeDB();
                        ?>
                        <tr>
                            <td rowspan="8"><?php echo $vh_data['vh_code']; ?></td>
                            <td>MAKER</td>
                            <td><?php echo $vh_data['maker_name']; ?></td>
                            <td>&nbsp;</td>
                            <td style="border-right: 1px solid black;">&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>MODEL NAME</td>
                            <td><?php echo $vh_data['mod_name']; ?></td>
                            <td>&nbsp;</td>
                            <td>FOB</td>
                            <td><?php echo $vh_data['vh_amt']; ?></td>
                        </tr>
                        <tr>
                            <td>MODEL NO</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>FREIGHT</td>
                            <td><?php echo $vh_data['freight']; ?></td>
                        </tr>
                        <tr>
                            <td>YEAR</td>
                            <td><?php echo $vh_data['vh_year']; ?></td>
                            <td>&nbsp;</td>
                            <td>INSURANCE</td>
                            <td><?php echo $vh_data['insuarance']; ?></td>
                        </tr>
                        <tr>
                            <td>CHASSIS NO</td>
                            <td><?php echo $vh_data['vh_chassis_code'].'-'.$vh_data['vh_chassis_num']; ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>ENGINE NO</td>
                            <td><?php echo $vh_data['engine_code'].'-'.$vh_data['engine_num']; ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>ENGINE CAPACITY</td>
                            <td><?php echo $vh_data['engine_cc']; ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>HS CODE</td>
                            <td><?php echo $pinv_data_arr['hs_code']; ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="border-right: 1px solid black;border-top: 1px solid black; text-align: center; padding: 8px;">TOTAL<?php echo ($vh_data['insuarance'] > 0 ? ' CIF' : ' C&F');?></td>
                            <td style="border-top: 1px solid black;text-align: right;"><?php echo number_format($vh_data['tot_amt'], 0, '.', ',') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="font-xsmall" style="border: 1px solid black; margin-top: 10px;">
                <div style="padding: 5px;">L/C SHOULD STATE</div>
                <div style="margin-top: 10px;">
                    <table style="width: 90%;">
                        <colgroup><col style="width: 35%;"><col style=""></colgroup>
                        <tr>
                            <td>PARTIAL SHIPMENT</td><td><?php echo $pinv_data_arr['partial_shipment']; ?></td>
                        </tr>
                        <tr>
                            <td>TRANSSHIPMENT</td><td><?php echo $pinv_data_arr['transshipment']; ?></td>
                        </tr>
                        <tr>
                            <td>PERIOD FOR PRESENTATION</td><td><?php echo $pinv_data_arr['presentation_period']; ?>&nbsp;DAYS</td>
                        </tr>
                        <tr>
                            <td>LAST DATE OF SHIPMENT (LATEST SHIPMENT)</td><td><?php echo $pinv_data_arr['last_shipment_date']; ?></td>
                        </tr>
                        <tr>
                            <td>LC CHARGES</td><td><?php echo $pinv_data_arr['lc_charges']; ?></td>
                        </tr>
                        <tr>
                            <td>H.S CODE</td><td><?php echo $pinv_data_arr['hs_code']; ?></td>
                        </tr>
                        <tr>
                            <td>CONFIRMATION</td><td><?php echo $pinv_data_arr['confirmation']; ?></td>
                        </tr>
                        <tr>
                            <td>ADVICE LC THROUGH (ISSUE BY)</td><td><?php echo $pinv_data_arr['lc_advice']; ?></td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 10px;">WE SEND <span style="text-decoration: underline; font-style: italic;">ONLY ONE</span> LOT OF DOCUMENT THO THE BANK BY CUURIER<br/>WE DONT ACCEPT ANY OTHER CONDITIONS.</div>
                <div style="padding-top: 10px;">
                    <table style="width: 80%;">
                        <colgroup><col style="width: 30%;"><col style="width: 70%;"></colgroup>
                        <tbody>
                            <tr><td>ADVISING BANK</td><td><?php echo $pinv_data_arr['bank_name']; ?></td></tr>
                            <tr><td>SWIFT CODE</td><td><?php echo $pinv_data_arr['swift']; ?></td></tr>
                            <tr><td>BRANCH</td><td><?php echo $pinv_data_arr['branch']; ?></td></tr>
                            <tr><td>AC NO</td><td><?php echo $pinv_data_arr['ac_num']; ?></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- load JavaScript-->
<?php require_once './include/systemFooter.php'; ?>
    </body>
    <script type="text/javascript">
//        $(function() {
//            pageProtect();
//            checkurl();
//            $('#logout').click(function() {
//                logout();
//            });
//            load_maker_table();
//            $('#maker_save_btn').click(function() {
//                maker_save();
//            });
//            $('#maker_update_btn').click(function() {
//                maker_update();
//            });
//            $('#maker_reset').click(function() {
//                reset_maker();
//            });
//        });
//        function set_focus_next(e, next_comp) {
//            e.which = e.which || e.keyCode;
//            if (e.which === 13) {
//                $(next_comp).focus();
//            }
//        }
//        $('select').chosen({width: "100%"});
    </script>
</html>

