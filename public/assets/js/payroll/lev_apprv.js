"use strict";

$(document).on("click", ".open-leave-modal", function () {
    $("#leave_id").val($(this).data("id"));
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

function apprv_leave() {
    var pAppl_Id = $("#leave_id").val();
    var pStst_Cd = $("#leave_status").val();
    var pRemarks = $("#remarks").val();

    if (pAppl_Id == "") {
        warning_alert("Please Select An Application For Approve / Reject !!");
    } else if (pStst_Cd == null) {
        warning_alert("Please Select Status !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/LeaveApproval/ApproveRejectLeave", 
            type: "POST", 
            data: {
                pAppl_Id: pAppl_Id,
                pSts_Cd: pStst_Cd,
                pRemarks: pRemarks
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
