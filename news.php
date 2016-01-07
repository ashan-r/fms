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
                            <h3>Latest News</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <input type="hidden" id="news_id">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">News Heading :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="news_head" class="form-control custom-text1" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Date* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="news_date" class="form-control custom-text1 datepicker" value="<?php echo date("Y-m-d"); ?>" onkeyup="set_focus_next(event, '#model_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Content:</label>
                                        <div class="col-lg-6">
                                            <textarea id="news_content" class="form-control" rows="6" maxlength="300" style="resize: none;"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Image:</label>
                                        <div class="col-lg-6">
                                            <input id="image_file" style="margin-bottom: 5px;" type="file"  name="file[]"/>
                                            <span><small>image resized and cropped to(w:h) 150x150</small></span>
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
                                                <button class="btn btn-custom-save" id="news_saveBtn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                            </span>
                                            <span  id="mod_update_div" class="">
                                                <button class="btn btn-custom-save hidden" id="deh_modi_updtBtn"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
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
                                        <h3 class="panel-title title-custom">News History</h3>

                                        <div class="pull-right">
                                            <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                <i class="glyphicon glyphicon-filter"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="panel-body filterTableSearch">
                                        <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".newsDetailsTable"/>
                                    </div>
                                    <div class="scrollable" style="height: 300px; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-hover datable newsDetailsTable">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>News Heading</th>
                                                    <th>Image</th>
                                                    <th>Action</th>
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

        <!-- load JavaScript-->
        <?php require_once './include/systemFooter.php'; ?>
        <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.min.js"></script>
    </body>
    <script type="text/javascript">
                                                $(function () {
                                                    pageProtect();
                                                    checkurl();
                                                    newsDetailsTable();
                                                    $('#logout').click(function () {
                                                        logout();
                                                    });

                                                    $('#news_saveBtn').click(function () {// save
//                                                        news_save();
                                                        //
                                                        var upldp = document.getElementById('image_file');
                                                        var a = $('#news_head').val();
                                                        if (a.length > 0) {
                                                            if (upldp.files.length > 0) {
                                                                var formdata;
                                                                if (window.FormData) {
                                                                    formdata = new FormData();
                                                                    formdata.append('web_news_data', 'web_news_data');
                                                                    formdata.append('news_head', $('#news_head').val());
                                                                    formdata.append('news_date', $('#news_date').val());
                                                                    formdata.append('news_content', $('#news_content').val());
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
                                                                            reset_news();
                                                                            newsDetailsTable();
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

                                                    $('#deh_modi_reset').click(function () {
                                                        reset_news();
                                                    });

                                                    $('#deh_modi_updtBtn').click(function () {
                                                       news_update($('#news_id').val());
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

