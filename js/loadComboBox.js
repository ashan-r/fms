
function load_makers_cmb(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'makers'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.maker_ComboBox').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.maker_id)) {
                        comboData += '<option value="' + qData.maker_id + '" selected>' + qData.maker_name + '</option>';
                    } else {
                        comboData += '<option value="' + qData.maker_id + '">' + qData.maker_name + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.maker_id + '">' + qData.maker_name + '</option>';
                }
            });
            $('.maker_ComboBox').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}


//// developed by viraj
function vahicle_code_combo(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'vahicle_code_combo'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.vahicle_code_combo').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.vh_id)) {
                        comboData += '<option value="' + qData.vh_id + '" selected>' + qData.vh_code + '</option>';
                    } else {
                        comboData += '<option value="' + qData.vh_id + '">' + qData.vh_code + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.vh_id + '">' + qData.vh_code + '</option>';
                }
            });
            $('.vahicle_code_combo').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}
function vehicle_code_latest(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'vehicle_code_latest'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.vahicle_code_combo').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.vh_id)) {
                        comboData += '<option value="' + qData.vh_id + '" selected>' + qData.vh_code + '</option>';
                    } else {
                        comboData += '<option value="' + qData.vh_id + '">' + qData.vh_code + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.vh_id + '">' + qData.vh_code + '</option>';
                }
            });
            $('.vahicle_code_combo').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}
function modification_statusCombo(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'modification_statusCombo'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.modification_statusCombo').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.description)) {
                        comboData += '<option value="' + qData.description + '" selected>' + qData.description + '</option>';
                    } else {
                        comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                }
            });
            $('.modification_statusCombo').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}


function load_coordinator_types(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'coordinator_category'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.coord_category').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (selected === qData.description) {
                        comboData += '<option value="' + qData.description + '" selected>' + qData.description + '</option>';
                    } else {
                        comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                }
            });
            $('.coord_category').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}
function load_fuel_types(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'fuel_types'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('#v_fuel').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (selected === qData.description) {
                        comboData += '<option value="' + qData.description + '" selected>' + qData.description + '</option>';
                    } else {
                        comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                }
            });
            $('#v_fuel').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}
function load_transmission_types(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'transmission_types'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('#v_trans').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (selected === qData.description) {
                        comboData += '<option value="' + qData.description + '" selected>' + qData.description + '</option>';
                    } else {
                        comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                }
            });
            $('#v_trans').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}
function load_drive_types(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'drive_types'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('#v_drive').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (selected === qData.description) {
                        comboData += '<option value="' + qData.description + '" selected>' + qData.description + '</option>';
                    } else {
                        comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                }
            });
            $('#v_drive').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}


function load_model_cmb(maker, selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'vehicle_model', maker: maker}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.model_ComboBox').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.mod_id)) {
                        comboData += '<option value="' + qData.mod_id + '" selected>' + qData.mod_name + '</option>';
                    } else {
                        comboData += '<option value="' + qData.mod_id + '">' + qData.mod_name + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.mod_id + '">' + qData.mod_name + '</option>';
                }
            });
            $('.model_ComboBox').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

function load_coordinator_cmb(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'cordinator_combo'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.coordinator_ComboBox').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.coordinator_id)) {
                        comboData += '<option value="' + qData.coordinator_id + '" selected>' + qData.coordinator_name + '</option>';
                    } else {
                        comboData += '<option value="' + qData.coordinator_id + '">' + qData.coordinator_name + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.coordinator_id + '">' + qData.coordinator_name + '</option>';
                }
            });
            $('.coordinator_ComboBox').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}
function load_coordinator_jp_cmb(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'cordinator_jp_combo'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.coordinator_ComboBox').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.coordinator_id)) {
                        comboData += '<option value="' + qData.coordinator_id + '" selected>' + qData.coordinator_name + '</option>';
                    } else {
                        comboData += '<option value="' + qData.coordinator_id + '">' + qData.coordinator_name + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.coordinator_id + '">' + qData.coordinator_name + '</option>';
                }
            });
            $('.coordinator_ComboBox').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}
function load_customer_cmb(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'customer_combo'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.customer_ComboBox').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.cus_id)) {
                        comboData += '<option value="' + qData.cus_id + '" selected>' + qData.cus_name + '</option>';
                    } else {
                        comboData += '<option value="' + qData.cus_id + '">' + qData.cus_name + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.cus_id + '">' + qData.cus_name + '</option>';
                }
            });
            $('.customer_ComboBox').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

function load_suppliers_cmb(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'supplier_combo'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.v_supplier').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.supp_id)) {
                        comboData += '<option value="' + qData.supp_id + '" selected>' + qData.supp_code + '</option>';
                    } else {
                        comboData += '<option value="' + qData.supp_id + '">' + qData.supp_code + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.supp_id + '">' + qData.supp_code + '</option>';
                }
            });
            $('.v_supplier').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

function load_suppliers_vhlist(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'supplier_combo'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('#cmb_supp').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.supp_id)) {
                        comboData += '<option value="' + qData.supp_id + '" selected>' + qData.supp_code + '</option>';
                    } else {
                        comboData += '<option value="' + qData.supp_id + '">' + qData.supp_code + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.supp_id + '">' + qData.supp_code + '</option>';
                }
            });
            comboData += '<option value="0">All</option>';
            $('#cmb_supp').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

function vehicle_code_filtered_combo(paramObj, callBack) {
    var comboData = '';

    var vh_maker = paramObj.maker;
    var vh_model = paramObj.model;
    $.post("views/loadComboBox.php", {comboBox: 'vehicle_code_combo_filtered', vh_maker: vh_maker, vh_model: vh_model}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('.vahicle_code_combo_filtered').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (vh_model !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(vh_model) === parseInt(qData.vh_id)) {
                        comboData += '<option value="' + qData.vh_id + '" selected>' + qData.vh_code + '</option>';
                    } else {
                        comboData += '<option value="' + qData.vh_id + '">' + qData.vh_code + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.vh_id + '">' + qData.vh_code + '</option>';
                }
            });
            $('.vahicle_code_combo_filtered').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

function load_vh_stock_types(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'vehicle_stock_status_types'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data-- </option>';
            $('#cmb_stock_status').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.code)) {
                        comboData += '<option value="' + qData.code + '" selected>' + qData.description + '</option>';
                    } else {
                        comboData += '<option value="' + qData.code + '">' + qData.description + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.code + '">' + qData.description + '</option>';
                }
            });
            comboData += '<option value="0">All</option>';
            $('#cmb_stock_status').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

function load_stock_type_edit(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'vehicle_stock_status_types'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data-- </option>';
            $('#cmb_stock_status').html('').append(comboData);
            chosenRefresh();
        } else {
            comboData += '<option value="99">Unchanged</option>';
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (parseInt(selected) === parseInt(qData.code)) {
                        comboData += '<option value="' + qData.code + '" selected>' + qData.description + '</option>';
                    } else {
                        comboData += '<option value="' + qData.code + '">' + qData.description + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.code + '">' + qData.description + '</option>';
                }
            });
            $('#cmb_stock_status').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}
function load_currency_types(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'currency_types'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('#sup_currency').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (selected === qData.description) {
                        comboData += '<option value="' + qData.description + '" selected>' + qData.description + '</option>';
                    } else {
                        comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
                }
            });
            $('#sup_currency').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

//function load_syscode_values(sys_type, combo, callBack,selected) {
//    var comboData = '';
//    $.post("views/loadComboBox.php", {comboBox: 'syscode_types', sys_type: sys_type}, function (e) {
//        if (e === undefined || e.length === 0 || e === null) {
//            comboData += '<option value="0"> -- No Data Found -- </option>';
//            $('#sup_currency').html('').append(comboData);
//            chosenRefresh();
//        } else {
//            $.each(e, function (index, qData) {
//                if (selected !== undefined || e !== null || e.length !== 0) {
//                    if (selected === qData.description) {
//                        comboData += '<option value="' + qData.description + '" selected>' + qData.description + '</option>';
//                    } else {
//                        comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
//                    }
//                } else {
//                    comboData += '<option value="' + qData.description + '">' + qData.description + '</option>';
//                }
//            });
//            $('#port_loading').html('').append(comboData);
//            chosenRefresh();
//        }
//        if (callBack !== undefined) {
//            if (typeof callBack === 'function') {
//                callBack();
//            }
//        }
//    }, "json");
//}

function load_syscode_values(sys_type, combo, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'syscode_types', sys_type: sys_type}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
        } else {
            $.each(e, function (index, qData) {
                comboData += '<option value="' + qData.description + '">' +  qData.description + '</option>';
            });
        }
        $(combo).html('').append(comboData);
        chosenRefresh();
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

function load_syscode_withRemarks(sys_type, combo, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'syscode_types', sys_type: sys_type}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
        } else {
            $.each(e, function (index, qData) {
                comboData += '<option value="' + qData.description + '">' + qData.description + '::' + qData.remarks + '</option>';
            });
        }
        $(combo).html('').append(comboData);
        chosenRefresh();
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

function load_spec_list(mod_id, selected, callBack) {
    var comboData = '';
    comboData += '<option value="0"> -- No Specification -- </option>';
    $.post("views/loadComboBox.php", {comboBox: 'spec_cmb', mod_id: mod_id}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
//            $('.spec_ComboBox').append(comboData);
//            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (selected === qData.spec_id) {
                        comboData += '<option value="' + qData.spec_id + '" selected>' + qData.spec_title + '</option>';
                    } else {
                        comboData += '<option value="' + qData.spec_id + '">' + qData.spec_title + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.spec_id + '">' + qData.spec_title + '</option>';
                }
            });
        }
        $('.spec_ComboBox').html('').append(comboData);
        chosenRefresh();
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}

function load_vhGroups(selected, callBack) {
    var comboData = '';
    $.post("views/loadComboBox.php", {comboBox: 'vh_groups'}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {
            comboData += '<option value="0"> -- No Data Found -- </option>';
            $('#cmb_vh_group').html('').append(comboData);
            chosenRefresh();
        } else {
            $.each(e, function (index, qData) {
                if (selected !== undefined || e !== null || e.length !== 0) {
                    if (selected === qData.vh_group) {
                        comboData += '<option value="' + qData.vh_group + '" selected>' + qData.vh_group + '</option>';
                    } else {
                        comboData += '<option value="' + qData.vh_group + '">' + qData.vh_group + '</option>';
                    }
                } else {
                    comboData += '<option value="' + qData.vh_group + '">' + qData.vh_group + '</option>';
                }
            });
            $('#cmb_vh_group').html('').append(comboData);
            chosenRefresh();
        }
        if (callBack !== undefined) {
            if (typeof callBack === 'function') {
                callBack();
            }
        }
    }, "json");
}
