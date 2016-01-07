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
                            <h3>Vehicle Makers</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <input type="hidden" id="maker_id">

                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label required">Maker* :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="maker_name" class="form-control custom-text1" maxlength="45" required onkeyup="set_focus_next(event, '#maker_desc')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Description :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="maker_desc" class="form-control custom-text1" onkeyup="set_focus_next(event, '#company_tel1')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="maker_save_div" class="">
                                                <button class="btn btn-custom-save" id="maker_save_btn" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Add</button>
                                            </span>
                                            <span  id="maker_updateDiv" class="">
                                                <button class="btn btn-custom-save hidden" id="maker_update_btn"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                            </span>
                                            <span  id="maker_reset_div" class="">
                                                <button class="btn btn-custom-light" id="maker_reset" onkeyup=""><i class="fa fa-refresh fa-lg"></i>&nbsp;Reset</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- FORM END -->
                            </div>
                            <div class="col-md-6">
                                <div class="panel" style="">
                                    <div class="panel-heading panel-custom">
                                        <h3 class="panel-title title-custom">Makers</h3>

                                        <div class="pull-right">
                                            <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                <i class="glyphicon glyphicon-filter"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="panel-body filterTableSearch">
                                        <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".maker_info_table"/>
                                    </div>
                                    <div class="scrollable" style="height: 65vh; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-hover datable maker_info_table">
                                            <thead>
                                                <tr>
                                                    <th>Maker Name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                             
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="system_id">
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
            $('#logout').click(function () {
                logout();
            });
            load_maker_table();
            $('#maker_save_btn').click(function () {
                maker_save();
            });
            $('#maker_update_btn').click(function () {
                maker_update();
            });
            $('#maker_reset').click(function () {
                reset_maker();
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

