<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
?>
<!DOCTYPE html>
<html>
    <head>        

        <?php require_once './include/systemHeader.php'; ?>   
    </head>
    <body>
        <div id="wrap"><!-- class="bgCustome"-->
            <?php require_once './include/navBar.php'; ?>
            <!doctype html>
            <!--   Big container   -->
            <div class="container">
                <div class="row">
                                       <!--Generate User Paysheet-->

                    <div class="row">
                        <h4 style="padding-left: 35px; padding-top: 15px; margin-top:-30px;margin-bottom: -10px; text-align: center"><b>::: Calculate Salary ::</b></h4>
                        <div class="row"><div style="height: 25px;"></div></div>
                        <div class="col-lg-6">
                            <div class="form-horizontal">

                                <div class="card">
                                    <div class="form-group">
                                        <label for="programe_symble" class="col-lg-4 control-label">Employee Name :</label>
                                        <div class="col-lg-7">
                                            <select class="form-control" id="employee" name="name" style="background-color: #e1edf7;"></select>
                                        </div>
                                    </div> 



                                    <input type="hidden" id="hiddenUserId" value="">

                                    <div class="form-group">
                                        <label for="programe_symble" class="col-lg-4 control-label">Employee ID :</label>
                                        <div class="col-lg-7">                                            
                                            <select class="form-control" id="eid" name="eid"  style="color: #001940;"></select>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label for="programe_symble" class="col-lg-4 control-label">EPF No :</label>
                                        <div class="col-lg-7">
                                            <select class="form-control" id="epf" name="epf"  style="color: #001940;"></select>
                                            <h5 id="passMasseg" style="color: red;"></h5>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label for="nic" class="col-lg-4 control-label"> NIC No: <i class="glyphicon glyphicon-info-sign"></i></label>
                                        <div class="col-lg-7">

                                            <input type="text" class="form-control nic" id="nic" >
                                            <h5 id="nic_val" style="color: red;"></h5>
                                            <h5 id="nic_valok" style="color: green;"></h5>
                                        </div>
                                    </div> 

                                    <div class="form-group ">
                                        <label for="start_date" class="col-lg-4 control-label"> Date :</label>
                                        <div class="col-lg-6">
                                            <div class="input-group col-lg-12">
                                                <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                                                <input type="text" class="form-control datepicker " id="date"
                                                       title="select paysheet due date "  data-toggle="tooltip"
                                                      value="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="paysheet_id" class="col-lg-4 control-label"> Paysheet ID:</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control " id="max_id" >
                                        </div>
                                    </div>



                                </div>


                                <div class="form-group">
                                    <label for="programe_symble" class="col-lg-4 control-label">Basic. : <span style="color:#f00;font-size:20px">*</span></label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="basic" placeholder="Basic Sallary" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div> 


                                <div class="form-group">
                                    <label for="HourlyRate" class="col-lg-4 control-label">Nopay :</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="nopay" placeholder="Nopay" onkeypress="return isNumberKey(event)">    
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-horizontal">             
                                <div class="form-group">
                                    <label for="programe_symble" class="col-lg-4 control-label">Late :</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="late" placeholder="Late" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="programe_symble" class="col-lg-4 control-label">O/T Hours :</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="othours" placeholder="O/T " onkeypress="return isNumberKey(event)">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="programe_symble" class="col-lg-4 control-label">O/T Hourly Rate :</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="otrate" placeholder="O/T Hourly Rate " onkeypress="return isNumberKey(event)">
                                    </div>
                                </div> 

                                <div class="card">

                                    <div class="form-group">
                                        <label for="programe_symble" class="col-lg-4 control-label">Advance :</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" id="advance" placeholder="advance" style="background-color: #dff0d8" maxlength="10" onkeypress="return isNumberKey(event)">
                                            <h6 id="mobi" style="color: red;"></h6>
                                            <h6 id="mobiok" style="color: green;"></h6>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="programe_symble" class="col-lg-4 control-label">meal allowances :</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" id="meal" placeholder="meal" style="background-color: #a6e1ec" maxlength="10" onkeypress="return isNumberKey(event)">
                                            <h6 id="msg" style="color: red;"></h6>
                                            <h6 id="worksok" style="color: green;"></h6>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="programe_symble" class="col-lg-4 control-label">EPF %8  :</label>
                                        <div class="col-lg-7">

                                            <input type="text" class="form-control" id="epfval" placeholder="epf" style="background-color: #f5e79e" maxlength="10" onkeypress="return isNumberKey(event)">
                                            <h6 id="homes" style="color: red;"></h6>
                                            <h6 id="homesok" style="color: green;"></h6>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="programe_symble" class="col-lg-4 control-label">Other Allowances:</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" id="other" placeholder="allowances" style= "background-color: #ec9a90" maxlength="10" onkeypress="return isNumberKey(event)">
                                            <h6 id="homes" style="color: red;"></h6>
                                            <h6 id="homesok" style="color: green;"></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="programe_symble" class="col-lg-4 control-label">Salary :</label>
                                    <div class="col-lg-7">

                                        <input type="text" class="form-control" id="salary" placeholder="net salary" style="background-color: #f5e79e" maxlength="10" onkeypress="return isNumberKey(event)">
                                        <h6 id="homes" style="color: red;"></h6>
                                        <h6 id="homesok" style="color: green;"></h6>
                                    </div>
                                </div>
                              

                                <div class="form-group">

                                    <div  id="calculate_section" class=" col-lg-12 ">
                                        <button type="button" class="btn btn-info " id="paysheet_reset"><i class="fa fa-refresh fa-lg"></i>Reset</button>&nbsp;
                                        <button type="button" class="btn btn-success right" id="paysheet_save"><i class="fa fa-save fa-lg"></i>Save Paysheet</button>&nbsp;

                                    </div>

                                </div> 
                            </div>
                        </div>
                    </div>

                </div><!-- end row -->
            </div> <!--  big container -->
        </div>
    </body>


    <script type="text/javascript" src="controllers/employee.js">
    </script>
    <?php require_once './include/systemFooter.php'; ?>


</html>
<script type="text/javascript">
    $(function() {
        //starterBgSlideTransition_for_sub_pages();
       // pageProtect();
       // checkurl();
        load_max_id(); // load the next max value to the paysheet id textbox

        $('#paysheet_save').click(function() {
            save_paysheet();
        });


        $('#paysheet_id').keyup(function() {
            setTimeout(function() {


            }, 1000);
        });


//    

        

 load_employee();

//        load_employee(null, function() {
//            load_emp_id($('#employee').val());
//        });
//
//        $('#employee').change(function() {
//            load_emp_id($('#employee').val());
//
//        });
//        $('#employee').change(function() {
//            load_epfno($('#employee').val());
//
//        });

        function load_max_id() {
            // function for loading primary key + 1 value for the text box from the database.

            var mid = $('#max_id').val();

            $.post("Models/model_employee.php", {action: 'max_id', id: mid}, function(e) {
                if (e === undefined || e.length === 0 || e === null) {
                    alertify.error("No Data Found For Max ID", 1000);
                } else
                {
                    $.each(e, function(index, qData) {
                        $('#max_id').val(++qData.payid);

                    });
                }
            }, "Json");

        }



        //            nic validation
        $('#nic').on('keyup', function() {
            var nic_no = document.getElementById('nic').value;
            if (/^[0-9]{9}[VvXx]{1}$/.test(nic_no) && nic_no.length == 10) {
                $('#nic_val').html('');
                $('#nic_valok').html('<i class="glyphicon glyphicon-ok-sign"></i> Valid NIC number.');
                $('#systemUserAdd').removeClass('hidden');
            } else {
                $('#nic_valok').html('');
                $('#nic_val').html('<i class="glyphicon glyphicon-warning-sign"></i> NIC number is not Valid.');
                $('#systemUserAdd').addClass('hidden');

            }
        });
        $(document).ready(function()
      /*  {
            $(document).bind("contextmenu", function(e) {
                return false;
            });
        });
        document.onkeypress = function(event) {
            event = (event || window.event);
            if (event.keyCode == 123) {
                //alert('No F-12');
                return false;
            }
        }
        document.onmousedown = function(event) {
            event = (event || window.event);
            if (event.keyCode == 123) {
                //alert('No F-keys');
                return false;
            }
        }
        document.onkeydown = function(event) {
            event = (event || window.event);
            if (event.keyCode == 123) {
                //alert('No F-keys');
                return false;
            }
        }
        
        */

    });
</script>

</html>

