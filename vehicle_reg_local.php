<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
define("VEHICLE_REG", 12452);
?>
<!DOCTYPE html>
<html>
    <!-- @SACHITH -->
    <head>  
        <!--load CSS styles-->
        <?php require_once './include/systemHeader.php'; ?>  
        <link href="css/image_upload.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="green-back">
        <div id="wrap">
            <input type="hidden" disabled="" id="v_supp_country" class="form-control custom-text1">
            <!--load navigation bar-->
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">               
                <div class="row">                                 
                    <div class="col-md-12">
                        <div class="page-header cutom-header">
                            <h3>Vehicle Registration</h3>
                        </div>
                        <div class="row">
                            <ul class="nav nav-tabs">
                                <li id="link_one" class="elementToggle active"><a href="#vh_info_tab" data-toggle="tab">Vehicle Information</a></li>
                                <li id="link_two" class="elementToggle"><a href="#vh_photo_tab" data-toggle="tab">Photo Upload</a></li>
                            </ul>
                            <!-- FORM START -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="vh_info_tab">
                                    <br/>
                                    <div class="col-md-4">
                                        <div class="form-horizontal">
                                            <input type="hidden" id="vh_reg_id" value="<?php
                                            if (isset($_REQUEST['vh_id'])) {
                                                echo $_REQUEST['vh_id'];
                                            }
                                            ?>">
                                            <input type="hidden" id="select_tab" value="<?php
                                            if (isset($_REQUEST['tab'])) {
                                                echo $_REQUEST['tab'];
                                            }
                                            ?>">
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Vehicle Code</label>
                                                <div class="col-lg-6">
                                                    <input type="text" disabled="" id="v_code_num" class="form-control custom-text1">
                                                    <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                                </div>
                                            </div>
                                            <div class="form-group ">                                        
                                                <label class="col-lg-4 control-label custom-label">Supplier * :</label>
                                                <div class="col-lg-6 v_supp_comboDiv">
                                                    <select class="v_supplier"></select>
                                                </div>
                                            </div>
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
                                                <label class="col-lg-4 control-label custom-label">Model No:</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="vh_model_num" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_milage')">
                                                </div>
                                            </div>                                            
                                            <div class="form-group ">                                        
                                                <label class="col-lg-4 control-label custom-label">Location :</label>
                                                <div class="col-lg-6 ">
                                                    <select class="location_ComboBox">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hidden">                                        
                                                <label class="col-lg-4 control-label custom-label">Currency:</label>
                                                <div class="col-lg-6 ">
                                                    <select class="cmb_currency">
                                                        <option value="LKR">LKR</option>
                                                        <option value="JPY">JPY</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Import date* :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="import_date" class="form-control custom-text1 datepicker" value="<?php echo date("Y-m-d"); ?>" onkeyup="set_focus_next(event, '#model_desc')">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Registration:</label>
                                                <div col-lg-6>
                                                    <label class="radio-inline">
                                                        <input type="radio" class="rbt_" id="rbt_unreg" name="rbt_itemType" checked="checked" value="0">Unregistered
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" class="rbt_" id="rbt_reg" name="rbt_itemType" value="1">Registered
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Purchase type:</label>
                                                <div col-lg-6>
                                                    <label class="radio-inline">
                                                        <input type="radio" class="rbt_" id="rbt_purchase" name="rbt_pType" checked="checked" value="0">Purchase
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" class="rbt_" id="rbt_exchange" name="rbt_pType" value="1">Exchange
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Engine No :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_eng_num" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_eng_cc')">                        
                                                </div>
                                            </div>
                                        </div>
                                        <br/>

                                    </div><!-- end of col-->
                                    <div class="col-md-4">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Chassis Code:</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_ch_code" style="text-transform:uppercase" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_ch_num')">
                                                    <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Chassis No:</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_ch_num" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_eng_num')">
                                                    <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Engine CC :</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" id="v_eng_cc" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_year')">                        
                                                        <span class="input-group-addon">CC</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">                                        
                                                <label class="col-lg-4 control-label custom-label">Year :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_year" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_pckg')">
                                                    <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Package :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_pckg" class="form-control custom-text1" style="text-transform:uppercase" onkeyup="set_focus_next(event, '#v_color')">
                                                    <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Colour :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_color" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_seats')">
                                                    <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Fuel:</label>
                                                <div class="col-lg-6">
                                                    <!--<input type="text" id="v_fuel" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                                    <select id="v_fuel">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Transmission:</label>
                                                <div class="col-lg-6">
                                                    <!--<input type="text" id="v_trans" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                                    <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                                    <select id="v_trans">
                                                        <!--                                                        <option value="Auto">Auto</option>
                                                                                                                <option value="Manual">Manual</option>-->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Seats :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_seats" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_doors')">                        
                                                </div>
                                            </div>
                                            <div class="form-group hidden">                                        
                                                <label class="col-lg-4 control-label custom-label">Doors :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_doors" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_eval')">
                                                    <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Drive :</label>
                                                <div class="col-lg-6">
                                                    <!--<input type="text" id="v_fuel" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">-->
                                                    <select id="v_drive">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Milage:</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" id="v_milage" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_opt')">
                                                        <span class="input-group-addon">km</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-horizontal">                                    
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Options:</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_opt" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_other')">
                                                    <!--<h6 style="color: red; font-weight: bold; margin-left: 5px;" id="branch_msg"></h6>-->
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Accessories:</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_other" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_auct')">                        
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Auction :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_auct" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_lot')">                        
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">lot No :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_lot" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_auct_grade')">                        
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Auction Grade :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_auct_grade" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_auct_price')">                        
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Auction Price :</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" id="v_auct_price" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_disp_price')">  
                                                        <span class="input-group-addon currency" id="currency1"></span>
                                                    </div>
                                                </div>
                                                <!--<span class="control-label custom-label currency" id="currency1"></span>-->
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Vehicle CIF :</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" id="v_cif" class="form-control custom-text1 vh_cost_cal" onkeyup="set_focus_next(event, '#yen_rate')">  
                                                        <span class="input-group-addon currency" id="currency1">JPY</span>
                                                    </div>
                                                </div>
                                                <!--<span class="control-label custom-label currency" id="currency1"></span>-->
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Yen Rate :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="yen_rate" class="form-control custom-text1 vh_cost_cal" onkeyup="set_focus_next(event, '#v_lkr_val')">  
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Vehicle Value :</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" id="v_lkr_val" class="form-control custom-text1 vh_cost_cal" disabled="" readonly="">  
                                                        <span class="input-group-addon" id="currency_LKR">LKR</span>
                                                    </div>
                                                </div>
                                                <!--<span class="control-label custom-label currency" id="currency1"></span>-->
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Duty :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="duty" class="form-control custom-text1 vh_cost_cal" onkeyup="set_focus_next(event, '#v_lkr_val')">  
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Clearing :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="vh_clearing" class="form-control custom-text1 vh_cost_cal" onkeyup="set_focus_next(event, '#v_lkr_val')">  
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label" id="lbl_nbt">NBT :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="nbt_rate" class="form-control custom-text1 vh_cost_cal" onkeyup="set_focus_next(event, '#v_lkr_val')">  
                                                    <input type="hidden" id="nbt_rate_curr" class="form-control custom-text1 vh_cost_cal" onkeyup="set_focus_next(event, '#v_lkr_val')">  
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label custom-label">Vehicle Cost :</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" id="v_cost" class="form-control custom-text1" onkeyup="set_focus_next(event, '#')">  
                                                        <span class="input-group-addon" id="currency_LKR">LKR</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Auc.Display Price :</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" id="v_disp_price" class="form-control custom-text1" onkeyup="set_focus_next(event, '#v_bid')">                        
                                                        <span class="input-group-addon currency" id="currency2"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label class="col-lg-4 control-label custom-label">Bidded Date :</label>
                                                <div class="col-lg-6">
                                                    <input type="text" id="v_bid" class="form-control custom-text1 datepicker" onkeyup="set_focus_next(event, '#model_save_btn')">                        
                                                </div>
                                            </div>
                                            <div class="form-group hidden">                                        
                                                <label class="col-lg-4 control-label custom-label">Coordinator :</label>
                                                <div class="col-lg-6 ">
                                                    <select class="coordinator_ComboBox"></select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <span  id="co_save_div" class="">
                                                        <button class="btn btn-custom-save" id="v_save_btn" data-toggle="modal" data-target="#vh_confirm"><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                                    </span>
                                                    <span  id="co_updateDiv" class="">
                                                        <button class="btn btn-custom-save hidden" id="v_update_btn"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                                    </span>
                                                    <span  id="co_reset_div" class="">
                                                        <button class="btn btn-custom-light" id="v_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div  class="tab-pane" id="vh_photo_tab">
                                    <div class="container-fluid" style="">
                                        <!--<form>-->
                                        <div class="row">
                                            <br/>
                                            <div class="col-md-5">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <div class="col-md-4">
                                                            <label class="control-label custom-label">Select Recent Vehicle: </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select id="vehi_id" class="vahicle_code_combo"></select>
                                                        </div>
                                                        <!--<a class="btn btn-custom-light" id="btn_vh_search" data-toggle="modal" data-target="#vh_searchModal"><i class="fa fa-search fa-sm"></i>&nbsp;</a>-->
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-offset-4 col-md-6">
                                                            <input type="text" id="vh_info" class="form-control custom-text1" readonly="" onkeyup="">                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-offset-4 col-md-6">
                                                            <button type="button" id="load_images" class="btn btn-custom-save" style="margin-top: 5px;"><i class="fa fa-picture-o"></i> Load Uploaded Images</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">

                                                <div class="form-horizontal" id="uploaderform">
                                                    <form action="views/upload_image.php" method="post" enctype="multipart/form-data" name="UploadForm" id="UploadForm">
                                                        <h1>Select Images of the vehicle</h1>
                                                        <div id="AddFileInputBox"><input id="fileInputBox" style="margin-bottom: 5px;" type="file"  multiple="multiple" name="file[]"/></div>
                                                        <!--<div class="sep_s"></div>-->

                                                        <div><input name="vh_id" type="hidden" id="vh_id" value="<?php
                                                            if (isset($_GET['vh_id'])) {
                                                                echo $_GET['vh_id'];
                                                            }
                                                            ?>" />
                                                        </div>

                                                        <button type="submit" class="btn btn-custom-save" id="SubmitButton"><i class="fa fa-picture-o"></i> &nbsp;Upload</button>
                                                        <a href="vehicle_reg.php" class="btn btn-custom-light" id="vh_back">Back</a>
                                                        <div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div ></div>
                                                    </form>
                                                    <div action="" method="post" enctype="multipart/form-data" name="pdf_uploadForm" id="pdf_uploadForm">
                                                        <h1>Select PDF file of the vehicle</h1>
                                                        <div id="AddFileInputBox"><input id="pdf_file" style="margin-bottom: 5px;" type="file"  name="file[]"/></div>
                                                        <!--<div class="sep_s"></div>-->
                                                        <!--                               
<!--                                                        <div><input name="vh_id" type="hidden" id="vh_id" value="<?php
                                                        if (isset($_GET['vh_id'])) {
                                                            echo $_GET['vh_id'];
                                                        }
                                                        ?>" />
                                                        </div>-->

                                                        <button class="btn btn-custom-save" id="btn_pdf_upload"><i class="fa fa-file-text-o"></i>&nbsp;Upload</button>
                                                        <a href="vehicle_reg.php" class="btn btn-custom-light" id="vh_back">Back</a>
                                                        <div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div ></div>
                                                    </div>
                                                </div>
                                                <div id="uploadResults">
                                                    <!--<div align="center" style="margin:20px;"><a href="#" id="ShowForm">Toggle Form</a></div>-->
                                                    <div id="output"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--</form>-->
                                    </div>
                                    <div class="row" style="margin:0px;">
                                        <div class="col-md-12">
                                            <div id="img_count_div" style="padding: 10px 5px 10px 10px; font-weight: bold;">Total Images available</div>
                                        </div>
                                    </div>
                                    <div id="vehicle_img_container" class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12">
                                                <div id="image_galary"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--<button class="btn btn-sm btn-danger pull-right img_dlt_btn" type="button" value=""><i class="fa fa-trash-o"></i></button>-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vehicle Confirm Modal -->
        <div class="modal fade" id="vh_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Image Upload</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    Upload Images for this car?
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-save" id="vh_save_upload_btn" onvh_save_btnkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Upload</button>
                        <button type="button" class="btn btn-custom-light" id="vh_save_only_btn" data-dismiss="modal">Skip</button>
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

        <script type="text/javascript">
            $(function () {
                pageProtect();
                checkurl();
                $('#logout').click(function () {
                    logout();
                });
                var vh_id = $('#vh_reg_id').val();
                var tab = $('#select_tab').val();
                load_syscode_values('35', '.location_ComboBox');
                if (parseInt(vh_id) > 0) {
                    load_vh_info_local(vh_id, function () {
                        $('#vehi_id').html('').append('<option value="' + vh_id + '">SELCTED VEHICLE</option>');
                        load_basic_vh_info($('#vh_reg_id').val());
                        load_image_count($('#vh_reg_id').val());
                        $('.v_supplier').prop('disabled', true).trigger("chosen:updated");
                    });
                    if (parseInt(tab) === 2) {
                        showTabTwo();
                    }
                } else {
                    load_makers_cmb(false, function () {
                        load_model_cmb($('.maker_ComboBox').val());
                    });
                    vehicle_code_latest(false, function () {
                        load_image_count($('#vehi_id').val());
                        load_basic_vh_info($('#vehi_id').val());
                    });
                    $('.v_supplier').prop('disabled', false).trigger("chosen:updated");
                    load_suppliers_cmb(false, function () {
                        load_supp_currency_local($('.v_supplier').val());
                    });
                }
                select_syscode_local(5, function (obj) {
//                    console.log(obj);
                    $('#lbl_nbt').html('NBT (' + obj.description + '%):');
                    $('#nbt_rate_curr').val(obj.description);
                });
//                load_coordinator_jp_cmb();
                load_coordinator_cmb();
                load_fuel_types();
                load_drive_types();
                load_transmission_types();


                // IMAGE UPLOAD PLUGIN- CODE START
                //elements
                var progressbox = $('#progressbox'); //progress bar wrapper
                var progressbar = $('#progressbar'); //progress bar element
                var statustxt = $('#statustxt'); //status text element
                var submitbutton = $("#SubmitButton"); //submit button
                var myform = $("#UploadForm"); //upload form
                var output = $("#output"); //ajax result output element
                var completed = '0%'; //initial progressbar value
                var FileInputsHolder = $('#AddFileInputBox'); //Element where additional file inputs are appended
                var MaxFileInputs = 3; //Maximum number of file input boxs
                //
                // adding and removing file input box
                var i = $("#AddFileInputBox div").size() + 1;
                $("#AddMoreFileBox").click(function () {
                    event.returnValue = false;
                    if (i < MaxFileInputs)
                    {
                        $('<span><input type="file" id="fileInputBox" size="20" name="file[]" class="addedInput" value=""/><a href="#" class="removeclass small2"><img src="images/close_icon.gif" border="0" /></a></span>').appendTo(FileInputsHolder);
                        i++;
                    }
                    return false;
                });

                $("body").on("click", ".removeclass", function (e) {
                    event.returnValue = false;
                    if (i > 1) {
                        $(this).parents('span').remove();
                        i--;
                    }

                });

                $("#ShowForm").click(function () {
                    $("#uploaderform").slideToggle(); //Slide Toggle upload form on click
                });

                $(myform).ajaxForm({
                    beforeSend: function () { //brfore sending form
                        submitbutton.attr('disabled', ''); // disable upload button
                        statustxt.empty();
                        progressbox.show(); //show progressbar
                        progressbar.width(completed); //initial value 0% of progressbar
                        statustxt.html(completed); //set status text
                        statustxt.css('color', '#000'); //initial color of status text

                    },
                    uploadProgress: function (event, position, total, percentComplete) { //on progress
                        progressbar.width(percentComplete + '%'); //update progressbar percent complete
                        statustxt.html(percentComplete + '%'); //update status text
                        if (percentComplete > 50)
                        {
                            statustxt.css('color', '#fff'); //change status text to white after 50%
                        } else {
                            statustxt.css('color', '#000');
                        }

                    },
                    complete: function (response) { // on complete
//                                                                    output.html(response.responseText); //update element with received data
                        myform.resetForm();  // reset form
                        submitbutton.removeAttr('disabled'); //enable submit button
                        progressbox.hide(); // hide progressbar
//                        $("#uploaderform").slideUp(); // hide form after upload
                        veh_imageload_galary($('#vehi_id').val());
                        load_image_count($('#vehi_id').val());
                    }
                });
                // IMAGE UPLOAD PLUGIN- CODE END
                $('.maker_ComboBox').change(function () {
                    load_model_cmb($('.maker_ComboBox').val());
                });
                $('.v_supplier').change(function () {
                    load_supp_currency_local($(this).val());
                });
                $('.location_ComboBox').change(function () {
                    $('.cmb_currency').val($('.location_ComboBox').val());
//                    $('.currency').html($('.location_ComboBox').val());
                    chosenRefresh();
                });
                $('.cmb_currency').change(function () {
//                    $('.currency').html($('.cmb_currency').val());
                });
                $('#vehi_id').change(function () {
                    load_image_count($('#vehi_id').val());
                    load_basic_vh_info($('#vehi_id').val());
                });
                $('#vh_save_only_btn').click(function () {
                    vehicle_add_local(0);
                });
                $('#vh_save_upload_btn').click(function () {
                    vehicle_add_local(1);
                });




                $('#v_update_btn').click(function () {
                    vehicle_update_local();
                });
                $('#v_reset').click(function () {
                    reset_vehicleReg();
                });

                $('#browse_file_img').click(function () {
                    $('#upld_picture').click();
                });

                /**  image load by vehicle  **/
                $('#load_images').click(function () {
                    veh_imageload_galary($('#vehi_id').val());
                });
                /** clear images to combo change**/
                $('#vehi_id').change(function () {
                    $('#image_galary').html('')
                });
                //**  delete image from galary **/
                $('body').on('click', '.img_dlt_btn', function () {
                    var del_value = parseInt($(this).data('ph_id'));
                    var vh_value = parseInt($(this).data('vh_id'));
                    delete_imageFrom_galary(del_value, vh_value);
                });
                //**  delete image from galary **/
                $('body').on('click', '.imgCheck', function () {
                    var image_id = parseInt($(this).val());
                    var vi_status = 0;
                    if ($(this).is(':checked')) {
                        vi_status = 1;
                    }
                    image_vicible_statusChange(image_id, vi_status);
                });

                $('#upld_picture').change(function () {
                    $('#fake_file_name').html($(this).val());
                });

                $('#btn_pdf_upload').click(function (e) {
                    var upldp = document.getElementById('pdf_file');
                    if (upldp.files.length > 0) {
                        var formdata;
                        if (window.FormData) {
                            formdata = new FormData();
                            formdata.append('file_upload', 'file_upload');
                            formdata.append('vh_id', $('#vehi_id').val());
                            formdata.append('file', upldp.files[0]);
                            $.ajax({
                                url: "views/file_upload.php",
                                type: "POST",
                                data: formdata,
                                processData: false,
                                contentType: false,
                                success: function (res) {
//                                    var pp = JSON.parse(res);
                                    var stat = parseInt(res);
                                    if (stat === 100) {
                                        alertify.success('PDF file uploaded', 2000);
                                    } else if (stat === 1) {
                                        alertify.error('File too large', 2000);
                                    } else if (stat === 800) {
                                        alertify.error('Invalid file type', 2000);
                                    } else if (stat === 900) {
                                        alertify.error('File Save Error', 2000);
                                    } else {
                                        alertify.error('File upload error', 2000);
                                    }
                                    $('#pdf_file').val('');
//                                    $('#fake_file_name').html('');
//                                    var pp = document.getElementById("preview_img");
//                                    pp.src = '';
//                                    pp.style.display = 'none';
                                }
                            });
                        }
                    } else {
                        alertify.error('Please select a file.', 2000);
                    }
                });

                var msnry = $('#vehicle_img_container').masonry({
                    itemSelector: '.item'
                }).masonry();


            });

            function set_focus_next(e, next_comp) {
                e.which = e.which || e.keyCode;
                if (e.which === 13) {
                    $(next_comp).focus();
                }
            }
            function showTabTwo(callback) {
                $('#link_one').removeClass('active');
                $('#link_two').addClass('active');
                $('#vh_info_tab').removeClass('active');
                $('#vh_photo_tab').addClass('active');
                if (typeof callback === 'function') {
                    callback();
                }
            }

            $('.vh_cost_cal').keyup(function () {
                vh_cost_calculation();
            });
            function vh_cost_calculation() {
                var v_cif = parseFloat($('#v_cif').val());
                var yen_rate = parseFloat($('#yen_rate').val());
                var v_lkr_val = parseFloat($('#v_lkr_val').val());
                var duty = parseFloat($('#duty').val());
                var vh_clearing = parseFloat($('#vh_clearing').val());
                var v_cost = 0;

                if (isNaN(v_cif)) {
                    v_cif = 0;
                }
                if (isNaN(yen_rate)) {
                    yen_rate = 1;
                }
                if (isNaN(duty)) {
                    duty = 0;
                }
                if (isNaN(vh_clearing)) {
                    vh_clearing = 0;
                }
                if (isNaN(nbt_rate)) {
                    nbt_rate = 0;
                }
                if (isNaN(v_cost)) {
                    v_cost = 0;
                }

                v_lkr_val = v_cif * yen_rate;
                if (isNaN(v_lkr_val)) {
                    v_lkr_val = 0;
                }
                var lkr_duty=v_lkr_val+duty;
                var aa = (lkr_duty * parseFloat($('#nbt_rate_curr').val())) / 100;
                $('#nbt_rate').val(aa.toFixed(2));
                var nbt_rate = parseFloat($('#nbt_rate').val());

                $('#v_lkr_val').val(v_lkr_val.toFixed(2));
                v_cost = v_lkr_val + duty + vh_clearing + nbt_rate;
//                console.log(v_cost);
                $('#v_cost').val(v_cost.toFixed(2));
            }
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
            $('select').chosen({
                disable_search_threshold: 5,
                width: "100%"});
        </script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
    </body>

</html>

