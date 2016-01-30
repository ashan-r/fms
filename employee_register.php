<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<!-- @Ashan Rajapaksha -->
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
                            <h3>Employee Registration</h3>
                        </div>
                        <div class="row">
                            <!-- FORM START -->
                            <div class="col-md-5">
                                <div class="form-horizontal">
                                    <input type="hidden" id="supp_id">

                                    <div class="form-group ">                                        
                                        <label class="col-lg-4 control-label custom-label">Employee ID :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="emp_id" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">EMP Code:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="empno" class="form-control" placeholder="EMP Code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">Employee Name :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="name" class="form-control" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">Designation. :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="designation" class="form-control" placeholder="General">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">NIC. :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="nic" class="form-control" placeholder="General">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_cat_name" class="col-lg-4 control-label custom-label">TEL :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="tel" class="form-control" placeholder="NIC">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Gender:</label>
                                        <div col-lg-6>
                                            <label class="radio-inline">
                                                <input type="radio" class="rbt_" id="rbt_male" name="rbt_gender" checked="checked" value="male">Male
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" class="rbt_" id="rbt_female" name="rbt_gender" value="female">Female
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">EPF No:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="epfno" class="form-control" placeholder="EPF NO">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Basic:</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="basic" class="form-control" placeholder="Basic Salary" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label custom-label">Date :</label>
                                        <div class="col-lg-6">
                                            <input type="text" id="reg_date" class="form-control custom-text1 datepicker">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-10">
                                            <span  id="save_div" class="">
                                                <button class="btn btn-custom-save" id="btn_emp_add" onkeyup=""><i class="fa fa-plus-square fa-lg"></i>&nbsp;Save Employee</button>
                                            </span>
                                            <span  id="update_div">
                                                <button class="btn btn-custom-save hidden" id="btn_update_emp"><i class="fa fa-pencil fa-sm"></i>&nbsp;Update</button>                                                
                                                <button class="btn btn-custom-light hidden" id="btn_clear_emp"><i class="fa fa-refresh fa-sm"></i>&nbsp;Clear</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FORM END -->
                            <div class="col-md-7">
                                <div class="panel" style="">
                                    <div class="panel-heading panel-custom">
                                        <h3 class="panel-title title-custom">Employee Details</h3>

                                        <div class="pull-right">
                                            <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                <i class="glyphicon glyphicon-filter"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="panel-body filterTableSearch">
                                        <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".contact_info_table"/>
                                    </div>
                                    <div class="scrollable" style="height:500px; overflow-y: auto">
                                        <table class="table table-bordered table-striped table-hover datable employee_details_tbl">
                                            <thead>
                                                <tr>
                                                    <th>EMP No</th>
                                                    <th>Employee Name</th>
                                                    <th>NIC</th>
                                                    <th>Designation.</th>
                                                    <th>Telephone</th>
                                                    <th>epfno</th>
                                                    <th>Basic</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                             
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="system_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- load JavaScript-->
        <script src="controllers/employee.js" type="text/javascript"></script>
        <?php require_once './include/systemFooter.php'; ?>
    </body>
    <script type="text/javascript">
        $(function() {
            // pageProtect();
            // checkurl();
            load_employee_tbl();
            next_ai_emp();

            $('#logout').click(function() {
                logout();
            });
            // BANK MODAL ACTIONS            
            $('#btn_emp_add').click(function() {
                //// save
                save_employee();
            });
            $('#btn_update_emp').click(function() {
                update_employee();
            });

            $('#btn_clear_emp').click(function() {
                employee_form_reset();
            });
            //

        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('select').chosen({width: "100%"});
    </script>
</html>

