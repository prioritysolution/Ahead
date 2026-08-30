"use strict";
$(window).on("load", function () {
    check_attend();
    setInterval(get_currentdatetime, 1000);
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

let timerInterval;
function check_attend() {
    if (pIsAttend == 0) {
        $("#DivPnchIn").removeAttr("style");
        $("#DivPunchOut").attr("style", "display:none;");
        $("#DivAttend").attr("style", "display:none;");
    } else {
        var pNewDate = dayjs(
            pAttendDate + " " + pAttendTime,
            "DD-MM-YYYY hh:mm A"
        );
        $("#DivPnchIn").attr("style", "display:none;");
        $("#DivPunchOut").removeAttr("style");
        $("#DivAttend").removeAttr("style");
        $("#AttTime").removeAttr("style");
        $("#PrintPunchIn").text(
            "Punch In at " + pNewDate.format("DD-MMM-YYYY hh:mm:ss A")
        );
    }
}

function get_currentdatetime() {
    var pCurr_Date = new Date();
    var FormatDate = dayjs(pCurr_Date);
    $("#punch_date").text(
        "Today's Date : " + FormatDate.format("DD - MMM - YYYY")
    );
    $("#punch_time").text("Current Time : " + FormatDate.format("hh:mm:ss A"));
}

function punch_in() {
    var pRemarks = $("#remarks").val();
    $.ajax({
        url: baseUrl + "/ProcessAttandance/PunchIn", // Replace with your route
        type: "POST", // GET or POST
        data: {
            pEmpPunchIn: pRemarks,
            pEmpStatus: 1,
        }, // Data to send
        dataType: "json", // Expected response
        beforeSend: function () {
            // Optional: show loader
            $("#nb-global-spinner").fadeIn();
        },
        success: function (response) {
            // Handle success response
            if (response.status === "success") {
                pAttendDate = response.AttendDate;
                var parts = pAttendDate.split("-");
                var isoDate = parts[2] + "-" + parts[1] + "-" + parts[0];
                pAttendDate = dayjs(
                    isoDate + " " + response.AttendTime,
                    "DD-MM-YYYY hh:mm A"
                );
                $("#DivPnchIn").attr("style", "display:none;");
                $("#DivPunchOut").removeAttr("style");
                $("#DivAttend").removeAttr("style");
                $("#AttTime").removeAttr("style");
                $("#PrintPunchIn").text(
                    "Punch In at " +
                        pAttendDate.format("DD-MMM-YYYY hh:mm:ss A")
                );
                pIsAttend = 1;
                pAttendTime = pAttendDate.format("hh:mm:ss A");
                pAttendDate = pAttendDate.format("DD-MMM-YYYY");

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

function punch_out() {
    var pRemarks = $("#remarks").val();
    $.ajax({
        url: baseUrl + "/ProcessAttandance/PunchOut", // Replace with your route
        type: "POST", // GET or POST
        data: {
            pEmpPunchOut: pRemarks,
        }, // Data to send
        dataType: "json", // Expected response
        beforeSend: function () {
            // Optional: show loader
            $("#nb-global-spinner").fadeIn();
        },
        success: function (response) {
            // Handle success response
            if (response.status === "success") {
                $("#DivPnchIn").removeAttr("style");
                $("#DivPunchOut").attr("style", "display:none;");
                $("#DivAttend").attr("style", "display:none;");
                pIsAttend = 0;
                pAttendDate = 0;
                pAttendTime = 0;
                $("#CalTime").text("");
                if (timerInterval) {
                    clearInterval(timerInterval);
                    timerInterval = null;
                }
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

function formatTime(seconds) {
    let h = Math.floor(seconds / 3600);
    let m = Math.floor((seconds % 3600) / 60);
    let s = seconds % 60;
    return `${String(h).padStart(2, "0")}:${String(m).padStart(
        2,
        "0"
    )}:${String(s).padStart(2, "0")}`;
}

function updateTimer() {
    if (pIsAttend != 0) {
        var startTime = dayjs(
            pAttendDate + " " + pAttendTime,
            "DD-MM-YYYY hh:mm A"
        );
        // console.log(pAttendDate);
        let now = new Date();
        // console.log(now);
        let elapsedSeconds = Math.floor((now - startTime) / 1000); // total seconds passed
        // console.log(elapsedSeconds);
        document.getElementById("CalTime").innerText = "";
        document.getElementById("CalTime").innerText =
            formatTime(elapsedSeconds);
    }
}

timerInterval = setInterval(updateTimer, 1000);
