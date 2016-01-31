function save_paysheet() {

            var name = $('#employee').val();
            var epfno = $('#epf').val();
            var emp_id = $('#eid').val();
            var nic = $('#nic').val();
            var basic = $('#basic').val();
            var hours = $('#hours').val();
            var hourlyrate = $('#hourlyrate').val();
            var nopay = $('#nopay').val();
            var late = $('#late').val();
            var othours = $('#othours').val();
            var otrate = $('#otrate').val();
            var advance = $('#advance').val();
            var meal = $('#meal').val();
            var epfval = $('#epfval').val();
            var other = $('#other').val();
            var salary = $('#salary').val();
            var date = $('#date').val();
            var paysheet_id = $('#max_id').val();

            $.post('models/model_paysheet.php', {action: 'save_paysheet', paysheet_id: paysheet_id, name: name, emp_id: emp_id, epfno: epfno, nic: nic, nopay: nopay, late: late, basic: basic, othours: othours, otrate: otrate, advance: advance, meal: meal, salary: salary,epfval:epfval, date: date}, function(e) {
                alertifyMsgDisplay(e, 1000);
                clear_pay_form();
                load_max_emp_id(); // load the next max value to the paysheet id textbox


            }, "json");
        }

function load_employee(selected, callBack) {
    var comboData = '';
    $.post("models/model_payseet.php", {comboBox: 'load_employee'}, function(e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('#employee').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function(index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.emp_id)) {
                        comboData += '<option value="' + qData.emp_id + '" selected>' + qData.name + '</option>';
                    } else {
                        comboData += '<option value="' + qData.emp_id + '">' + qData.name + '</option>';
                    }
                }
            });
            $('#employee').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

    function load_max_emp_id() {
            // function for loading primary key + 1 value for the text box from the database.

            var mid = $('#max_id').val();

            $.post("./models/model_paysheet.php", {action: 'max_id', id: mid}, function(e) {
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
