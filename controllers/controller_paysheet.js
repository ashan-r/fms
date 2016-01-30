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

            $.post('Models/model_employee.php', {action: 'save_paysheet', paysheet_id: paysheet_id, name: name, emp_id: emp_id, epfno: epfno, nic: nic, nopay: nopay, late: late, basic: basic, othours: othours, otrate: otrate, advance: advance, meal: meal, salary: salary,epfval:epfval, date: date}, function(e) {
                alertifyMsgDisplay(e, 1000);
                clear_pay_form();
                load_max_id(); // load the next max value to the paysheet id textbox


            }, "json");
        }
