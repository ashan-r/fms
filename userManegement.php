<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<!--@AMILA-->
<html>
    <style>
        .datepicker { z-index: 1151  !important;  }
    </style>
    <head>        
        <?php require_once './include/systemHeader.php'; ?>        
    </head>
    <body class="green-back">
        <div id="wrap">
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">    
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header cutom-header">
                            <h3>System User Manage</h3>
                        </div>                        
                    </div>
                </div>
                <div class="row">
<!--                    <a class="" data-toggle="modal" data-target=".addUserLevel">
                        <div class="col-md-4">
                            <div class="thumbnail btn-dashboard" style="border-radius:5px; padding: 10px;">
                                <img src="img/dashbord/systemSettings.png">
                                <div class="caption text-center">
                                    <h3>Add User Level</h3>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </a> -->

                    <a class="" data-toggle="modal" data-target=".addNewUser">
                        <div class="col-md-4">
                            <div class="thumbnail btn-dashboard" style="border-radius:5px; padding: 10px;">
                                <img src="img/dashbord/systemSettings.png">
                                <div class="caption text-center">
                                    <h3>Add New User</h3>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </a> 

                    <a class="hidden" data-toggle="modal" data-target=".addUserLevelPrivillages">
                        <div class="col-md-3">
                            <div class="thumbnail btn-dashboard" style="border-radius:5px; padding: 10px;">
                                <img src="img/dashbord/systemSettings.png">
                                <div class="caption text-center">
                                    <h3>Set User Level Privileges</h3>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </a> 
                    <a class="" data-toggle="modal" data-target=".addUserPrivillages">
                        <div class="col-md-4">
                            <div class="thumbnail btn-dashboard" style="border-radius:5px; padding: 10px;">
                                <img src="img/dashbord/systemSettings.png">
                                <div class="caption text-center">
                                    <h3>Set User Privileges</h3>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </a> 


                    <!--User Level Add-->
                    <div class="modal fade addUserLevel" style="width: 100%;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="padding:10px;border-radius:5px; background-color: #AACAB4;">
                                <h4 style=""><b>Add User Level</b></h4>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <div class="form-horizontal">                                          

                                            <div class="form-group">
                                                <label for="programe_symble" class="control-label">User level :</label>
                                                <div class="">
                                                    <input type="text" class="form-control custom-text1" id="userLevel" placeholder="">
                                                    <input type="hidden" class="form-control" id="hiddnField" placeholder="">
                                                </div>
                                            </div> 

                                            <div class="form-group">
                                                <!--<label for="programe_symble" class="col-lg-4 control-label">&nbsp;</label>-->
                                                <div class="col-lg-6" id="savesection">
                                                    <button type="button" class="btn btn-custom-save col-lg-6" id="userLvelAdd">Save</button>&nbsp;
                                                    <button type="button" class="btn btn-info " id="userLvelCancel" data-dismiss="modal">Cancel</button>
                                                </div>
                                                <div class="col-lg-6 hidden" id="updateSection">
                                                    <button type="button" class="btn btn-success col-lg-6 pull-right" id="UpdateUlevel">Update</button>&nbsp;
                                                    <button type="button" class="btn btn-info pull-right" id="reset">Reset</button>&nbsp;
                                                </div>
                                            </div> 
                                        </div>

                                    </div>        
                                    <div class="col-lg-3"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10" style="">
                                        <div class="panel">
                                            <div class="panel-heading panel-custom">
                                                <h3 class="panel-title title-custom">Current User Levels</h3>
                                                <div class="pull-right">
                                                    <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                        <i class="glyphicon glyphicon-filter"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="panel-body filterTableSearch">
                                                <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".userLevelTble"/>
                                            </div>
                                            <div class="scrollable" style="height: 300px; overflow-y: auto">
                                                <table class="table table-bordered table-striped table-hover datable userLevelTble">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User Level</th>
                                                            <th>Sequence NO.</th>
                                                            <th>Edit / Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                             
                                                    </tbody>
                                                </table>
                                                <input type="hidden" id="chkString">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1"></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!--User Level End-->

                    <!--Add System user-->
                    <div class="modal fade addNewUser" style="width: 100%;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="padding:10px;border-radius:5px; background-color: #AACAB4;">
                                <div class="row">
                                    <h4 style="padding-left: 35px; padding-top: 15px;"><b>Add New User</b></h4>
                                    
                                    <div class="row"><div style="height: 25px;"></div></div>
                                    <div class="col-lg-6">
                                        <div class="form-horizontal">                            
                                            <div class="form-group hidden">
                                                <label for="branch" class="col-md-4 control-label">Select Branch:</label>
                                                <div class="col-md-7 branchcomboDiv">
                                                    <select class="branchComboBox" id="branchComboBox"></select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">Username :</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control" id="username" placeholder="Username" style="background-color: #e1edf7;">
                                                    <h5 id="unameMsg" style="color: red;"></h5>
                                                </div>
                                            </div> 

                                            <input type="hidden" id="hiddenUserId" value="">

                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">Password :</label>
                                                <div class="col-lg-7">
                                                    <input type="password" class="form-control" id="password" placeholder="Password" style="background-color: #fdf1ef;">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">Confirm Password :</label>
                                                <div class="col-lg-7">
                                                    <input type="password" class="form-control" id="conPassword" placeholder="Confirm Password" style="background-color: #fdf1ef;">
                                                    <h5 id="passMasseg" style="color: red;"></h5>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">User Level :</label>
                                                <div class="col-lg-7">
                                                    <select class="selUserLevel" id="selUserLevel"></select>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">Date :</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control datepicker" id="date" placeholder="Date" value="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" >                                           
                                          <!--                                                    <input type="text" class="form-control" id="date" placeholder="Date" value="<?php //echo date('Y-m-d');                          ?>" >-->
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">Employee NO. :</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control" id="empNo" placeholder="Employee NO">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">NIC :</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control col-lg-6" id="nic" placeholder="NIC" maxlength="10">
                                                    <h6 id="nic_val" style="color: red;"> </h6>
                                                    <h6 id="nic_valok" style="color: green;"> </h6>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-horizontal">             
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">First Name :</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control" id="fName" placeholder="First Name">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">Last Name :</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control" id="lName" placeholder="Last Name">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">Address :</label>
                                                <div class="col-lg-7">
                                                    <textarea class="form-control" id="address" placeholder="Address" style="resize: none;"></textarea>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">Tel NO. :</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control" id="mobile" placeholder="Mobile" style="background-color: #dff0d8" maxlength="10" onkeypress="return isNumberKey(event)">
                                                    <h6 id="mobi" style="color: red;"></h6>
                                                    <h6 id="mobiok" style="color: green;"></h6>
                                                    <input type="text" class="form-control" id="work" placeholder="Work" style="background-color: #a6e1ec" maxlength="10" onkeypress="return isNumberKey(event)">
                                                    <h6 id="works" style="color: red;"></h6>
                                                    <h6 id="worksok" style="color: green;"></h6>
                                                    <input type="text" class="form-control" id="home" placeholder="Home" style="background-color: #f5e79e" maxlength="10" onkeypress="return isNumberKey(event)">
                                                    <h6 id="homes" style="color: red;"></h6>
                                                    <h6 id="homesok" style="color: green;"></h6>
                                                </div>
                                            </div> 
                                            <div class="form-group emailvalue">
                                                <label for="programe_symble" class="col-lg-4 control-label">Email :</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control" id="eMail" placeholder="Email">
                                                    <h6 style="color: red; font-weight: bold; margin-left: 5px;" id="em_val"></h6>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">User Status :</label>
                                                <div class="col-lg-7">
                                                    <select class="form-control" id="userStatus" placeholder="">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                        <option value="99">Invisible</option>
                                                    </select>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">&nbsp;</label>
                                                <div class="col-lg-7" style="" id="useerAdsavesection">
                                                    <button type="button" class="btn btn-primary pull-right col-md-6" id="systemUserAdd">Save</button>&nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="btn btn-info pull-right" id="cancel" data-dismiss="modal">Cancel</button>
                                                </div>
                                                <div class="col-lg-6 hidden" id="userAdupdateSection">
                                                    <button type="button" class="btn btn-success col-lg-6 pull-right" id="UpdateSystemuser">Update</button>&nbsp;
                                                    <button type="button" class="btn btn-info pull-right" id="sysUserreset">Reset</button>&nbsp;
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 0px;">
                                    <div class="col-lg-12" style="padding-left: 15px;">
                                        <div class="panel">
                                            <div class="panel-heading  panel-custom">
                                                <h3 class="panel-title title-custom">Current Users</h3>
                                                <div class="pull-right">
                                                    <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                        <i class="glyphicon glyphicon-filter"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="panel-body filterTableSearch">
                                                <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".adminUsersTbl"/>
                                            </div>
                                            <div class="scrollable" style="height: 150px; overflow-y: auto">
                                                <table class="table table-bordered table-striped table-hover datable adminUsersTbl">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Username</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>User level</th>
                                                            <th>Edit Or Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                             
                                                    </tbody>
                                                </table>
                                                <input type="hidden" id="chkString">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End System user-->


                    <div class="modal fade addUserLevelPrivillages" style="width: 100%;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="">
                                <div class="row">
                                    <h4 style="padding-left: 35px; padding-top: 15px;"><b>::: Set User Level Privilege :::</b></h4>
                                    <div class="row"><div style="height: 25px;"></div></div>
                                    <div class="col-lg-8">
                                        <div class="form-horizontal">                            
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">User Level :</label>
                                                <div class="col-lg-5">
                                                    <select class="selUserLevel UserLevelPrivillage" id="selUserLevel"></select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="programe_symble" class="col-lg-4 control-label">Privilege :</label>
                                                <div class="col-lg-5">
                                                    <select class="selUserPrivilege" id="selUserPrivilege"></select>
                                                </div>
                                            </div> 

                                            <div class="form-group">
                                                <div class="col-lg-6" id="savesection">
                                                    <button type="button" class="btn btn-primary col-lg-5 pull-right" id="userPrivillegeAdd">Save</button>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <div style="height: 45px;"></div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-11" style="padding-left: 80px;">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Current Set User Level Privileges</h3>
                                                <div class="pull-right">
                                                    <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                                        <i class="glyphicon glyphicon-filter"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="panel-body filterTableSearch">
                                                <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters=".ward-table"/>
                                            </div>
                                            <div class="scrollable" style="height: 300px; overflow-y: auto">
                                                <table class="table table-bordered table-striped table-hover datable userPrivillegeTble">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User Level</th>
                                                            <th>Privilege</th>
                                                            <th>Edit / Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                             
                                                    </tbody>
                                                </table>
                                                <input type="hidden" id="prvCode">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!--set user privilages-->
                    <div class="modal fade addUserPrivillages" style="width: 100%;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="padding:10px;border-radius:5px; background-color: #AACAB4;">
                                <!--                                <div class="container">
                                                                </div>-->
                                <h4 style=""><b>Set User Privilege</b></h4>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-horizontal">
                                            <div class="form-group">

                                                <div class="form-group">
                                                    <label for="programe_symble" class="col-lg-4 control-label">User Name :</label>
                                                    <div class="col-lg-7">
                                                        <select class="selUsername" id="selUsername"></select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5" style="margin-left: 20px;">
                                        <div class="widget selectlistpanel">
                                            <div class="widget-header">
                                                <h3>Available Privileges</h3>
                                            </div>
                                            <div class="widget-content">
                                                <select multiple="" id="available_privilegs">

                                                </select>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-md-1" style="margin-left: 20px;">
                                        <div class="btn-group btn-group-vertical selectionbuttons" >
                                            <button class="btn btn-lg btn-default" id="prv-add" title=""><i class="fa fa-angle-right"></i></button>
                                            <button class="btn btn-lg btn-default" id="prv-add-all" title=""><i class="fa fa-angle-double-right"></i></button>
                                            <button class="btn btn-lg btn-default" id="prv-remove" title=""><i class="fa fa-angle-left"></i></button>
                                            <button class="btn btn-lg btn-default" id="prv-remove-all" title=""><i class="fa fa-angle-double-left"></i></button>
                                        </div>
                                    </div>

                                    <div class="col-md-5" style="margin-left: 25px;">
                                        <div class="widget selectlistpanel">
                                            <div class="widget-header">
                                                <h3>Assigned Privileges</h3>
                                            </div>
                                            <div class="widget-content">
                                                <select multiple="" id="assigned_privileges">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once './include/systemFooter.php'; ?> 
    </body>

    <script type="text/javascript">
        $(function () {

            pageProtect();
            checkurl();
            adminUserTbl();
            userLevelTble();
            get_userlecelCombo();
            selUserPrivilege();
            //            branch_ComboBox();
            userPrivillegeTble($('.UserLevelPrivillage').val());
            get_usernameCombo(false, function () {
                load_filtered_privileges();
                loadUserPrivileges();
            });
            $('select:not([multiple])').chosen({width: "100%"});

            $('#logout').click(function () {
                logout();
            });
            $('#userLvelAdd').click(function () {
                saveUserLevel();
            });
            $('#userPrivillegeAdd').click(function () {
                savePrivillegeLevel();
            });
            $('#UpdateUlevel').click(function () {
                updateUserlevel();
            });
            $('#UpdateSystemuser').click(function () {
                updatesystemuser();
            });
            $('#reset').click(function () {
                $('#updateSection').addClass("hidden");
                $('#savesection').removeClass("hidden");
                $('#userLevel').val('');
            });
            $('#sysUserreset').click(function () {
                $('#userAdupdateSection').addClass("hidden");
                $('#useerAdsavesection').removeClass("hidden");
            });
            $('#systemUserAdd').click(function () {
                saveAdminUser();
            });
            $('#cancel').click(function () {
                clearAdTexBox();
            });
            $('#username').keyup(function () {
                checkUsername($(this).val());
            });
            $('#conPassword').keyup(function () {
                setTimeout(function () {
                    var password = $('#password').val();
                    var conpassword = $('#conPassword').val();
                    if (password === conpassword) {
                        $('#passMasseg').html('');
                        $('#useerAdsavesection').removeClass("hidden");
                    } else {
                        $('#passMasseg').html('Password Does Not Match');
                        $('#useerAdsavesection').addClass("hidden");
                    }
                }, 250);
            });
            $(document).on('change', '#selUsername', function () {
                loadUserPrivileges();
                load_filtered_privileges();
            });
            //            today
            $(document).on('click', '#prv-add', function () {
                var userid = $('#selUsername').val();
                var assigned = $('#assigned_privileges');
                var available = $('#available_privilegs');
                selected_options = available.find('option:selected');
                if (selected_options.length > 0) {
                    options = {};
                    $.each(selected_options, function (index, option) {
                        options[$(option).val()] = $(option).val();
                    });
                    $.post("views/userManegmentView.php", {action: 'add_privlage', userid: userid, options: options}, function (e) {
                        loadUserPrivileges(); //right side
                        load_filtered_privileges(); //left
                    }, 'json');
                } else {
                    alertify.error('Please select one or more.', 10000);
                }
            });
            $(document).on('click', '#prv-add-all', function () {
                var userid = $('#selUsername').val();
                var assigned = $('#assigned_privileges');
                var available = $('#available_privilegs');
                selected_options = available.find('option');
                if (selected_options.length > 0) {
                    options = {};
                    $.each(selected_options, function (index, option) {
                        options[$(option).val()] = $(option).val();
                    });
                    $.post("views/userManegmentView.php", {action: 'add_privlage', userid: userid, options: options}, function (e) {
                        loadUserPrivileges();
                        load_filtered_privileges();
                    }, 'json');
                } else {
                    alertify.error('Please select one or more.', 10000);
                }
            });
            $(document).on('click', '#prv-remove', function () {
                //                alert('okkkkk');
                var userid = $('#selUsername').val();
                var assigned = $('#assigned_privileges');
                var available = $('#available_privilegs');
                selected_options = assigned.find('option:selected');
                if (selected_options.length > 0) {
                    options = {};
                    $.each(selected_options, function (index, option) {
                        options[$(option).val()] = $(option).val();
                    });
                    $.post("views/userManegmentView.php", {action: 'remove_user_privilege', userid: userid, options: options}, function (e) {
                        loadUserPrivileges();
                        load_filtered_privileges();
                    }, 'json');
                } else {
                    alertify.error('Please select one or more.', 1300);
                }
            });
            $(document).on('click', '#prv-remove-all', function () {
                var userid = $('#selUsername').val();
                var assigned = $('#assigned_privileges');
                var available = $('#available_privilegs');
                selected_options = assigned.find('option');
                if (selected_options.length > 0) {
                    options = {};
                    $.each(selected_options, function (index, option) {
                        options[$(option).val()] = $(option).val();
                    });
                    $.post("views/userManegmentView.php", {action: 'remove_user_privilege', userid: userid, options: options}, function (e) {
                        loadUserPrivileges();
                        load_filtered_privileges();
                    }, 'json');
                } else {
                    alertify.error('Please select one or more.', 1300);
                }
            });
            $('.UserLevelPrivillage').change(function () {
                var usrLvl = $(this).val();
                userPrivillegeTble(usrLvl);
            });
            $('#sysUserreset').click(function () {
                updatesystemuser_clear();
            });
            //sam rulz creations

            //email validation
            $('#eMail').on('keyup', function () {
                if ($(this).val() !== "") {
                    var valid = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(this.value) && this.value.length;
                    if (valid) {

                        $('.emailvalue').removeClass('has-error');
                        $('#em_val').html('');
                        $('#systemUserAdd').removeClass('hidden');
                    } else {
                        $('.emailvalue').addClass('has-error');
                        $('#em_val').html('<i class="glyphicon glyphicon-warning-sign"></i> E-Mail address is not valid.');
                        $('#systemUserAdd').addClass('hidden');
                    }

                } else {
                    $('.emailvalue').removeClass('has-error');
                    $('#em_val').html('');
                    $('#systemUserAdd').removeClass('hidden');
                }
            });

            //            nic validation
            $('#nic').on('keyup', function () {
                var nic_no = document.getElementById('nic').value;
                if (/^[0-9]{9}[VvXx]{1}$/.test(nic_no) || nic_no.length < 1) {
                    $('#nic_val').html('');
                    $('#nic_valok').html('<i class="glyphicon glyphicon-ok-sign"></i> Valid NIC number.');
                    $('#systemUserAdd').removeClass('hidden');
                } else {
                    $('#nic_valok').html('');
                    $('#nic_val').html('<i class="glyphicon glyphicon-warning-sign"></i> NIC number is not Valid.');
                    $('#systemUserAdd').addClass('hidden');
                }
            });

            $('#mobile').on('keyup', function () {
                var phonecusregval = $(this).val().length;

                if (phonecusregval == '0' || phonecusregval == '10') {
                    $('#systemUserAdd').removeClass('hidden');
                    if (phonecusregval == '10') {
                        $('#mobi').html('');
                        $('#mobiok').html('<i class="glyphicon glyphicon-ok-sign"> Valid phone number</i> ');
                    } else {
                        $('#mobi').html('');
                        $('#mobiok').html('<i class="glyphicon glyphicon-ok-sign"> No phone number entered. But you can save.! </i> ');
                    }


                } else {
                    $('#systemUserAdd').addClass('hidden');
                    $('#mobi').html('<i class="glyphicon glyphicon-warning-sign"></i> Sorry... Invalid Phone Number');
                    $('#mobiok').html('');
                }
            });
            $('#work').on('keyup', function () {
                var phonecusregval = $(this).val().length;

                if (phonecusregval == '0' || phonecusregval == '10') {
                    $('#systemUserAdd').removeClass('hidden');
                    if (phonecusregval == '10') {
                        $('#works').html('');
                        $('#worksok').html('<i class="glyphicon glyphicon-ok-sign"> Valid phone number</i> ');
                    } else {
                        $('#works').html('');
                        $('#worksok').html('<i class="glyphicon glyphicon-ok-sign"> No phone number entered. But you can save.! </i> ');
                    }


                } else {
                    $('#systemUserAdd').addClass('hidden');
                    $('#works').html('<i class="glyphicon glyphicon-warning-sign"></i> Sorry... Invalid Phone Number');
                    $('#worksok').html('');
                }
            });
            $('#home').on('keyup', function () {
                var phonecusregval = $(this).val().length;

                if (phonecusregval == '0' || phonecusregval == '10') {
                    $('#systemUserAdd').removeClass('hidden');
                    if (phonecusregval == '10') {
                        $('#homes').html('');
                        $('#homesok').html('<i class="glyphicon glyphicon-ok-sign"> Valid phone number</i> ');
                    } else {
                        $('#homes').html('');
                        $('#homesok').html('<i class="glyphicon glyphicon-ok-sign"> No phone number entered. But you can save.! </i> ');
                    }


                } else {
                    $('#systemUserAdd').addClass('hidden');
                    $('#homes').html('<i class="glyphicon glyphicon-warning-sign"></i> Sorry... Invalid Phone Number');
                    $('#homesok').html('');
                }
            });

            $('.datepicker').datepicker();

            $(document).ready(function ()
            {
                $(document).bind("contextmenu", function (e) {
//                    return false;
                });
            });

            document.onkeypress = function (event) {
                event = (event || window.event);
                if (event.keyCode == 123) {
                    //alert('No F-12');
//                    return false;
                }
            }
            document.onmousedown = function (event) {
                event = (event || window.event);
                if (event.keyCode == 123) {
                    //alert('No F-keys');
//                    return false;
                }
            }
            document.onkeydown = function (event) {
                event = (event || window.event);
                if (event.keyCode == 123) {
                    //alert('No F-keys');
//                    return false;
                }
            }

        });
    </script>
</html>

