"use strict";
$(".select2").select2();
$(document).ready(function () {
    $(document).on("input", ".only-numbers", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

    $(".bs-datepicker-format").inputmask("99/99/9999").datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        todayBtn: "linked",
        autoclose: true,
    });
});

function setDatePickerValue(selector, dateStr) {
    if (!dateStr) return;

    // dateStr = "2025-12-18"
    let parts = dateStr.split("-");
    let formattedDate = parts[2] + "/" + parts[1] + "/" + parts[0]; // dd/mm/yyyy

    $(selector).datepicker("setDate", formattedDate).trigger("change");
}

function clearDatePicker(selector) {
    $(selector)
        .datepicker('clearDates') // clears datepicker internal state
        .val('')                  // clears inputmask value
        .trigger('change');
}

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    error: function (xhr) {
        let message = xhr.responseJSON?.message || "Something went wrong!";
        error_message(message);
    },
});

$("#doc_file").on("change", function () {
    const file = this.files[0];
    if (!file) return;

    const allowedTypes = [
        "image/jpeg",
        "image/png",
        "image/jpg",
        "image/webp",
        "application/pdf",
    ];

    const maxSize = 2 * 1024 * 1024; // 2MB

    if (!allowedTypes.includes(file.type)) {
        warning_alert("Only Image and PDF files are allowed.");
        this.value = "";
        return;
    }

    if (file.size > maxSize) {
        warning_alert("File size must be less than 2MB.");
        this.value = "";
        return;
    }
});

function checkNull(value) {
    return value === null ||
        value === undefined ||
        value === "" ||
        value === "null"
        ? ""
        : value;
}

function src_leave() {
    var pEmp_Id = $("#emp_name").val();
    var pAppl_No = $("#appl_no").val();

    if (pEmp_Id == null) {
        warning_alert("Please Select An Employee First !!");
    } else if (pAppl_No == "") {
        warning_alert("Please Enter An Application No For Search !!");
    } else {
        var half_type = null;
        var half_cd = null;
        $.ajax({
            url: baseUrl + "/Payroll/LeaveRequisition/GetApplData", // Replace with your route
            type: "GET", // GET or POST
            data: {
                pEmp_Id: pEmp_Id,
                pAppl_No: pAppl_No,
            }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#srcBtn").prop("disabled", true);
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                // Handle success response
                if (response.status === "success") {
                    var data = response.message;
                    console.log(data);
                    if (data.length > 0) {
                        $("#save_btn").html(
                                '<i id="btnIcon" class="fa fa-edit"></i> Update'
                            );
                        $("#req_id").val(data[0].ApplId);
                        $("#lev_type").val(data[0].TypeId).trigger("change");
                        setDatePickerValue("#lev_frm", data[0].FrmDt);
                        setDatePickerValue("#lev_to", data[0].ToDt);
                        half_type = checkNull(data[0].HlfDay);
                        if (half_type == "1") {
                            $("#hlf_day_yes").prop("checked", true);
                            $("#hlf_day_no").prop("checked", false);
                        } else {
                            $("#hlf_day_no").prop("checked", true);
                            $("#hlf_day_yes").prop("checked", false);
                        }

                        half_cd = checkNull(data[0].HlfCd);
                        if (half_cd != "") {
                            $("#hlf_day_type")
                                .val(data[0].HlfCd)
                                .trigger("change");
                        } else {
                            $("#hlf_day_type").val("").trigger("change");
                        }

                        $("#lev_reason").val(checkNull(data[0].Reson));
                    } else {
                        $("#save_btn").html(
                            '<i id="btnIcon" class="fa fa-save"></i> Save'
                        );
                        $("#req_id").val("");
                        $("#lev_type").val("").trigger("change");
                        $("#hlf_day_no").prop("checked", true);
                        $("#hlf_day_yes").prop("checked", false);
                        $("#hlf_day_type").val("").trigger("change");
                        $("#lev_reason").val(checkNull(""));
                        clearDatePicker("#lev_frm");
                        clearDatePicker("#lev_to");
                        $('#doc_file').val('');
                        error_message(
                            "No Data Found With This Application No !!"
                        );
                    }
                } else {
                    // If server returns error in JSON
                    error_message(response.message || "Something went wrong!");
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                let errorMessage =
                    "Error: " +
                    (xhr.responseJSON?.message || error || "Unknown error");
                console.error(errorMessage);
                error_message(errorMessage);
            },
            complete: function () {
                $("#nb-global-spinner").fadeOut();
                $("#srcBtn").prop("disabled", false);
            },
        });
    }
}

function get_leave_balance(p) {
    var pEmp_Id = $("#emp_name").val();
    if (pEmp_Id == null) {
        warning_alert("Please Select An Employee First !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/LeaveRequisition/GetLeaveBalance", // Replace with your route
            type: "GET", // GET or POST
            data: {
                pEmp_Id: pEmp_Id,
                pType_Id: p,
            }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#srcBtn").prop("disabled", true);
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                // Handle success response
                if (response.status === "success") {
                    var data = response.message[0].LvRem;
                    warning_alert("Your Remaning Leave Balance Is " + data);
                } else {
                    // If server returns error in JSON
                    error_message(response.message || "Something went wrong!");
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                let errorMessage =
                    "Error: " +
                    (xhr.responseJSON?.message || error || "Unknown error");
                console.error(errorMessage);
                error_message(errorMessage);
            },
            complete: function () {
                $("#nb-global-spinner").fadeOut();
            },
        });
    }
}
function format_date(p) {
    if (p == "") {
        return "";
    } else {
        let parts = p.split("/"); // ["12","10","2025"]
        let dateObj = new Date(parts[2], parts[1] - 1, parts[0]);
        dateObj = dayjs(dateObj).format("YYYY-MM-DD");
        return dateObj;
    }
}

function post_lev_req() {
    var pAppl_Id = $("#req_id").val();
    var pEmp_Id = $("#emp_name").val();
    var pLeave_Type = $("#lev_type").val();
    var lev_frm = $("#lev_frm").val();
    var lev_to = $("#lev_to").val();
    var pHalf_Day_Flag = $("#hlf_day_yes").is(":checked") ? 1 : 0;
    var pHalf_Day_type = $("#hlf_day_type").val();
    var pLev_Reason = $("#lev_reason").val();

    if (pEmp_Id == null) {
        warning_alert("Please Select An Employee First !!");
    } else if (pLeave_Type == null) {
        warning_alert("Please Select Leave Type !!");
    } else if (lev_frm == "") {
        warning_alert("Please Enter Leave Form Date !!");
    } else if (lev_to == "") {
        warning_alert("Please Enter Leave To Date !!");
    } else if (pHalf_Day_Flag && pHalf_Day_type == null) {
        warning_alert("Please Select Half Day Type !!");
    } else if (pLev_Reason == "") {
        warning_alert("Please Put Leave Reason !!");
    } else {
        let fd = new FormData();
        fd.append("doc_file", $("#doc_file")[0].files[0]);
        fd.append("pEmp_Id", pEmp_Id);
        fd.append("pLeave_Type", pLeave_Type);
        fd.append("lev_frm", format_date(lev_frm));
        fd.append("lev_to", format_date(lev_to));
        fd.append("pHalf_Day_Flag", pHalf_Day_Flag);
        fd.append("pHalf_Day_type", pHalf_Day_type);
        fd.append("pLev_Reason", pLev_Reason);
        fd.append("pAppl_Id", pAppl_Id);
        $.ajax({
            url: baseUrl + "/Payroll/LeaveRequisition/ProcessRequisition", // Replace with your route
            type: "POST", // GET or POST
            data: fd, // Data to send
            processData: false,
            contentType: false,
            beforeSend: function () {
                // Optional: show loader
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                // Handle success response
                if (response.status === "success") {
                    var data = response.message;
                    post_message(
                        "Your Leave Application Is Successfully Submited Application No Is " +
                            data
                    );
                } else {
                    // If server returns error in JSON
                    error_message(response.message || "Something went wrong!");
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                let errorMessage =
                    "Error: " +
                    (xhr.responseJSON?.message || error || "Unknown error");
                console.error(errorMessage);
                error_message(errorMessage);
            },
            complete: function () {
                $("#nb-global-spinner").fadeOut();
            },
        });
    }
}
