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
        <link type="text/css" href="css/lightslider.css" rel="stylesheet" >
        <style type="text/css" rel="stylesheet">
            .demo {
                width:620px;
            }
            ul {
                list-style: none outside none;
                padding-left: 0;
                margin-bottom:0;
            }
            li {
                display: block;
                float: left;
                margin-right: 6px;
                cursor:pointer;
                /*height: 40px;*/
            }
            img {
                display: block;
                height: auto;
                max-width: 100%;
            }
            .detail_tbl tr{
                /*height: 25px;*/
                border: 1px solid #B2B3B2;
            }
            .detail_tbl td{
                text-align: right;
                padding: 3px;
            }

            .detail_tbl th{
                text-align: left;
                padding: 3px;
            }

            .detail_tbl{
                font-size: 15px;
                width: 80%;
            }
        </style>
    </head>
    <body class="green-back">
        <div id="wrap">
            <!--load navigation bar-->
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">               
                <?php
                if (isset($_POST['veh_id'])) {
                    $veh_id = $_POST['veh_id'];
                } else {
                    header('Location: view_vehicle_list.php');
                }
//                $veh_id = 18;
                MainConfig::connectDB();
                // wehicle details
                $weh_data = mysql_query("SELECT
                maker.maker_name,
                maker_model.mod_name,
                CONCAT(vehicle.vh_chassis_code,'-',vehicle.vh_chassis_num) AS vh_chassis,
                CONCAT(vehicle.engine_code,'-',vehicle.engine_num) AS vh_engine,
                vehicle.engine_cc,
                vehicle.package,
                vehicle.vh_year,
                vehicle.vh_color,
                vehicle.vh_milage,
                vehicle.vh_options,
                vehicle.fuel_type,
                vehicle.transmission,
                vehicle.seats,
                vehicle.doors,
                vehicle.drive_wheels,
                vehicle.color_group,
                vehicle.additional_options,
                vehicle.lot_no,
                IF(vehicle.auc_display_price>0,vehicle.auc_display_price,vehicle.auc_real_price) AS v_price,
                vehicle.pdf_file,
                vehicle.vh_code,
                vehicle.currency_type,
                vehicle.stock_status,
                vehicle.auction_name,
                vehicle.auction_grade,
                vehicle.bid_date,
                coordinator.short_name
                FROM
                vehicle
                INNER JOIN maker_model ON vehicle.vh_maker_model = maker_model.mod_id
                INNER JOIN maker ON maker_model.maker_id = maker.maker_id
                LEFT JOIN coordinator ON coordinator.coordinator_id = vehicle.coordinator_id
                WHERE
                vehicle.vh_id = '{$veh_id}'");
                if (!empty($weh_data)) {
                    while ($row = mysql_fetch_array($weh_data)) {
                        $maker_name = $row['maker_name'];
                        $mod_name = $row['mod_name'];
                        $vh_year = $row['vh_year'];
                        $vh_color = $row['vh_color'];
                        $package = $row['package'];
                        $vh_milage = $row['vh_milage'];
                        $vh_chassis_num = $row['vh_chassis'];
                        $vh_engine = $row['vh_engine'];
                        $engine_cc = $row['engine_cc'];
                        $lot_no = $row['lot_no'];
                        $fuel_type = $row['fuel_type'];
                        $transmission = $row['transmission'];
                        $seats = $row['seats'];
                        $doors = $row['doors'];
                        $auction_grade = $row['auction_grade'];
                        $drive_wheels = $row['drive_wheels'];
//                        $vh_chassis_code = $row['vh_chassis_code'];//
                        $vh_options = $row['vh_options'];
                        $additional_options = $row['additional_options'];
                        $color_group = $row['color_group'];
                        $v_price = $row['v_price'];
                        $pdf_file = $row['pdf_file'];
                        $auction_name = $row['auction_name'];
                        $vh_code = $row['vh_code'];
                        $currency_type = $row['currency_type'];
                        $stock_status = $row['stock_status'];
                        $bid_date = $row['bid_date'];
                        $short_name = $row['short_name'];
                    }
                }

                $img_data = array();
                $sel = mysql_query("SELECT
                vehicle_photo.file_1,
                vehicle_photo.file_2,
                vehicle_photo.file_3,
                vehicle.vh_code
                FROM
                vehicle
                INNER JOIN vehicle_photo ON vehicle_photo.vh_id = vehicle.vh_id
                WHERE
                vehicle.vh_id = '{$veh_id}' AND vehicle_photo.p_visible = '1'") or die(mysql_error());
                if ($sel) {
                    while ($row = mysql_fetch_array($sel)) {
                        $img_data[] = $row;
                    }
                }
                ?>
                <div class="row">                                 
                    <div class="col-md-12">
                        <div class="page-header cutom-header">
                            <h3><?php
                                $ccstr = ($engine_cc > 0) ? " - {$engine_cc}cc" : '';
                                echo $maker_name . ' ' . $mod_name . ' ' . $package . ($ccstr);
                                ?></h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-7" style="">
                                <div>
                                    <?php
                                    if (!empty($sel)) {
                                        while ($row = mysql_fetch_array($sel)) {
                                            $img_data[] = $row;
                                        }
//                                        print_r($_POST);
                                        if (!empty($img_data)) {
                                            ?>
                                            <div class="demo" style="padding: 35px 0 0 35px;">
                                                <ul id="lightSlider">
                                                    <?php
                                                    foreach ($img_data as $img) {
                                                        $img_dir = $img['vh_code'] . '_' . $veh_id;
                                                        echo '<li data-thumb="vehicle_img/' . $img_dir . '/' . $img['file_3'] . '">
                                                <img src="vehicle_img/' . $img_dir . '/' . $img['file_2'] . '" />
                                            </li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <?php
                                        } else {
                                            ?>

                                            <div style="padding: 40px 0 0 110px;"><img src="images/no_image_available.jpg"></div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-5" style="">
                                <div>
                                    <table class="detail_tbl" border="1">
                                        <tbody>
                                            <tr>
                                                <td colspan="2"><h3 class=""><strong><?php echo number_format($v_price, 2);
                                    echo isset($currency_type) ? ' ' . $currency_type : ''; ?></strong></h3></td>
                                            </tr>
                                            <tr>
                                                <th>REFERENCE:</th>
                                                <td><?php echo isset($vh_code) ? $vh_code : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>STATUS:</th>
                                                <td <?php
                                                    if (isset($stock_status)) {
                                                        switch ($stock_status) {
                                                            case 1:
                                                                echo 'style="color: red;font-weight: bold;">In Stock';
                                                                break;
                                                            case 2:
                                                                echo 'style="color: red;font-weight: bold;">Ordered';
                                                                break;
                                                            case 3:
                                                                echo 'style="color: green;font-weight: bold;">Clearing';
                                                                break;
                                                            case 4:
                                                                echo 'style="color: skyblue;font-weight: bold;">Cleared';
                                                                break;

                                                            default:
                                                                echo 'style="color: black;font-weight: bold;">-';
                                                                break;
                                                        }
                                                    }
                                                    ?></td>
                                            </tr>
                                            <tr>
                                                <th>MAKER:</th>
                                                <td><?php echo isset($maker_name) ? $maker_name : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>MODEL:</th>
                                                <td><?php echo isset($mod_name) ? $mod_name : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>YEAR:</th>
                                                <td><?php echo isset($vh_year) ? $vh_year : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>GRADE:</th>
                                                <td><?php echo isset($package) ? $package : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>COLOR:</th>
                                                <td><?php echo isset($vh_color) ? $vh_color : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>MILEAGE:</th>
                                                <td><?php echo isset($vh_milage) ? $vh_milage : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>CHASSIS NUMBER:</th>
                                                <td><?php echo isset($vh_chassis_num) ? $vh_chassis_num : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>ENGINE NUMBER:</th>
                                                <td><?php echo isset($vh_engine) ? $vh_engine : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>ENGINE CAPACITY:</th>
                                                <td><?php echo isset($engine_cc) ? $engine_cc : ''; ?> cc</td>
                                            </tr>
                                            <tr>
                                                <th>FUEL:</th>
                                                <td><?php echo isset($fuel_type) ? $fuel_type : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>TRANSMISSION:</th>
                                                <td><?php echo isset($transmission) ? $transmission : ''; ?></td>
                                            </tr>
<!--                                            <tr>
                                                <th>SEATS:</th>
                                                <td><?php echo isset($seats) ? $seats : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>DOORS:</th>
                                                <td><?php echo isset($doors) ? $doors : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>2WD/4WD:</th>
                                                <td><?php echo isset($drive_wheels) ? $drive_wheels : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>OPTIONS:</th>
                                                <td><?php echo isset($vh_options) ? $vh_options : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>ACCESSORIES:</th>
                                                <td><?php echo isset($additional_options) ? $additional_options : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>AUCTION:</th>
                                                <td><?php echo isset($auction_name) ? $auction_name : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>STOCK NUMBER:</th>
                                                <td><?php echo isset($lot_no) ? $lot_no : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>AUCTION GRADE:</th>
                                                <td><?php echo isset($auction_grade) ? $auction_grade : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>BIDDED DATE:</th>
                                                <td><?php echo isset($bid_date) ? $bid_date : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>COORDINATOR:</th>
                                                <td><?php echo isset($short_name) ? $short_name : ''; ?></td>
                                            </tr>-->
                                            <tr>
                                                <th>File:</th>
                                                <td><?php echo isset($pdf_file) ? '<a href="vehicle_img/' . $vh_code . '_' . $veh_id . '/' . $pdf_file . '">Download PDF<a>' : ''; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- end of col-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- load JavaScript-->
<?php require_once './include/systemFooter.php'; ?>
        <script type="text/javascript" src="js/lightslider.min.js"></script>
    </body>
    <script type="text/javascript">
        $(function () {

            $('#lightSlider').lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                slideMargin: 0,
                thumbItem: 9
            });

            pageProtect();
            checkurl();
            $('#logout').click(function () {
                logout();
            });

        });
        $('select').chosen({width: "100%"});
    </script>
</html>

