/* Controller for employee detail management
 * @Ashan Rajapaksha  */

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

function clear_sup_form() {
    $('#supp_id').val("");
    $('#sup_code').val("");
    $('#sup_name').val("");
    $('#sup_name_for_invo').val("");
    $('#address').val("");
    $('#address_for_invo').val("");
    $('#phone_no').val("");
    $('#phone_no_for_invo').val("");
    $('#fax').val("");
    $('#email').val("");
    $('#web').val("");
    $('#suppbank_name').val("");
    $('#suppbank_id').val("");
    hide_supp_btn();
}

function show_employee_btn() {
//   @Sachith
    if ($('#btn_update_supp').hasClass('hidden')) {
        $('#btn_update_supp').removeClass('hidden');
    }
    if (!$('#btn_supp_add').hasClass('hidden')) {
        $('#btn_supp_add').addClass('hidden');
    }
}
function hide_employee_btn() {
//   @Sachith
    if (!$('#btn_update_supp').hasClass('hidden')) {
        $('#btn_update_supp').addClass('hidden');
    }
    if ($('#btn_supp_add').hasClass('hidden')) {
        $('#btn_supp_add').removeClass('hidden');
    }
}

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



function update_supp() {
    var sup_id = $('#supp_id').val();
    var sup_code = $('#sup_code').val();
    var sup_name = $('#sup_name').val();
    var sup_name_for_invo = $('#sup_name_for_invo').val();
    var address = $('#address').val();
    var address_for_invo = $('#address_for_invo').val();
    var phone_no = $('#phone_no').val();
    var phone_no_for_invo = $('#phone_no_for_invo').val();
    var fax = $('#fax').val();
    var email = $('#email').val();
    var web = $('#web').val();
    var currency = $('#sup_currency').val();
    var suppbank_id = $('#suppbank_id').val();
    if (sup_code.length !== 0 && sup_name.length !== 0 && parseInt(sup_id) > 0) {
        var data_array = {sup_id: sup_id,
            sup_code: sup_code,
            sup_name: sup_name,
            sup_name_for_invo: sup_name_for_invo,
            address: address,
            address_for_invo: address_for_invo,
            phone_no: phone_no,
            phone_no_for_invo: phone_no_for_invo,
            fax: fax,
            email: email,
            web: web,
            suppbank_id: suppbank_id,
            currency: currency
        }

        $.post("views/commenSettingView.php", {action: 'update_supp', form_data: data_array}, function(reply) {
            alertifyMsgDisplay(reply, 2000, function() {
                clear_sup_form();
                load_sup_reg_tbl();
            });
        }, 'json');
    } else {
        alertify.error("Enter valid Supplier Code & name", 2500);
    }
}

function delete_supplier(supp_id) {
//@Sachith 
    confirm("Delete Supplier", "Are You Sure Want To Delete This record", "No", "Yes", function() {
        $.post("views/commenSettingView.php", {action: 'delete_supplier', supp_id: supp_id}, function(e) {
            alertifyMsgDisplay(e, 2000);
            load_sup_reg_tbl();
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