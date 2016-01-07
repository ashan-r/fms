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
                            <h3>Web Home Page Content</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <input type="hidden" id="wh_id">
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Section :</label>
                                        <div class="col-lg-6">
                                            <select class="page_section">
                                                <option value="banner">Banner</option>
                                                <option value="mid">Mid Section</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Order :</label>
                                        <div class="col-lg-6 ">
                                            <select class="content_order">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label required">Heading 1:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="heading_1" class="form-control custom-text1" maxlength="45" required onkeyup="set_focus_next(event, '#maker_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label required">Heading 2:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="heading_2" class="form-control custom-text1" maxlength="45" required onkeyup="set_focus_next(event, '#maker_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Description:</label>
                                        <div class="col-lg-6">
                                            <textarea id="description" class="form-control" rows="6" maxlength="350" style="resize: none;"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Image:</label>
                                        <div class="col-lg-6">
                                            <input id="image_file" style="margin-bottom: 5px;" type="file"  name="file[]"/>
                                            <span><small>Banner Image 1350x445 :: Mid image 370x200</small></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="maker_save_div" class="">
                                                <button class="btn btn-custom-save" id="content_save_btn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                            </span>
                                            <span  id="maker_updateDiv" class="">
                                                <button class="btn btn-custom-save hidden" id="content_update_btn"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                            </span>
                                            <span  id="maker_reset_div" class="">
                                                <button class="btn btn-custom-light" id="content_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- FORM END -->
                            </div>
                            <div class="col-md-6">
                                <div class="panel" style="">
                                    <div class="panel-heading panel-custom">
                                        <h3 class="panel-title title-custom">Home Page Content</h3>

                                    </div>
                                    <div class="panel-body filterTableSearch">
                                        <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".web_homepg_content"/>
                                    </div>
                                    <div class="scrollable" style="height: 300px; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-hover web_homepg_content">
                                            <thead>
                                                <tr>
                                                    <th>Heading 1</th>
                                                    <th>image</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- end of col-->
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
//            chosenRefresh();
            $('#logout').click(function () {
                logout();
            });
            load_web_homepg_data($('.page_section').val());
            $('.page_section').change(function () {
                load_web_homepg_data($('.page_section').val());
            });
            $('#content_update_btn').click(function () {
                homepg_content_update();
            });
            $('#content_reset').click(function () {
                web_homepg_reset();
            });
            $('#content_save_btn').click(function (e) {
                var upldp = document.getElementById('image_file');
                var a=$('.page_section').val();
                if (a.length > 0) {
                    if (upldp.files.length > 0) {
                        var formdata;
                        if (window.FormData) {
                            formdata = new FormData();
                            formdata.append('web_home_data', 'web_home_data');
                            formdata.append('section', $('.page_section').val());
                            formdata.append('heading_1', $('#heading_1').val());
                            formdata.append('heading_2', $('#heading_2').val());
                            formdata.append('content_order', $('.content_order').val());
                            formdata.append('description', $('#description').val());
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
                                        alertify.success('Information Saved', 2000);
                                    } else if (stat === 1) {
                                        alertify.error('File too large', 2000);
                                    } else if (stat === 800) {
                                        alertify.error('Invalid file type', 2000);
                                    } else if (stat === 900) {
                                        alertify.error('File Save Error', 2000);
                                    } else {
                                        alertify.error('File upload error', 2000);
                                    }
                                    web_homepg_reset();
                                    load_web_homepg_data($('.page_section').val());
                                }
                            });
                        }
                    } else {
                        alertify.error('Please select a file.', 2000);
                    }
                } else {
                    alertify.error('Selet a section.', 2000);
                }

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

