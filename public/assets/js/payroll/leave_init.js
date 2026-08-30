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

function get_leave_init() {
    var pYear_Id = $("#selectYear").val();

    if (pYear_Id == null) {
        warning_alert("Please Select Financial Year First !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/LeaveEntitlementInitialization/LeaveAllow", // Replace with your route
            type: "GET", // GET or POST
            data: { pYear_Id: pYear_Id }, // Data to send
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
                    data.forEach(function (levallow) {
                        $("#wcl_tbl_data").append(
                            "<tr>" +
                                '<td style="display:none;">' +
                                levallow.Id +
                                "</td>" +
                                "<td>" +
                                checkNull(levallow.Value) +
                                "</td>" +
                                '<td><input type="text" maxlength="2" class="form-control only-numbers text-end" value="' +
                                checkNull(levallow.LevNo) +
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
            LeaveNo: parseInt($(inputs[0]).val()) || null
        });
    });

    return arr;
}

function proc_lev_init() {
    var pYear_Id = $("#selectYear").val();
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
    if (pYear_Id == null) {
        warning_alert("Please Select Year First !!");
    } else if (pTableLength == 0) {
        warning_alert("Please Fetch Data First !!");
    } else if (!isValid) {
        warning_alert("Please Enter At Least One Value In Table !!");
    } else {
        tblData = getTableData();
        $.ajax({
            url: baseUrl + "/Payroll/LeaveEntitlementInitialization/UpdateSetup", // Replace with your route
            type: "POST", // GET or POST
            data: { pYear_Id: pYear_Id,pinit_Data:JSON.stringify(tblData) }, // Data to send
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
