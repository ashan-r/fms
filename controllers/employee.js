/* Controller for employee detail management
 * @Ashan Rajapaksha  */


/////////////////////////////////////////////////////////////////////////////////////////     
////////////////////////        FORM DATA SAVE                        ///////////// 
//////////////////////////////////////////////////////////////////////////////////////

function save_employee() {

    var gender = $("input[type='radio'][name='rbt_gender']:checked").val();
    var emp_id = $('#emp_id').val();
    var empno = $('#empno').val();
    var title = $('#title').val();
    var designation = $('#designation').val();
    var nic = $('#nic').val();
    var name = $('#name').val();
    var tel = $('#tel').val();
    var epfno = $('#epfno').val();
    var basic = $('#basic').val();
    var reg_date = $('#reg_date').val();
    var status = $('#status').val();
    if (empno.length !== 0 && nic.length !== 0) {
        var data_array = {
            emp_id: emp_id,
            empno: empno,
            title: title,
            designation: designation,
            nic: nic,
            name: name,
            tel: tel,
            gender: gender,
            epfno: epfno,
            basic: basic,
            reg_date: reg_date,
            status: status
        }

        $.post("models/employee.php", {action: 'save_employee', form_data: data_array}, function(reply) {
            alertifyMsgDisplay(reply, 2000, function() {
                // clear_sup_form();
                load_employee_tbl();
            });
        }, 'json');
    } else {
        alertify.error("Enter valid employee data", 2500);
    }
}

function update_employee() {
    var sup_id = $('#supp_id').val();
    var gender = $("input[type='radio'][name='rbt_gender']:checked").val();
    var emp_id = $('#emp_id').val();
    var empno = $('#empno').val();
    var title = $('#title').val();
    var designation = $('#designation').val();
    var nic = $('#nic').val();
    var name = $('#name').val();
    var tel = $('#tel').val();
    var epfno = $('#epfno').val();
    var basic = $('#basic').val();
    var reg_date = $('#reg_date').val();
    var status = $('#status').val();
    if (empno.length !== 0 && nic.length !== 0) {
        var data_array = {
            emp_id: emp_id,
            empno: empno,
            title: title,
            designation: designation,
            nic: nic,
            name: name,
            tel: tel,
            gender: gender,
            epfno: epfno,
            basic: basic,
            reg_date: reg_date,
            status: status
        }

        $.post("models/employee.php", {action: 'update_employee', form_data: data_array}, function(reply) {
            alertifyMsgDisplay(reply, 2000, function() {
                clear_e_form();
                load_sup_reg_tbl();
            });
        }, 'json');
    } else {
        alertify.error("Enter valid Supplier Code & name", 2500);
    }
}

function delete_employee(emp_id) {
//@Ashan
    confirm("Delete Employee", "Are You Sure Want To Delete This record ?", "No", "Yes", function() {
        $.post("models/employee.php", {action: 'delete_employee', emp_id: emp_id}, function(e) {
            alertifyMsgDisplay(e, 2000);
            load_employee_tbl();
        }, "json");
    });
}

function next_ai_emp() {
    $.post('models/employee.php', {action: 'next_ai_emp'}, function(e) {
        if (e === undefined || e.length === 0 || e === null) {
            alertify.error('Error in getting maximum value.', 2000);
        } else {

            $('#emp_id').val(e);
        }
    }, 'json');
}
function clear_emp_form() {
    $('#emp_id').val("");
    $('#empno').val("");
    $('#sup_name').val("");
    $('#title').val("");
    $('#designation').val("");
    $('#nic').val("");
    $('#name').val("");
    $('#tel').val("");
    $('#epfno').val("");
    $('#basic').val("");
    $('#reg_date').val("");

    hide_supp_btn();
}

function show_employee_btn() {
//   @Ashan
    if ($('#btn_update_emp').hasClass('hidden')) {
        $('#btn_update_emp').removeClass('hidden');
    }
    if (!$('#btn_emp_add').hasClass('hidden')) {
        $('#btn_emp_add').addClass('hidden');
    }
}
function hide_employee_btn() {
//   @Ashan
    if (!$('#btn_update_supp').hasClass('hidden')) {
        $('#btn_update_supp').addClass('hidden');
    }
    if ($('#btn_supp_add').hasClass('hidden')) {
        $('#btn_supp_add').removeClass('hidden');
    }
}
/////////////////////////////////////////////////////////////////////////////////////////     
////////////////////////        END                                    ///////////// 
//////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////////     
////////////////////////        FORM DATA LOADING                   ///////////// 
//////////////////////////////////////////////////////////////////////////////////////


function get_selected_employee_data(emp_id) {

    // var gender = parseInt($("input[type='radio'][name='rbt_gender']:checked").val());
    $.post("models/employee.php", {action: 'get_selected_employee_data', emp_id: emp_id}, function(reply) {
        if (reply === undefined || reply.length === 0 || reply === null) {
            alertify.error("No Data Found", 1000);
        } else {
            $.each(reply, function(index, data) {
                $('#emp_id').val(data.emp_id);
                $('#empno').val(data.empno);
                $('#name').val(data.name);
                $('#nic').val(data.nic);
                $('#designation').val(data.designation);
                $('#epfno').val(data.epfno);
                $('#basic').val(data.basic);
                $('#reg_date').val(data.reg_date);
                $('#tel').val(data.tel);
                if (data.gender == 'male') {
                    $('#rbt_male').prop('checked', true);
                    $('#rbt_female').prop('checked', false);
                } else if (data.gender == 'female') {
                    $('#rbt_male').prop('checked', false);
                    $('#rbt_female').prop('checked', true);
                } else {

                }
                chosenRefresh();
            });
            //     show_supp_btn();
        }

    }, 'json');
}



