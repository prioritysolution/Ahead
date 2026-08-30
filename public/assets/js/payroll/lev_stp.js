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

function check_type(p) {
    if (p == 3) {
        $("#day_no").removeAttr("readonly", true);
    } else {
        $("#day_no").attr("readonly", true);
    }
}

function selectType(p) {
    var pType_Id = $("#" + p).val();
    if (pType_Id == null) {
        warning_alert("Please Select Leave Type !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/LeaveSetup/GetLeaveType", // Replace with your route
            type: "GET", // GET or POST
            data: { pType_Id: pType_Id }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                // Handle success response
                var doc_type = 0;
                var active = 0;
                var val_id = 0;
                if (response.status === "success") {
                    var data = response.message;
                    if (data.length > 0) {
                        data.forEach(function (type) {
                            $("#save_btn").html(
                                '<i id="btnIcon" class="fa fa-edit"></i> Update'
                            );
                            $("#leave_id").val(type.TypeId);
                            $("#leave_name").val(checkNull(type.TypeNm));
                            $("#short_name").val(checkNull(type.SrtNm));
                            doc_type = checkNull(type.DocR);
                            if (doc_type == 1) {
                                $("#doc_yes").prop("checked", true);
                                $("#doc_no").prop("checked", false);
                            } else {
                                $("#doc_yes").prop("checked", false);
                                $("#doc_no").prop("checked", true);
                            }

                            $("#leave_no_year").val(checkNull(type.NoOfLev));
                            val_id = checkNull(type.ValCd);
                            if (val_id != "") {
                                $("#validaty").val(val_id).trigger("change");
                            } else {
                                $("#validaty").val("").trigger("change");
                            }
                            $("#day_no").val(checkNull(type.DNo));
                            active = checkNull(type.Actv);

                            if (active == 1) {
                                $("#active").prop("checked", true);
                            } else {
                                $("#active").prop("checked", false);
                            }
                        });
                    } else {
                        $("#save_btn").html(
                            '<i id="btnIcon" class="fa fa-save"></i> Save'
                        );

                        doc_type = 0;
                        active = 0;
                        val_id = 0;
                        $("#doc_yes").prop("checked", true);
                        $("#doc_no").prop("checked", false);
                        $("#validaty").val("").trigger("change");
                        $("#active").prop("checked", false);
                        $("#leave_id").val("");
                        $("#leave_name").val("");
                        $("#short_name").val("");
                        $("#leave_no_year").val("");
                        $("#day_no").val("");
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

function post_leave() {
    var pLeave_Id = $("#leave_id").val();
    var pLeave_Name = $("#leave_name").val();
    var pSh_Name = $("#short_name").val();
    var pDoc_Req = $("#doc_yes").is(":checked") ? 1 : 0;

    var pLeave_No = $("#leave_no_year").val();
    var pValidaty = $("#validaty").val();
    var pDays_No = $("#day_no").val();
    var pActive = $("#active").is(":checked") ? 1 : 0;
    if (pLeave_Name == "") {
        warning_alert("Please Enter Leave Name !!");
    } else if (pSh_Name == "") {
        warning_alert("Please Enter Short Leave Name !!");
    } else if (pLeave_No == "") {
        warning_alert("Please Enter Leave No Per Year !!");
    } else if (pValidaty == 3 && pDays_No == "") {
        warning_alert("Please Enter Days No !!");
    } else if (!pActive) {
        warning_alert("Please Check Active !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/LeaveSetup/ProcessLeaveSetup", // Replace with your route
            type: "POST", // GET or POST
            data: {
                pLeave_Id: pLeave_Id,
                pLeave_Name: pLeave_Name,
                pSh_Name: pSh_Name,
                pDoc_Req: pDoc_Req,
                pLeave_No: pLeave_No,
                pValidaty: pValidaty,
                pDays_No: pDays_No,
                pActive: pActive,
            }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#save_btn").attr("disabled", true);
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
                $("#save_btn").removeAttr("disabled", true);
                $("#nb-global-spinner").fadeOut();
            },
        });
    }
}
