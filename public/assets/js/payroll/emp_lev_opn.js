"use strict";
$(".select2").select2();

$(document).ready(function () {
    $(document).on("input", ".only-numbers", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    error: function (xhr) {
        let message = xhr.responseJSON?.message || "Something went wrong!";
        error_message(message);
    },
});

function checkNull(value) {
    return value === null ||
        value === undefined ||
        value === "" ||
        value === "null"
        ? ""
        : value;
}

function get_lev_opn() {
    var pEmp_Id = $("#emp_id").val();
    var pFin_Year = $("#fin_year").val();
    var pMonth = $("#mnt_id").val();
    var pYear = $("#year_id").val();

    if (pEmp_Id == null) {
        warning_alert("Please Select An Employe !!");
    } else if (pFin_Year == null) {
        warning_alert("Please Select Finincial Year !!");
    } else if (pMonth == null) {
        warning_alert("Please Select A Month !!");
    } else if (pYear == null) {
        warning_alert("Please Select A Year !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/EmployeeLeaveOpening/GetLeaveData", // Replace with your route
            type: "GET", // GET or POST
            data: {
                pEmp_Id: pEmp_Id,
                pFin_Year: pFin_Year,
                pMonth: pMonth,
                pYear: pYear,
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
                    $("#wcl_tbl_data").empty();
                    data.forEach(function (opnleve) {
                        $("#wcl_tbl_data").append(
                            "<tr>" +
                                '<td style="display:none;">' +
                                opnleve.Id +
                                "</td>" +
                                "<td>" +
                                checkNull(opnleve.Value) +
                                "</td>" +
                                '<td><input type="text" maxlength="2" class="form-control only-numbers text-end" value="' +
                                checkNull(opnleve.LevOpn) +
                                '"></td>' +
                                "</tr>"
                        );
                    });
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

function getTableData() {
    var arr = [];

    $("#wcl_tal tbody tr").each(function () {
        var tds = $(this).find("td");
        var inputs = $(this).find("input");

        arr.push({
            TypeId: parseInt($(tds[0]).text().trim()),
            LeaveOpn: parseInt($(inputs[0]).val()) || null,
        });
    });

    return arr;
}

function post_leave_opn() {
    var pEmp_Id = $("#emp_id").val();
    var pFin_Year = $("#fin_year").val();
    var pMonth = $("#mnt_id").val();
    var pYear = $("#year_id").val();
    var pTableLength = $("#wcl_tal tbody tr").length;
    var isValid = false;
    var tblData = [];
    $("#wcl_tal tbody tr").each(function (index) {
        let inputVal = $(this).find("input").val()?.trim() || "";
        if (!isValid) {
            if (inputVal != "") {
                isValid = true;
            }
        }
    });

    if (pEmp_Id == null) {
        warning_alert("Please Select An Employe !!");
    } else if (pFin_Year == null) {
        warning_alert("Please Select Finincial Year !!");
    } else if (pMonth == null) {
        warning_alert("Please Select A Month !!");
    } else if (pYear == null) {
        warning_alert("Please Select A Year !!");
    } else if (pTableLength == 0) {
        warning_alert("Please Fetch Data First !!");
    } else if (!isValid) {
        warning_alert("Please Enter At Least One Value In Table !!");
    } else {
        tblData = getTableData();
        $.ajax({
            url:
                baseUrl + "/Payroll/EmployeeLeaveOpening/PostOpnLeave", // Replace with your route
            type: "POST", // GET or POST
            data: { pEmp_Id: pEmp_Id,
                pFin_Year: pFin_Year,
                pMonth: pMonth,
                pYear: pYear, pTableData: JSON.stringify(tblData) }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#save_btn").prop("disabled", true);
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                // Handle success response
                if (response.status === "success") {
                    post_message(response.message);
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
                $("#save_btn").prop("disabled", false);
            },
        });
    }
}
