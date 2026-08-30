"use strict";
$(document).ready(function () {
    $(document).on("input", ".only-numbers", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

    $(document).on("input", ".only-decimal", function () {
        this.value = this.value
            .replace(/[^0-9.]/g, "")
            .replace(/(\..*)\./g, "$1")
            .replace(/(\.\d{2}).+/, "$1");
    });
});

$(".select2").select2();

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

function get_data(p) {
    var pAllow_Id = p;
    if (pAllow_Id == null) {
        warning_alert("Please Select Allowance First !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/Deductions/GetData", // Replace with your route
            type: "GET", // GET or POST
            data: {
                pAllow_Id: pAllow_Id,
            }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                // Handle success response
                if (response.status === "success") {
                    var data = response.message;
                    console.log(data);
                    if (data) {
                        $("#save_btn").html(
                            '<i id="btnIcon" class="fa fa-edit"></i> Update'
                        );
                        $("#ded_id").val(data.Id);
                        $("#ded_name").val(data.Value);
                        $("#ded_amt").val(checkNull(data.Rate));
                        $("#ded_perc").val(checkNull(data.Percntage));
                        $("#ded_round").val(checkNull(data.ROff_Nearest));
                    } else {
                        $("#save_btn").html(
                            '<i id="btnIcon" class="fa fa-save"></i> Save'
                        );
                        $("#ded_id").val("");
                        $("#ded_name").val("");
                        $("#ded_amt").val("");
                        $("#ded_perc").val("");
                        $("#ded_round").val("");
                        error_message("No Data Found !!");
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
            },
        });
    }
}

function post_ded() {
    var pAll_Id = $("#ded_id").val();
    var pAllow_Name = $("#ded_name").val();
    var pAmount = $("#ded_amt").val();
    var pPerc = $("#ded_perc").val();
    var pRound = $("#ded_round").val();

    if (pAllow_Name == "") {
        warning_alert("Please Enter Deduction Name !!");
    } else if (pAmount == "" && pPerc == "") {
        warning_alert("Please Enter Either Amount / Percentage !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/Deductions/PostDeduction", // Replace with your route
            type: "POST", // GET or POST
            data: {
                pAll_Id: pAll_Id,
                pAllow_Name: pAllow_Name,
                pAmount: pAmount,
                pPerc: pPerc,
                pRound: pRound
            }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                // Handle success response
                if (response.status === "success") {
                    var data = response.message;
                    post_message(data);
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
