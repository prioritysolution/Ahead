"use strict";
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    error: function (xhr) {
        let message = xhr.responseJSON?.message || "Something went wrong!";
        error_message(message);
    },
});

function change_pass() {
    var pNpass = $("#nwpass").val();
    var pCpass = $("#cnfpass").val();
    if (pNpass == "") {
        warning_alert("Please Enter New Password !!");
    } else if (pCpass == "") {
        warning_alert("Please Enter Confirm Password !!");
    } else if (pNpass != pCpass) {
        warning_alert("New Password And Confirm Password Is Not Matched !!");
    } else {
        $.ajax({
            url: baseUrl + "/User/UpdatePassword", // Replace with your route
            type: "POST", // GET or POST
            data: {
                pUserPass: pCpass,
            }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                // Handle success response
                if (response.status === "success") {
                    $("#nwpass").val("");
                    $("#cnfpass").val("");
                    noload_success(response.message);
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
