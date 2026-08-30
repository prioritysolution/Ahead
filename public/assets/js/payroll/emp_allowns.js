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
            url: baseUrl + "/Payroll/Allowances/GetData", // Replace with your route
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
                        $("#allow_id").val(data.Id);
                        $("#allow_name").val(data.Value);
                        $("#all_amt").val(checkNull(data.Rate));
                        $("#all_perc").val(checkNull(data.Percntage));
                        $("#all_round").val(checkNull(data.ROff_Nearest));
                    } else {
                        $("#save_btn").html(
                            '<i id="btnIcon" class="fa fa-save"></i> Save'
                        );
                        $("#allow_id").val("");
                        $("#allow_name").val("");
                        $("#all_amt").val("");
                        $("#all_perc").val("");
                        $("#all_round").val("");
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

function post_allowns() {
    var pAll_Id = $("#allow_id").val();
    var pAllow_Name = $("#allow_name").val();
    var pAmount = $("#all_amt").val();
    var pPerc = $("#all_perc").val();
    var pRound = $("#all_round").val();

    if (pAllow_Name == "") {
        warning_alert("Please Enter Allowance Name !!");
    } else if (pAmount == "" && pPerc == "") {
        warning_alert("Please Enter Either Amount / Percentage !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/Allowances/PostAllowance", // Replace with your route
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
