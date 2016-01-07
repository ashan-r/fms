function load_maker_table() {
    //@Sachith 
    var tableData = '';
    $.post("views/loadTables.php", {table: "maker_info"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="2" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.maker_info_table tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td width="60%">' + qData.maker_name + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_maker" value="' + qData.maker_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;Edit</button><button class="btn btn-custom-light del_maker" value="' + qData.maker_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</button></div></td>';
                tableData += '</tr>';
            });
            $('.maker_info_table tbody').html('').append(tableData);
            tableSorter('.maker_info_table');

            // TABLE ACTION BUTTONS
            //UPDATE
            $('.sel_maker').click(function () {
                select_maker($(this).val());
            });
            //DELETE
            $('.del_maker').click(function () {
                delete_maker($(this).val());


            });
        }
    }, "json");
}
function load_proInvoiceView_table(callBack) {
    //@VIRAJ 
    var inv_status = $('#cmb_inv_status').val();
    var tableData = '';
    $.post("views/loadTables.php", {table: "load_proInvoiceView_table", inv_status: inv_status}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="18" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.load_proInvoiceView_table tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, Rdata) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + Rdata.pi_no + '</td>';
                tableData += '<td>' + Rdata.pi_date + '</td>';
                tableData += '<td>' + Rdata.cus_inv_name + '</td>';
                tableData += '<td>' + Rdata.consignee_name + '</td>';
                tableData += '<td>' + Rdata.last_shipment_date + '</td>';
                tableData += '<td>' + Rdata.port_discharge + '</td>';
                tableData += '<td>' + Rdata.validity + '</td>';
                tableData += '<td class="text-right">' + Rdata.total_cif + '</td>';
                tableData += '<td>';
                tableData += '<div class="btn-group">';
                tableData += '<button class="btn btn-custom-save edit_prInv" value="' + Rdata.pi_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>';
                if (parseInt(inv_status) === 1) {
                    tableData += '<button class="btn btn-custom-light btn-sm cansel_prIn" value="' + Rdata.pi_id + '"><i class="fa fa-trash-o"></i></button>';
                    tableData += '<button class="btn btn-custom-light btn-sm reprint_inv" data-invtype="' + Rdata.pi_type + '" value="' + Rdata.pi_id + '"><i class="fa fa-print"></i></button>';
                }
                tableData += '</div>';
                tableData += '</td>';
                tableData += '</tr>';
            });
            $('.load_proInvoiceView_table tbody').html('').append(tableData);
            if (callBack !== undefined) {
                if (typeof callBack === 'function') {
                    callBack();
                }
            }
        }

    }, "json");
}
function kitz_load_customers() {
    var tableData = '';
    $.post("views/loadTables.php", {table: "c_customers_table"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="7" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.c_customers_table tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
//                tableData += '<td>' + index + '</td>';
                tableData += '<td>' + qData.cus_name + '</td>';
                tableData += '<td>' + qData.cus_inv_name + '</td>';
                tableData += '<td>' + qData.cus_address + '</td>';
//                tableData += '<td>' + qData.cus_inv_address + '</td>';
                tableData += '<td>' + qData.cus_phone1 + '</td>';
                tableData += '<td>' + qData.cus_phone2 + '</td>';
                tableData += '<td>' + qData.other_contact + '</td>';
//                tableData += '<td>' + qData.comments + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save c_select_customer" value="' + qData.cus_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button><button class="btn btn-custom-light c_delete_customer" value="' + qData.cus_id + '"><i class="fa fa-trash-o fa-lg"></i></button></div></td>';
                tableData += '</tr>';
            });
            $('.c_customers_table tbody').html('').append(tableData);
            tableSorter('.c_customers_table');

            // TABLE ACTION BUTTONS
            //SELECT
            $('.c_select_customer').click(function () {
                kitz_select_costomer($(this).val());
            });
            //DELETE
            $('.c_delete_customer').click(function () {
                kitz_delete_customer($(this).val());
            });
        }
    }, "json");
}

function load_model_table(maker_id) {
    //@Sachith 
    var tableData = '';
    $.post("views/loadTables.php", {table: "model_info", maker_id: maker_id}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="2" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.model_info_tbl tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td width="60%">' + qData.mod_name + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_model" value="' + qData.mod_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;Edit</button><button class="btn btn-custom-light del_model" value="' + qData.mod_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</button></div></td>';
                tableData += '</tr>';
            });
            $('.model_info_tbl tbody').html('').append(tableData);
            tableSorter('.model_info_tbl');

            // TABLE ACTION BUTTONS
            //UPDATE
            $('.sel_model').click(function () {
                select_model($(this).val());
            });
            //DELETE
            $('.del_model').click(function () {
                delete_model($(this).val());
            });
        }
    }, "json");
}
function load_sup_reg_tbl() {
    var tableData = '';
    $.post("views/loadTables.php", {table: "load_sup_reg_tbl"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="4" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.reg_sup_details_tbl tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td style="text-align: center">' + data.supp_code + '</td>';
                tableData += '<td style="text-align: center">' + data.supp_name + '</td>';
                tableData += '<td style="text-align: center">' + data.supp_address + '</td>';
                tableData += '<td style="text-align: center">' + data.phone + '</td>';
                tableData += '<td style="text-align: center">' + data.supp_fax + '</td>';
                tableData += '<td style="text-align: center">' + data.supp_email + '</td>';
                tableData += '<td style="text-align: center">' + data.web + '</td>';
                tableData += '<td style="text-align: center"><div class="btn-group"><button class="btn btn-custom-save select_supp" value="' + data.supp_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;Edit</button> &nbsp;<button class="btn btn-custom-light delete_supp" value="' + data.supp_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</button></div></td>';
                tableData += '</tr>';
            });
            $('.reg_sup_details_tbl tbody').html('').append(tableData);

            $('.select_supp').click(function () {
                var sup_id = $(this).val();
                get_selected_supp_data(sup_id);
            });

            $('.delete_supp').click(function () {
                delete_supplier($(this).val());
            });

        }

    }, "json");
}



function load_vehicle_clearnce_tbl() {
    //@Ashan
    var tableData = '';
    $.post("views/loadTables.php", {table: "load_clearnce_tbl"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="4" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.clearing_details_tbl tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td style="text-align: center">' + data.clr_id + '</td>';
                tableData += '<td style="text-align: center">' + data.vh_id + '</td>';
                tableData += '<td style="text-align: center">' + data.shipped_date + '</td>';
                tableData += '<td style="text-align: center">' + data.arrival_date + '</td>';
                tableData += '<td style="text-align: center">' + data.duty + '</td>';
                tableData += '<td style="text-align: center"><div class="btn-group"><button class="btn btn-custom-save select_supp" value="' + data.clr_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;Edit</button> &nbsp;<button class="btn btn-custom-light delete_supp" value="' + data.clr_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</button></div></td>';
                tableData += '</tr>';
            });
            $('.clearing_details_tbl tbody').html('').append(tableData);

//            $('.select_supp').click(function () {
//                var sup_id = $(this).val();
//                get_selected_supp_data(sup_id);
//            });
//
//            $('.delete_supp').click(function () {
//                delete_supplier($(this).val());
//            });

        }

    }, "json");
}
//// viraj
function vehicleModiTable(vh_id) {
    var tableData = '';
    $.post("views/loadTables.php", {table: "vehicleModiTable", vh_id: vh_id}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="7" class="alert alert-warning text-center"> -- No Data Found for Selected Vehicle-- </th></tr>';
            $('.vehicleModiTable tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td style="text-align: center">' + data.vh_code + '</td>';
                tableData += '<td style="text-align: center">' + data.cus_name + '</td>';
                tableData += '<td style="text-align: center">' + data.desc + '</td>';
                tableData += '<td style="text-align: center">' + data.options + '</td>';
                tableData += '<td style="text-align: center">' + data.other_opt + '</td>';
                tableData += '<td style="text-align: center">' + data.request_date + '</td>';
                tableData += '<td style="text-align: center"><div class="btn-group"><button class="btn btn-custom-save modific_up" value="' + data.mod_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button> &nbsp;<button class="btn btn-custom-light modific_del" value="' + data.mod_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;</button></div></td>';
                tableData += '</tr>';
            });
            $('.vehicleModiTable tbody').html('').append(tableData);

            $('.modific_up').click(function () {
                var modific_up = $(this).val();
                $('#mod_update_div').removeClass('hidden');
                $('#mod_save_div').addClass('hidden');
                get_selected_modd_data(modific_up);
            });

            $('.modific_del').click(function () {
                delete_modific($(this).val());
            });
        }

    }, "json");
}
//// end viraj
function load_coordinator_table() {
    //@Sachith 
    var tableData = '';
    $.post("views/loadTables.php", {table: "load_coordinator_tbl"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="3" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.coordinator_tbl tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.coordinator_name + '</td>';
                tableData += '<td>' + qData.short_name + '</td>';
                tableData += '<td>' + qData.phone + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_maker" value="' + qData.coordinator_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;Edit</button><button class="btn btn-custom-light del_maker" value="' + qData.coordinator_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</button></div></td>';
                tableData += '</tr>';
            });
            $('.coordinator_tbl tbody').html('').append(tableData);
            tableSorter('.coordinator_tbl');

            // TABLE ACTION BUTTONS
            //UPDATE
            $('.sel_maker').click(function () {
                select_coordinator($(this).val());
            });
            //DELETE
            $('.del_maker').click(function () {
                delete_coordinator($(this).val());


            });
        }
    }, "json");
}

function load_view_orders_table(order_status, callBack) {
    //@Sampath 
    var tableData = '';
    $.post("views/loadTables.php", {table: "load_view_order_tbl", order_status: order_status}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="18" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.view_order_table tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.order_no + '</td>';
                tableData += '<td>' + qData.order_date + '</td>';
                tableData += '<td>' + qData.vh_code + '</td>';
//                tableData += '<td>' + qData.maker_name + '</td>';
                tableData += '<td>' + qData.mod_name + '</td>';
                tableData += '<td>' + qData.vh_year + '</td>';
                tableData += '<td>' + qData.vh_color + '</td>';
                tableData += '<td>' + qData.milage_max + '</td>';
                tableData += '<td>' + qData.vh_options + '</td>';
                tableData += '<td>' + qData.cus_conditions + '</td>';
                tableData += '<td>' + qData.order_actions + '</td>';
                tableData += '<td>' + qData.max_price + '</td>';
                tableData += '<td>' + qData.pay_advance + '</td>';
                tableData += '<td>' + qData.coordinator_name + '</td>';
                tableData += '<td>' + qData.gb + '</td>';
                tableData += '<td>' + qData.cus_name + '</td>';
                tableData += '<td>' + qData.pay_comments + '</td>';
                tableData += '<td>' + qData.description + '</td>';
                if (parseInt(qData.order_status) < 3) {
                    tableData += '<td><div class="btn-group">';
                    if (parseInt(qData.vh_reserved) > 0) {
                        tableData += '<button class="btn btn-custom-light del_order" value="' + qData.order_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Cancel</button>';
                    } else {
                        tableData += '<button class="btn btn-custom-save sel_order_id" value="' + qData.order_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>' +
                                '<button class="btn btn-custom-light del_order" value="' + qData.order_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Cancel</button>';
                    }
                    tableData += '</div></td>';
                } else {
                    tableData += '<td>&nbsp;</td>';
                }
                tableData += '</tr>';
            });
            $('.view_order_table tbody').html('').append(tableData);
//            tableSorter('.view_order_table');

            // TABLE ACTION BUTTONS
            //SELECT
            $('.sel_order_id').click(function () {
                load_order_details($(this).val());
            });
            //DELETE
            $('.del_order').click(function () {
                order_cancel($(this).val());
            });
            if (callBack !== undefined) {
                if (typeof callBack === 'function') {
                    callBack();
                }
            }
        }
    }, "json");
}

function load_order_details(order_id) {
    var win = window.open('customer_order.php?order_id=' + order_id, '_blank');
    win.focus();
}

function load_vehicle_table(page, callback) {
    //@Sampath 
    var supp_id = $('#cmb_supp').val();
    var stock_status = $('#cmb_stock_status').val();
    var records = $('#page_records').val();
    var tableData = '';
    if (page === undefined || isNaN(parseInt(page)) || parseInt(page) <= 0) {
        page = 1;
    }
    $.post("views/loadTables.php", {table: "load_view_vehicle_tbl", supp_id: supp_id, stock_status: stock_status, page: page, records: records}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="22" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.view_vh_table tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
//                qData.color_group

                index++;
                tableData += '<tr ';
                if (qData.color_group != null && qData.color_group.length > 0) {
                    tableData += ' style="background-color:#' + qData.color_group + ';"';
                }
                tableData += '>';
                tableData += '<td>';
                tableData += '<div class="btn-group"><button class="btn btn-custom-light btn-xs sel_order_id" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="bottom" title="Edit Vehicle"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>'
                        + '<button class="btn btn-custom-save btn-xs veiw_details_ex" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="bottom" title="View Details"><i class="fa fa-external-link"></i>&nbsp;</button></div>';
//                <button class="btn "> <i class="fa fa-external-link"></i></button>
                tableData += '</td>';
                tableData += '<td><input type="checkbox" class="checkBX" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="top" title="Select Record">&nbsp;</td>';
                tableData += '<td>' + qData.vh_index_num + '</td>';
//                tableData += '<td>' + qData.supp_name + '</td>';
                tableData += '<td>' + qData.vh_code + '</td>';
                tableData += '<td>' + qData.supp_name + '</td>';
                tableData += '<td>' + qData.maker_name + '</td>';
                tableData += '<td>' + qData.mod_name + '</td>';
                tableData += '<td>' + qData.vh_chassis_code + '</td>';
                tableData += '<td>' + qData.vh_chassis_num + '</td>';
                tableData += '<td>' + qData.engine_code + '</td>';
                tableData += '<td>' + qData.engine_num + '</td>';
                tableData += '<td>' + qData.engine_cc + '</td>';
                tableData += '<td>' + qData.package + '</td>';
                tableData += '<td>' + qData.vh_year + '</td>';
                tableData += '<td>' + qData.vh_color + '</td>';
                tableData += '<td>' + qData.vh_milage + '</td>';
                tableData += '<td>' + qData.vh_options + '</td>';
                tableData += '<td>' + qData.additional_options + '</td>';
                tableData += '<td>' + qData.bid_date + '</td>';
                tableData += '<td>' + qData.auction_name + '</td>';
                tableData += '<td>' + qData.auction_grade + '</td>';
//                tableData += '<td>' + qData.lot_no + '</td>';
//                tableData += '<td>' + qData.auc_display_price + '</td>';
//                tableData += '<td>' + qData.stock_location + '</td>';
//                tableData += '<td>' + qData.short_name + '</td>';
                tableData += '</tr>';
            });
            $('.view_vh_table tbody').html('').append(tableData);

            // TABLE ACTION BUTTONS
            //SELECT
            $('.sel_order_id').click(function () {
                load_vh_edit($(this).val());
            });
            //DETAILS
            $('.veiw_details_ex').click(function () {
                submitSingleDataByPost('vehicle_single_view.php', 'veh_id', $(this).val());
            });
            //DELETE
            $('.del_maker').click(function () {
            });
        }
        load_vhview_paging(page, supp_id, stock_status, records);
        if ($.type(callback) === 'function') {
            callback();
        }
    }, "json");
}

function load_vehicle_table_local(page, callback) {
    //@Sampath 
    var supp_id = $('#cmb_supp').val();
    var stock_status = $('#cmb_stock_status').val();
    var records = $('#page_records').val();
    var tableData = '';
    if (page === undefined || isNaN(parseInt(page)) || parseInt(page) <= 0) {
        page = 1;
    }
    $.post("views/loadTables.php", {table: "load_view_vehicle_tbl", supp_id: supp_id, stock_status: stock_status, page: page, records: records}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="22" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.view_vh_table tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
//                qData.color_group

                index++;
                tableData += '<tr ';
                if (qData.color_group != null && qData.color_group.length > 0) {
                    tableData += ' style="background-color:#' + qData.color_group + ';"';
                }
                tableData += '>';
                tableData += '<td>';
                tableData += '<div class="btn-group">' +
                        '<button type="button" class="btn btn-custom-save btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>' +
                        '<ul class="dropdown-menu">' +
                        '<li class="veiw_details_ex" value="' + qData.vh_id + '"data-toggle="tooltip" data-placement="bottom" title="View this vehicle"><a href="#">View</a></li>' +
                        '<li class="sel_order_id" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="bottom" title="Edit this vehicle"><a href="#">Edit</a></li>' +
                        '<li class="sell_vh" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="bottom" title="Sales & Payments"><a href="#">Sales & Payments</a></li></ul></div>';
                //'<li role="separator" class="divider"></li>' +
                //'<li data-toggle="modal" data-target="#vh_actionsModal" id="btn_action" data-toggle="tooltip" data-placement="bottom" title="Perform actions on selected vehicles"><a href="#">Other Actions...</a></li></ul></div>';

//                tableData += '<div class="btn-group"><button class="btn btn-custom-light btn-xs sel_order_id" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="bottom" title="Edit Vehicle"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>'
//                        + '<button class="btn btn-custom-save btn-xs veiw_details_ex" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="bottom" title="View Details"><i class="fa fa-external-link"></i>&nbsp;</button></div>';
                tableData += '</td>';
                tableData += '<td><input type="checkbox" class="checkBX" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="top" title="Select Record">&nbsp;</td>';
                tableData += '<td>' + qData.vh_index_num + '</td>';
//                tableData += '<td>' + qData.supp_name + '</td>';
                tableData += '<td>' + qData.vh_code + '</td>';
                tableData += '<td>' + qData.supp_name + '</td>';
                tableData += '<td>' + qData.maker_name + '</td>';
                tableData += '<td>' + qData.mod_name + '</td>';
                tableData += '<td>' + qData.vh_chassis_code + '</td>';
                tableData += '<td>' + qData.vh_chassis_num + '</td>';
//                tableData += '<td>' + qData.engine_code + '</td>';
//                tableData += '<td>' + qData.engine_num + '</td>';
                tableData += '<td>' + qData.engine_cc + '</td>';
                tableData += '<td>' + qData.package + '</td>';
                tableData += '<td>' + qData.vh_year + '</td>';
                tableData += '<td>' + qData.vh_color + '</td>';
                tableData += '<td>' + qData.vh_milage + '</td>';
                tableData += '</tr>';
            });
            $('.view_vh_table tbody').html('').append(tableData);
            $('.sel_order_id').click(function () {
                load_vh_edit_local($(this).val());
            });
            $('.veiw_details_ex').click(function () {
                submitSingleDataByPost('vehicle_single_view.php', 'veh_id', $(this).val());
            });
            $('.sell_vh').click(function () {
                submitSingleDataByPost("vehicle_sell.php", "vh_id", $(this).val());
            });
        }
        load_vhview_paging(page, supp_id, stock_status, records);
        if ($.type(callback) === 'function') {
            callback();
        }
    }, "json");
}

function load_vhview_paging(page, supp_id, stock_status, records) {
    //@Sachith 
    var tableData = '';
    $.post("views/loadTables.php", {table: "view_vehicle_tbl_paging", stock_status: stock_status, supp_id: supp_id, records: records}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData = '';
            $('.vh_view_pg').html('').append(tableData);
        } else {
            var totpg = parseInt(e.tot_pg);
            if (totpg < 11) {
                for (i = 1; i <= totpg; i++) {
                    if (!isNaN(page) && parseInt(page) === i) {
                        tableData += '<button type="button" class="btn btn-custom-light disabled go_to_pg" value="' + i + '">' + i + '</button>';
                    } else {
                        tableData += '<button type="button" class="btn btn-custom-light go_to_pg" value="' + i + '">' + i + '</button>';
                    }
                }

            } else {
                var sel_page = parseInt(page);
                var prev_page = 1;
                var next_page = totpg;
                if ((sel_page - 3) > 1) {
                    prev_page = sel_page - 3;
                }
                if ((sel_page + 3) < totpg) {
                    next_page = sel_page + 3;
                }

                tableData += '<button type="button" class="btn btn-custom-light go_to_pg" value="' + 1 + '">First</button>';
                for (var i = prev_page; i <= next_page; i++) {
                    if (!isNaN(page) && parseInt(page) === i) {
                        tableData += '<button type="button" class="btn btn-custom-light disabled go_to_pg" style="width:36px;" value="' + i + '">' + i + '</button>';
                    } else {
                        tableData += '<button type="button" class="btn btn-custom-light go_to_pg" style="width:36px;" value="' + i + '">' + i + '</button>';
                    }
                }
                tableData += '<button type="button" class="btn btn-custom-light go_to_pg" value="' + totpg + '">Last</button>';

            }
            $('.vh_view_pg').html('').append(tableData);

            //UPDATE
            $('.go_to_pg').click(function () {
                load_vehicle_table($(this).val());
            });
        }
    }, "json");
}


function vehicle_keyword_search(callback) {
    //@Sampath 
    var search_entered = $('#txt_search_key').val();
    var key_arr = search_entered.split(" ");
    var supp_id = $('#cmb_supp').val();
    var stock_status = $('#cmb_stock_status').val();
    var tableData = '';
    if (key_arr.length > 0) {
//        if (page === undefined || isNaN(parseInt(page)) || parseInt(page) <= 0) {
//            page = 1;
//        }

        $.post("views/loadTables.php", {table: "view_vehicle_keyword_search", key_arr: key_arr}, function (e) {
            if (e === undefined || e.length === 0 || e === null) {
                tableData += '<tr><th colspan="22" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
                $('.view_vh_table tbody').html('').append(tableData);
            } else {
                $.each(e, function (index, qData) {
                    index++;
                    tableData += '<tr>';
                    tableData += '<td><div class="btn-group"><button class="btn btn-custom-light btn-xs sel_order_id" value="' + qData.vh_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>'
                            + '<button class="btn btn-custom-save btn-xs veiw_details_ex" value="' + qData.vh_id + '"><i class="fa fa-external-link"></i>&nbsp;</button></div></td>';
                    tableData += '<td><input type="checkbox" value="' + qData.vh_id + '">&nbsp;</td>';
                    tableData += '<td>' + qData.vh_index_num + '</td>';
//                tableData += '<td>' + qData.supp_name + '</td>';
                    tableData += '<td>' + qData.vh_code + '</td>';
                    tableData += '<td>' + qData.supp_name + '</td>';
                    tableData += '<td>' + qData.maker_name + '</td>';
                    tableData += '<td>' + qData.mod_name + '</td>';
                    tableData += '<td>' + qData.vh_chassis_code + '</td>';
                    tableData += '<td>' + qData.vh_chassis_num + '</td>';
                    tableData += '<td>' + qData.engine_code + '</td>';
                    tableData += '<td>' + qData.engine_num + '</td>';
                    tableData += '<td>' + qData.engine_cc + '</td>';
                    tableData += '<td>' + qData.package + '</td>';
                    tableData += '<td>' + qData.vh_year + '</td>';
                    tableData += '<td>' + qData.vh_color + '</td>';
                    tableData += '<td>' + qData.vh_milage + '</td>';
                    tableData += '<td>' + qData.vh_options + '</td>';
                    tableData += '<td>' + qData.additional_options + '</td>';
                    tableData += '<td>' + qData.bid_date + '</td>';
                    tableData += '<td>' + qData.auction_name + '</td>';
                    tableData += '<td>' + qData.auction_grade + '</td>';
//                tableData += '<td>' + qData.lot_no + '</td>';
//                tableData += '<td>' + qData.auc_display_price + '</td>';
//                tableData += '<td>' + qData.stock_location + '</td>';
//                    tableData += '<td>' + qData.short_name + '</td>';
                    tableData += '</tr>';
                });
                $('.view_vh_table tbody').html('').append(tableData);

                // TABLE ACTION BUTTONS
                //SELECT
                $('.sel_order_id').click(function () {
                    load_vh_edit($(this).val());
                });
                $('.veiw_details_ex').click(function () {
                    submitSingleDataByPost('vehicle_single_view.php', 'veh_id', $(this).val());
                });
                //DELETE
                $('.del_maker').click(function () {
                });
            }
            $('.vh_view_pg').html('');
            if ($.type(callback) === 'function') {
                callback();
            }
        }, "json");

    } else {
        alertify.error("Enter keywords", 2000);
    }
}
function vehicle_keyword_search_local(callback) {
    //@Sampath 
    var search_entered = $('#txt_search_key').val();
    var key_arr = search_entered.split(" ");
    var supp_id = $('#cmb_supp').val();
    var stock_status = $('#cmb_stock_status').val();
    var tableData = '';
    if (key_arr.length > 0) {
//        if (page === undefined || isNaN(parseInt(page)) || parseInt(page) <= 0) {
//            page = 1;
//        }

        $.post("views/loadTables.php", {table: "view_vehicle_keyword_search", key_arr: key_arr}, function (e) {
            if (e === undefined || e.length === 0 || e === null) {
                tableData += '<tr><th colspan="22" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
                $('.view_vh_table tbody').html('').append(tableData);
            } else {
                $.each(e, function (index, qData) {
                    index++;
                    tableData += '<tr>';
                    tableData += '<td><div class="btn-group">' +
                            '<button type="button" class="btn btn-custom-save btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>' +
                            '<ul class="dropdown-menu">' +
                            '<li class="veiw_details_ex" value="' + qData.vh_id + '"data-toggle="tooltip" data-placement="bottom" title="View this vehicle"><a href="#">View</a></li>' +
                            '<li class="sel_order_id" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="bottom" title="Edit this vehicle"><a href="#">Edit</a></li>' +
                            '<li class="sell_vh" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="bottom" title="Sales & Payments"><a href="#">Sales & Payments</a></li></ul></div></td>';

//                    tableData += '<td><div class="btn-group"><button class="btn btn-custom-light btn-xs sel_order_id" value="' + qData.vh_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>'
//                            + '<button class="btn btn-custom-save btn-xs veiw_details_ex" value="' + qData.vh_id + '"><i class="fa fa-external-link"></i>&nbsp;</button></div></td>';
                    tableData += '<td><input type="checkbox" value="' + qData.vh_id + '">&nbsp;</td>';
                    tableData += '<td>' + qData.vh_index_num + '</td>';
//                tableData += '<td>' + qData.supp_name + '</td>';
                    tableData += '<td>' + qData.vh_code + '</td>';
                    tableData += '<td>' + qData.supp_name + '</td>';
                    tableData += '<td>' + qData.maker_name + '</td>';
                    tableData += '<td>' + qData.mod_name + '</td>';
                    tableData += '<td>' + qData.vh_chassis_code + '</td>';
                    tableData += '<td>' + qData.vh_chassis_num + '</td>';
//                    tableData += '<td>' + qData.engine_code + '</td>';
//                    tableData += '<td>' + qData.engine_num + '</td>';
                    tableData += '<td>' + qData.engine_cc + '</td>';
                    tableData += '<td>' + qData.package + '</td>';
                    tableData += '<td>' + qData.vh_year + '</td>';
                    tableData += '<td>' + qData.vh_color + '</td>';
                    tableData += '<td>' + qData.vh_milage + '</td>';
                    tableData += '</tr>';
                });
                $('.view_vh_table tbody').html('').append(tableData);

                // TABLE ACTION BUTTONS
                //SELECT
                $('.sel_order_id').click(function () {
//                    load_vh_edit($(this).val());
                    load_vh_edit_local($(this).val());
                });
                $('.veiw_details_ex').click(function () {
                    submitSingleDataByPost('vehicle_single_view.php', 'veh_id', $(this).val());
                });
                //DELETE
                $('.del_maker').click(function () {
                });
            }
            $('.vh_view_pg').html('');
            if ($.type(callback) === 'function') {
                callback();
            }
        }, "json");

    } else {
        alertify.error("Enter keywords", 2000);
    }
}
// ************** image galary load by V!rj
function veh_imageload_galary(vehicleID) {
//    alert(vehicleID);
    var galaryData = '';
    $.post("views/loadTables.php", {galary: "veh_imageload_galary", vehicleID: vehicleID}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            galaryData += '<h3>No images available<h3>';
        } else {
            $.each(e, function (index, qData) {
                var visible = parseInt(qData.p_visible);
                galaryData += '<div class="thumbnail thumbnail-custom">';
                galaryData += '<img src="vehicle_img/' + qData.vh_code + '_' + vehicleID + '/' + qData.file_3 + '" alt="" />';
                galaryData += '<div class="caption">';
                if (visible === 1) {
                    galaryData += '<label class="checkbox checkbox-inline"><input type="checkbox" class="imgCheck" data-picId="' + qData.ph_id + '" value="' + qData.ph_id + '" checked="" /> Visible</label>';
                } else {
                    galaryData += '<label class="checkbox checkbox-inline"><input type="checkbox" class="imgCheck" data-picId="' + qData.ph_id + '" value="' + qData.ph_id + '" /> Visible</label>';
                }
                galaryData += '<button class="btn btn-sm btn-danger pull-right img_dlt_btn" type="button" data-vh_id="' + vehicleID + '" data-ph_id="' + qData.ph_id + '"><i class="fa fa-trash-o"></i></button>';
                galaryData += '</div>';
                galaryData += '</div>';
            });
            //****** delete selected image********//
        }
        $('#image_galary').html(galaryData);
    }, "json");
}

function load_vh_edit(vh_id) {
    var win = window.open('vehicle_reg.php?vh_id=' + vh_id, '_blank');
    win.focus();
}

function load_vh_edit_local(vh_id) {
    var win = window.open('vehicle_reg_local.php?vh_id=' + vh_id, '_blank');
    win.focus();
}
function search_cust(text, callBack) {
    var tableData = '';
    $.post("views/loadTables.php", {table: 'customer_search_res', text: text}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.cus_search_result tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.cus_inv_name + '</td>';
                tableData += '<td>' + qData.cus_address + '</td>';
                tableData += '<td>' + qData.cus_phone1 + '</td>';
                tableData += '<td>' + qData.cus_phone2 + '</td>';
                tableData += '<td>' + qData.cus_email1 + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_found_cust" value="' + qData.cus_id + '"><i class="fa fa-hand-o-up fa-lg"></i>&nbsp;Select</button></div></td>';
                tableData += '</tr>';
            });
            $('.cus_search_result tbody').html('').append(tableData);
            $('.sel_found_cust').click(function () {
                $('.customer_ComboBox').val($(this).val());
                kitz_select_costomer($(this).val());
                $('#cus_searchModal').modal('hide');
                chosenRefresh();
            });

        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, 'json');
}
function search_cust_local(text, callBack) {
    var tableData = '';
    $.post("views/loadTables.php", {table: 'customer_search_res', text: text}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.cus_search_result tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.cus_inv_name + '</td>';
                tableData += '<td>' + qData.cus_address + '</td>';
                tableData += '<td>' + qData.cus_phone1 + '</td>';
                tableData += '<td>' + qData.cus_phone2 + '</td>';
                tableData += '<td>' + qData.cus_email1 + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_found_cust" value="' + qData.cus_id + '"><i class="fa fa-hand-o-up fa-lg"></i>&nbsp;Select</button></div></td>';
                tableData += '</tr>';
            });
            $('.cus_search_result tbody').html('').append(tableData);
            $('.sel_found_cust').click(function () {
                $('.customer_ComboBox').val($(this).val());
                sam_select_costomer_local($(this).val());
                $('#cus_searchModal').modal('hide');
                chosenRefresh();
            });

        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, 'json');
}
function search_cust_proInv(text, callBack) {
    var tableData = '';
    $.post("views/loadTables.php", {table: 'customer_search_res', text: text}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.cus_search_result tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.cus_inv_name + '</td>';
                tableData += '<td>' + qData.cus_address + '</td>';
                tableData += '<td>' + qData.cus_phone1 + '</td>';
                tableData += '<td>' + qData.cus_phone2 + '</td>';
                tableData += '<td>' + qData.cus_email1 + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_found_cust" value="' + qData.cus_id + '"><i class="fa fa-hand-o-up fa-lg"></i>&nbsp;Select</button></div></td>';
                tableData += '</tr>';
            });
            $('.cus_search_result tbody').html('').append(tableData);
            $('.sel_found_cust').click(function () {
//                $('.customer_ComboBox').val($(this).val());
                select_customer_consignee($(this).val());
                $('#cus_searchModal').modal('hide');
//                chosenRefresh();
            });

        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, 'json');
}
function search_cust_proInv_local(text, callBack) {
    var tableData = '';
    $.post("views/loadTables.php", {table: 'customer_search_res', text: text}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.cus_search_result tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.cus_inv_name + '</td>';
                tableData += '<td>' + qData.cus_address + '</td>';
                tableData += '<td>' + qData.cus_phone1 + '</td>';
                tableData += '<td>' + qData.cus_phone2 + '</td>';
                tableData += '<td>' + qData.cus_email1 + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_found_cust" value="' + qData.cus_id + '"><i class="fa fa-hand-o-up fa-lg"></i>&nbsp;Select</button></div></td>';
                tableData += '</tr>';
            });
            $('.cus_search_result tbody').html('').append(tableData);
            $('.sel_found_cust').click(function () {
//                $('.customer_ComboBox').val($(this).val());
                select_customer_consignee($(this).val());
                $('#cus_searchModal').modal('hide');
//                chosenRefresh();
            });

        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, 'json');
}

function search_vehicle(callBack) {
    var tableData = '';
    $.post("views/loadTables.php", {table: 'vh_search_res'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.vh_search_result tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.vh_code + '</td>';
                tableData += '<td>' + qData.maker_name + '</td>';
                tableData += '<td>' + qData.mod_name + '</td>';
                tableData += '<td>' + qData.vh_chassis_code + '-' + qData.vh_chassis_num + '</td>';
                tableData += '<td>' + qData.vh_color + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_found_vh" value="' + qData.vh_id + '"><i class="fa fa-hand-o-up fa-lg"></i>&nbsp;Select</button></div></td>';
                tableData += '</tr>';
            });
            $('.vh_search_result tbody').html('').append(tableData);
            $('.sel_found_vh').click(function () {
                $('.vahicle_code_combo').val($(this).val());
                $('#vh_searchModal').modal('hide');
                chosenRefresh();
            });

        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, 'json');
}

function search_vehicle2(param, callBack) {
    var vh_maker = param.maker;
    var vh_model = param.model;
    var tableData = '';
    $.post("views/loadTables.php", {table: 'vh_search_filtered', vh_maker: vh_maker, vh_model: vh_model}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
//            $('.vh_search_result tbody').html('').append(tableData);
            $('.vh_search_result tbody').html(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.vh_code + '</td>';
                tableData += '<td>' + qData.maker_name + '</td>';
                tableData += '<td>' + qData.mod_name + '</td>';
                tableData += '<td>' + qData.vh_chassis_code + '-' + qData.vh_chassis_num + '</td>';
                tableData += '<td>' + qData.vh_color + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_found_vh" value="' + qData.vh_id + '"><i class="fa fa-hand-o-up fa-lg"></i>&nbsp;Select</button></div></td>';
                tableData += '</tr>';
            });
            $('.vh_search_result tbody').html(tableData);
//            $('.vh_search_result tbody').html('').append(tableData);
            $('.sel_found_vh').click(function () {
                $('.vahicle_code_combo_filtered').val($(this).val());
                chosenRefresh();
            });

        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, 'json');
}

function load_PI_vehicle_table(ref_id, callback) {
    var tableData = '';
    $.post("views/loadTables.php", {table: "load_proinv_vehicle_tbl", ref_id: ref_id}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="18" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.proinv_vh_table tbody').html('').append(tableData);
        } else {
            var tot = 0;
            var units = 0;
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-light btn-xs sel_inv_vh data-toggle="modal" data-target="#vh_chargesModal" value="' + qData.pi_entry_id + '">FOB</button></div></td>';
                tableData += '<td>' + qData.vh_code + '</td>';
                tableData += '<td>' + qData.maker_name + '</td>';
                tableData += '<td>' + qData.mod_name + '</td>';
                tableData += '<td>' + qData.vh_chassis_code + qData.vh_chassis_num + '</td>';
//                tableData += '<td>' + qData.engine_code + qData.engine_num +'</td>';
                tableData += '<td>' + qData.engine_cc + '</td>';
                tableData += '<td>' + qData.vh_year + '</td>';
                tableData += '<td>' + qData.tot_amt + '</td>';
                tableData += '</tr>';
                tot += parseFloat(qData.tot_amt);
                if (index === 1) {
                    invnum = 'PI-' + qData.vh_code;
                    $('#proinv_num').val(invnum);
                }
                units++;
            });
            tableData += '<tr><td colspan="5">Total</td><td>' + units + '</td><td>Units</td><td>' + tot + '</td></tr>';
            $('.proinv_vh_table tbody').html('').append(tableData);
            $('#tot_cif').val(tot);
            if (units === 1) {
                $('#is_one_vh').val('1');
            } else {
                $('#is_one_vh').val(units);
            }
            // TABLE ACTION BUTTONS
            //SELECT
            $('.sel_inv_vh').click(function () {
                $('#pi_entry_id').val($(this).val());
                $('#vh_amount').modal('show');
//                load_vh_edit($(this).val());
            });
            //DELETE
            $('.del_maker').click(function () {
//                delete_coordinator($(this).val());
            });
        }
        if ($.type(callback) === 'function') {
            callback();
        }
    }, "json");
}

function bankTable() {
    var tableData = '';
    $.post("views/loadTables.php", {table: "load_supp_bank_tbl"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="5" class="alert alert-warning text-center"> -- No Data Found-- </th></tr>';
            $('.bank_tbl tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td style="text-align: center">' + data.bank_name + '</td>';
                tableData += '<td style="text-align: center">' + data.swift + '</td>';
                tableData += '<td style="text-align: center">' + data.branch + '</td>';
                tableData += '<td style="text-align: center">' + data.ac_num + '</td>';
                tableData += '<td style="text-align: center"><div>' +
                        '<button class="btn btn-custom-save bank_sel" value="' + data.bank_id + '"><i class="fa fa-hand-o-up fa-sm"></i>&nbsp;</button>' +
                        '<button class="btn btn-custom-light bank_upd" value="' + data.bank_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>' +
                        '<button class="btn btn-custom-light bank_del" value="' + data.bank_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;</button>' +
                        '</div></td>';
                tableData += '</tr>';
            });
            $('.bank_tbl tbody').html('').append(tableData);

            $('.bank_sel').click(function () {
                var bank_id = $(this).val();
                get_selected_bank(bank_id);
            });
            $('.bank_upd').click(function () {
                var modific_up = $(this).val();
                show_bank_btn();
                select_bank_update(modific_up);
            });
            $('.bank_del').click(function () {
                delete_supp_bank($(this).val());
            });
        }

    }, "json");
}

function leaseCoTable() {
    var tableData = '';
    $.post("views/loadTables.php", {table: "load_lease_co_tbl"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="5" class="alert alert-warning text-center"> -- No Data Found-- </th></tr>';
            $('.leasing_co_tbl tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td style="text-align: center">' + data.ls_name + '</td>';
                tableData += '<td style="text-align: center">' + data.ls_address + '</td>';
                tableData += '<td style="text-align: center"><div>' +
                        '<button class="btn btn-custom-save co_sel" value="' + data.ls_id + '"><i class="fa fa-hand-o-up fa-sm"></i>&nbsp;</button>' +
                        '<button class="btn btn-custom-light co_upd" value="' + data.ls_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>' +
                        '<button class="btn btn-custom-light co_del" value="' + data.ls_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;</button>' +
                        '</div></td>';
                tableData += '</tr>';
            });
            $('.leasing_co_tbl tbody').html('').append(tableData);

            $('.co_sel').click(function () {
                var co_id = $(this).val();
                get_selected_lease(co_id);
            });
            $('.co_upd').click(function () {
                var modific_up = $(this).val();
                show_lease_btn();
                select_leaseCo_update(modific_up);
            });

            $('.co_del').click(function () {
                delete_leaseCo($(this).val());
            });
        }

    }, "json");
}

function leaseCoTable_local() {
    var tableData = '';
    $.post("views/loadTables.php", {table: "load_lease_co_tbl"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="5" class="alert alert-warning text-center"> -- No Data Found-- </th></tr>';
            $('.leasing_co_tbl tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td style="text-align: center">' + data.ls_name + '</td>';
                tableData += '<td style="text-align: center">' + data.ls_address + '</td>';
                tableData += '<td style="text-align: center"><div>' +
                        '<button class="btn btn-custom-save" id="sel_leaseComp" value="' + data.ls_id + '"><i class="fa fa-hand-o-up fa-sm"></i>&nbsp;</button>' +
                        '<button class="btn btn-custom-light co_upd" value="' + data.ls_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>' +
                        '<button class="btn btn-custom-light co_del" value="' + data.ls_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;</button>' +
                        '</div></td>';
                tableData += '</tr>';
            });
            $('.leasing_co_tbl tbody').html('').append(tableData);

            $('.co_upd').click(function () {
                var modific_up = $(this).val();
                show_lease_btn();
                select_leaseCo_update(modific_up);
            });

            $('.co_del').click(function () {
                delete_leaseCo($(this).val());
            });
        }

    }, "json");
}

function test_tbl_filter() {
    $.post("views/loadTables.php", {table: 'load_view_vehicle_tbl2'}, function (e) {
//        alert('ok');
    }, "json");
}


function load_syscode_table(type_id) {
    //@Sachith 
    var tableData = '';
    $.post("views/loadTables.php", {table: "syscode_tbl", type_id: type_id}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="3" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.syscode_info_tbl tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td width="60%">' + qData.description + '</td>';
                tableData += '<td width="60%">' + qData.remarks + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_syscode" value="' + qData.sys_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;Edit</button><button class="btn btn-custom-light del_syscode" value="' + qData.sys_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</button></div></td>';
                tableData += '</tr>';
            });
            $('.syscode_info_tbl tbody').html('').append(tableData);
            // TABLE ACTION BUTTONS
            //UPDATE
            $('.sel_syscode').click(function () {
                select_syscode($(this).val());
            });
//            //DELETE
            $('.del_syscode').click(function () {
                delete_syscode($(this).val());
            });
        }
    }, "json");
}
function load_vh_features_table() {
    //@Sachith 
    var tableData = '';
    $.post("views/loadTables.php", {table: "web_vh_feauture_list", type_id: '30'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><td colspan="3" class="text-center"> -- No Data Found -- </td></tr>';
            $('.features_table tbody').html('').append(tableData);
        } else {
//            $.each(e, function (index, qData) {
//                index++;
//                tableData += '<tr>';
//                tableData += '<td><label><input type="checkbox" value=""/>' + qData.description + '</label></td>';
//                tableData += '</tr>';
//            });
            $('.features_table tbody').append(e);
        }
    }, "html");
}

function load_web_homepg_data(section) {
    //@Sachith 
    var tableData = '';
    $.post("views/loadTables.php", {table: "tbl_web_homepg", section: section}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="3" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.web_homepg_content tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.wh_head1 + '</td>';
                tableData += '<td><img style="max-height: 50px;" src="./images/web/' + qData.wh_image + '"/></td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_content" value="' + qData.wh_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;Edit</button><button data-imgfile="' + qData.wh_image + '" class="btn btn-custom-light del_content" value="' + qData.wh_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</button></div></td>';
                tableData += '</tr>';
            });
            $('.web_homepg_content tbody').html('').append(tableData);

            // TABLE ACTION BUTTONS
            //UPDATE
            $('.sel_content').click(function () {
                select_homepg_content($(this).val());
            });
            //DELETE
            $('.del_content').click(function () {
                $(this).data("imgfile");
                delete_web_homepg($(this).val(), $(this).data("imgfile"));


            });
        }
    }, "json");
}

function spec_table() {
    var tableData = '';
    var model_id = $('.model_ComboBox').val();
    $.post("views/loadTables.php", {table: "vehicle_spec_table", model_id: model_id}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="9" class="alert alert-warning text-center"> -- No Data Found-- </th></tr>';
            $('.spec_info_table tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + data.spec_title + '</td>';
                tableData += '<td >' + data.eng_cc + '</td>';
                tableData += '<td>' + data.eng_rpm + '</td>';
                tableData += '<td>' + data.perf_max_speed + '</td>';
                tableData += '<td>' + data.trans_type + '</td>';
                tableData += '<td>' + data.fuel_cons_highway + '</td>';
                tableData += '<td>' + data.bd_curb_weight + '</td>';
                tableData += '<td>' + data.cap_fuel_tank + '</td>';
                tableData += '<td><div>' +
                        '<button class="btn btn-custom-save spec_sel" value="' + data.spec_id + '"><i class="fa fa-hand-o-up fa-sm"></i>&nbsp;</button>' +
                        '<button class="btn btn-custom-light spec_del" value="' + data.spec_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;</button>' +
                        '</div></td>';
                tableData += '</tr>';
            });
            $('.spec_info_table tbody').html('').append(tableData);

            $('.spec_sel').click(function () {
                var spec_id = $(this).val();
                select_spec(spec_id);
                spec_showTabOne();
            });
            $('.spec_del').click(function () {
                var spec_id = $(this).val();
                delete_spec(spec_id);
            });
        }

    }, "json");
}

function sendWeb_selectedVh(idlist) {
    var tableData = '';
    $.post("views/loadTables.php", {table: "sendWeb_selectedVh", idlist: idlist}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="9" class="alert alert-warning text-center"> -- No Data Found-- </th></tr>';
            $('#send_web_selected tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + data.vh_code + '</td>';
                tableData += '<td >' + data.mod_name + '</td>';
                tableData += '<td>' + data.package + '</td>';
                tableData += '<td>' + data.vh_year + '</td>';
                tableData += '<td>' + data.vh_color + '</td>';
                tableData += '<td><div>' +
                        '<button class="btn btn-custom-save btn_sel" data-vhcode="' + data.vh_code + '" data-model="' + data.mod_id + '" value="' + data.vh_id + '"><i class="fa fa-hand-o-up fa-sm"></i>&nbsp;</button>' +
                        '</div></td>';
                tableData += '</tr>';
            });
            $('#send_web_selected tbody').html('').append(tableData);

            $('.btn_sel').click(function () {
                $('#vh_id').val($(this).val());
                $('#v_code_num').val($(this).data('vhcode'));
                $('.currency').html($('.cmb_currency').val());
                load_spec_list($(this).data('model'));
                select_vh_web_data($(this).val());
            });

        }

    }, "json");
}

function vh_inweb() {
    var tableData = '';
    $.post("views/loadTables.php", {table: "vh_inweb"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="7" class="alert alert-warning text-center"> -- No Data Found-- </th></tr>';
            $('.tbl_vh_web tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + data.vh_code + '</td>';
                tableData += '<td >' + data.mod_name + '</td>';
                tableData += '<td>' + data.vh_chassis + '</td>';
                tableData += '<td>' + data.vh_year + '</td>';
                tableData += '<td>' + data.vh_color + '</td>';
                tableData += '<td><div>' +
                        '<button class="btn btn-custom-save btn_sel" data-vhcode="' + data.vh_code + '" data-model="' + data.mod_id + '" data-toggle="tooltip" data-placement="bottom" title="Select Record" value="' + data.vh_id + '"><i class="fa fa-hand-o-up fa-sm"></i>&nbsp;</button>' +
                        '<button class="btn btn-custom-light btn_del" data-vhcode="' + data.vh_code + '" data-model="' + data.mod_id + '" data-toggle="tooltip" data-placement="bottom" title="Delete Record" value="' + data.vh_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;</button>' +
                        '</div></td>';
                tableData += '</tr>';
            });
            $('.tbl_vh_web tbody').html('').append(tableData);

            $('.btn_sel').click(function () {
                $('#vh_id').val($(this).val());
                $('#v_code_num').val($(this).data('vhcode'));
//                $('.currency').html($('.cmb_currency').val());
                load_spec_list($(this).data('model'));
                select_vh_web_data($(this).val());
            });
            $('.btn_del').click(function () {
                delete_vh_webdata($(this).val());
            });
        }
    }, "json");
}

function newsDetailsTable() {
    //@Cholitha
    var tableData = '';
    $.post("views/loadTables.php", {table: "news_details_tbl"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="3" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.newsDetailsTable tbody').html('').append(tableData);
        } else {

            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.posted_date + '</td>';
                tableData += '<td>' + qData.heading_1 + '</td>';
                tableData += '<td><img height="80px" src="./images/web_news/' + qData.image + '"/></td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_news" value="' + qData.news_id + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;Edit</button><button class="btn btn-custom-light del_news" data-imgfile="' + qData.image + '" value="' + qData.news_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</button></div></td>';
                tableData += '</tr>';
            });
            $('.newsDetailsTable tbody').html('').append(tableData);
            // TABLE ACTION BUTTONS
            //UPDATE
            $('.sel_news').click(function () {
                select_news($(this).val());
            });
//            //DELETE
            $('.del_news').click(function () {
                delete_news($(this).val(), $(this).data("imgfile"));
            });
        }
    }, "json");
}

function vh_group_tbl() {
    var tableData = '';
    $.post("views/loadTables.php", {table: "load_vh_group_tbl"}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="2" class="alert alert-warning text-center"> -- No Data Found-- </th></tr>';
            $('.vh_group_tbl tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td style="text-align: center">' + data.vh_group + '</td>';
                tableData += '<td style="text-align: center"><div>' +
                        '<button class="btn btn-custom-light gr_upd" value="' + data.vh_group + '"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>' +
                        '<button class="btn btn-custom-light gr_sel" value="' + data.vh_group + '"><i class="fa fa-hand-o-up fa-sm"></i>&nbsp;</button>' +
                        '<button class="btn btn-custom-light gr_del" value="' + data.vh_group + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;</button>' +
                        '</div></td>';
                tableData += '</tr>';
            });
            $('.vh_group_tbl tbody').html('').append(tableData);

            $('.gr_upd').click(function () {
                show_group_btn();
                $('#group_name').val($(this).val());
                $('#group_name_pre').val($(this).val());
            });
            $('.gr_sel').click(function () {
                $('#group_name_pre').val('');
                hide_group_btn();
                $('#group_name').val($(this).val());

            });
            $('.gr_del').click(function () {
//                delete_supp_bank($(this).val());
            });
        }

    }, "json");
}

function properties_selectedVh(idlist) {
    var tableData = '';
    $.post("views/loadTables.php", {table: "sendWeb_selectedVh", idlist: idlist}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Data Found-- </th></tr>';
            $('#properties_selected_tbl tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, data) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + data.vh_code + '</td>';
                tableData += '<td >' + data.mod_name + '</td>';
                tableData += '<td>' + data.package + '</td>';
                tableData += '<td>' + data.vh_year + '</td>';
                tableData += '<td>' + data.vh_color + '</td>';
                tableData += '<td><div>' +
                        '<button class="btn btn-custom-save btn_sel" data-vhcode="' + data.vh_code + '" data-model="' + data.mod_id + '" value="' + data.vh_id + '"><i class="fa fa-hand-o-up fa-sm"></i>&nbsp;</button>' +
                        '</div></td>';
                tableData += '</tr>';
            });
            $('#properties_selected_tbl tbody').html('').append(tableData);

            $('.btn_sel').click(function () {
                properties_select_vehicle($(this).val());
            });
            $('.btn_del').click(function () {
//                var spec_id = $(this).val();
//                delete_spec(spec_id);
            });
        }

    }, "json");
}

function exvh_search_result(text, callBack) {
    var tableData = '';
    $.post("views/loadTables.php", {table: 'exvh_search_result', text: text}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.exvh_search_result tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.vh_code + '</td>';
                tableData += '<td>' + qData.maker_name + '</td>';
                tableData += '<td>' + qData.mod_name + '</td>';
                tableData += '<td>' + qData.vh_chassis + '</td>';
                tableData += '<td><div class="btn-group"><button class="btn btn-custom-save sel_exvh" value="' + qData.vh_id + '"><i class="fa fa-hand-o-up fa-lg"></i>&nbsp;Select</button></div></td>';
                tableData += '</tr>';
            });
            $('.exvh_search_result tbody').html('').append(tableData);
            $('.sel_exvh').click(function () {
                select_exch_vehi_local($(this).val());
                $('#exvh_searchModal').modal('hide');
            });

        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, 'json');
}

function vh_payments(vh_id, callBack) {
    var tableData = '';
    $.post("views/loadTables.php", {table: 'vh_payments', vh_id: vh_id}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="6" class="alert alert-warning text-center"> -- No Payments Found -- </th></tr>';
            $('.vh_payments tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
                index++;
                tableData += '<tr>';
                tableData += '<td>' + qData.pay_date + '</td>';
                tableData += '<td>' + qData.pay_method + '</td>';
                tableData += '<td>' + qData.pay_category + '</td>';
                tableData += '<td style="text-align:right;">' + Number(qData.in_amount).toFixed(2) + '</td>';
                tableData += '<td>' + qData.bank_account + '</td>';
                if (parseInt(qData.pay_confirmed) === 1) {
                    tableData += '<td style="text-align:center;"><span><i class="fa fa-check"></i></span>' + '</td>';
                } else if (parseInt(qData.pay_confirmed) === 0) {
                    tableData += '<td style="text-align:center;"><span><i class="fa fa-clock-o"></i></span>' + '</td>';
                } else {
                    tableData += '<td style="text-align:center;"><span><i class="fa fa-times"></i></span>' + '</td>';
                }
                tableData += '<td><div class="btn-group">' +
//                '<button class="btn btn-custom-save sel_payment" value="' + qData.vp_id + '"><i class="fa fa-hand-o-up fa-lg"></i>&nbsp;Select</button>'+
                        '<button class="btn btn-custom-light cancel_payment" value="' + qData.vp_id + '"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Cancel</button>' +
                        '</div></td>';
                tableData += '</tr>';
            });
            $('.vh_payments tbody').html('').append(tableData);
            $('.cancel_payment').click(function () {
                cancel_vh_payment_local($(this).val());
            });

        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, 'json');
}

function load_clearing_table(page, callback) {
    //@Ashan
    var supp_id = $('#cmb_supp').val();
    var stock_status = $('#cmb_stock_status').val();
    var records = $('#page_records').val();
    var tableData = '';
    if (page === undefined || isNaN(parseInt(page)) || parseInt(page) <= 0) {
        page = 1;
    }
    $.post("views/loadTables.php", {table: "load_view_clearing_tbl", supp_id: supp_id, stock_status: stock_status, page: page, records: records}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            tableData += '<tr><th colspan="22" class="alert alert-warning text-center"> -- No Data Found -- </th></tr>';
            $('.view_vh_table tbody').html('').append(tableData);
        } else {
            $.each(e, function (index, qData) {
//                qData.color_group

                index++;
                tableData += '<tr ';
                if (qData.color_group != null && qData.color_group.length > 0) {
                    tableData += ' style="background-color:#' + qData.color_group + ';"';
                }
                tableData += '>';
                tableData += '<td>';
                tableData += '<div class="btn-group"><button class="btn btn-custom-light btn-xs sel_order_id" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="bottom" title="Edit Vehicle"><i class="fa fa-pencil fa-sm"></i>&nbsp;</button>'
                        + '<button class="btn btn-custom-save btn-xs veiw_details_ex" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="bottom" title="View Details"><i class="fa fa-external-link"></i>&nbsp;</button></div>';
//                <button class="btn "> <i class="fa fa-external-link"></i></button>
                tableData += '</td>';
                tableData += '<td><input type="checkbox" class="checkBX" value="' + qData.vh_id + '" data-toggle="tooltip" data-placement="top" title="Select Record">&nbsp;</td>';
                tableData += '<td>' + qData.vh_index_num + '</td>';
//                tableData += '<td>' + qData.supp_name + '</td>';
                tableData += '<td>' + qData.vh_code + '</td>';
                tableData += '<td>' + qData.supp_name + '</td>';
                tableData += '<td>' + qData.maker_name + '</td>';
                tableData += '<td>' + qData.mod_name + '</td>';
                tableData += '<td>' + qData.vh_chassis_num + '</td>';
                tableData += '<td>' + qData.engine_cc + '</td>';
                tableData += '<td>' + ((qData.shipped_date==null) ? '-':qData.shipped_date) + '</td>';
                tableData += '<td>' + ((qData.vessel==null) ? '-':qData.vessel)+ '</td>';
                tableData += '<td>' + ((qData.refunds==null) ? '-':qData.refunds) + '</td>';
                tableData += '<td>' + ((qData.arrival_date==null) ? '-':qData.arrival_date) + '</td>';
                tableData += '<td>' + ((qData.document_status==null) ? '-':qData.docuemnt_status) + '</td>';
                tableData += '<td>' + ((qData.to_clr_agent==null) ? '-':qData.to_clr_agent) + '</td>';
                tableData += '<td>' + ((qData.duty==null) ? '-':qData.duty) + '</td>';
                tableData += '<td>' + ((qData.clr_date==null) ? '-':qData.clr_date) + '</td>';
                tableData += '<td>' + ((qData.transport_method==null) ? '-':qData.transport_method) + '</td>';
                tableData += '<td>' + ((qData.lc_no==null) ? '-':qData.lc_no) + '</td>';
//                tableData += '<td>' + qData.lot_no + '</td>';
//                tableData += '<td>' + qData.auc_display_price + '</td>';
//                tableData += '<td>' + qData.stock_location + '</td>';
//                tableData += '<td>' + qData.short_name + '</td>';
                tableData += '</tr>';
            });
            $('.view_vh_table tbody').html('').append(tableData);

            // TABLE ACTION BUTTONS
            //SELECT
            $('.sel_order_id').click(function () {
                load_vh_edit($(this).val());
            });
            //DETAILS
            $('.veiw_details_ex').click(function () {
                submitSingleDataByPost('vehicle_single_view.php', 'veh_id', $(this).val());
            });
            //DELETE
            $('.del_maker').click(function () {
            });
        }
        load_vhview_paging(page, supp_id, stock_status, records);
        if ($.type(callback) === 'function') {
            callback();
        }
    }, "json");
}