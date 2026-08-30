"use strict";
$(".select2").select2();

$(document).ready(function () {
    let picker = $(".bs-datepicker-format").datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        todayBtn: "linked",
        autoclose: true,
        endDate: new Date(),
    });

    // Set today's date
    picker.datepicker("setDate", new Date());
});
flatpickr(".timepicker2", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "h:i K", // 12-hour format
    // defaultDate: new Date(), // highlight current time
    time_24hr: false, // change to true for 24-hour format
    minuteIncrement: 1,
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

function check_attend(p) {
    $.ajax({
        url: baseUrl + "/ProcessAttandance/CheckAttend", // Replace with your route
        type: "GET", // GET or POST
        data: {
            pCHeckAttend: p,
        }, // Data to send
        dataType: "json", // Expected response
        beforeSend: function () {
            // Optional: show loader
            $("#nb-global-spinner").fadeIn();
        },
        success: function (response) {
            // Handle success response
            if (response.status === "success") {
                var pAttend = response.data[0].CheckIn;
                if (pAttend != 0) {
                    $("#selectstatus").attr("disabled", true);
                    $("#AttendDate").attr("disabled", true);
                    $("#PuunchInTime").attr("disabled", true);
                    $("#punchBtn").text("Punch Out");
                    $("#nb-global-spinner").fadeOut();
                } else {
                    $("#selectstatus").removeAttr("disabled");
                    $("#AttendDate").removeAttr("disabled");
                    $("#PuunchInTime").removeAttr("disabled");
                    $("#punchBtn").text("Punch In");
                    $("#nb-global-spinner").fadeOut();
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

function punch_in() {
    var pText = $("#punchBtn").text();
    var pEmp_Id = $("#selectemployee").val();
    var pEmpStatus = $("#selectstatus").val();
    var pAttendDate = $("#AttendDate").val();
    var pPunchTime = $("#PuunchInTime").val();
    var pPunchOutTime = $("#PunchOutTime").val();
    var pRemarks = $("#Remarks").val();
    if (pText == "Punch In") {
        var pNewCheckOut = "";
        var pNewCheckIn = "";
        if (pPunchOutTime != "") {
            pNewCheckOut = dayjs(
                format_date(pAttendDate) + " " + pPunchOutTime,
                "YYYY-MM-DD hh:mm A"
            ).format("HH:mm");
        }

        if (pEmpStatus == 1 || pEmpStatus == 4 || pEmpStatus == 5) {
            if (pPunchTime != "") {
                pNewCheckIn = dayjs(
                    format_date(pAttendDate) + " " + pPunchTime,
                    "YYYY-MM-DD hh:mm A"
                ).format("HH:mm");
            }
        }

        if (pEmp_Id == null) {
            warning_alert("Please Select Employee !!");
        } else if (pEmpStatus == null) {
            warning_alert("Please Select Status !!");
        } else if (pAttendDate == "") {
            warning_alert("Please Select Date !!");
        } else if (
            (pEmpStatus == 1 && pPunchTime == "") ||
            (pEmpStatus == 4 && pPunchTime == "") ||
            (pEmpStatus == 5 && pPunchTime == "")
        ) {
            warning_alert("Please Select Punch In Time !!");
        } else {
            $.ajax({
                url: baseUrl + "/ProcessAttandance/ManPunchIn", // Replace with your route
                type: "POST", // GET or POST
                data: {
                    pEmp_Id: pEmp_Id,
                    pEmpStatus: pEmpStatus,
                    pAttendDate: format_date(pAttendDate),
                    pPunchTime: pNewCheckIn,
                    pPunchOutTime: pNewCheckOut,
                    pRemarks: pRemarks,
                }, // Data to send
                dataType: "json", // Expected response
                beforeSend: function () {
                    // Optional: show loader
                    $("#nb-global-spinner").fadeIn();
                },
                success: function (response) {
                    // Handle success response
                    if (response.status === "success") {
                        post_message(response.message);
                    } else {
                        // If server returns error in JSON
                        error_message(
                            response.message || "Something went wrong!"
                        );
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

    if (pText == "Punch Out") {
        if (pEmp_Id == null) {
            warning_alert("Please Select Employee !!");
        } else if (pPunchOutTime == "") {
            warning_alert("Please Select Punch Out Time !!");
        } else {
            $.ajax({
                url: baseUrl + "/ProcessAttandance/ManPunchOut", // Replace with your route
                type: "POST", // GET or POST
                data: {
                    pEmp_Id: pEmp_Id,
                    pAttendDate: format_date(pAttendDate),
                    pPunchOutTime: dayjs(
                        format_date(pAttendDate) + " " + pPunchOutTime,
                        "YYYY-MM-DD hh:mm A"
                    ).format("HH:mm"),
                    pRemarks: pRemarks,
                }, // Data to send
                dataType: "json", // Expected response
                beforeSend: function () {
                    // Optional: show loader
                    $("#nb-global-spinner").fadeIn();
                },
                success: function (response) {
                    // Handle success response
                    if (response.status === "success") {
                        post_message(response.message);
                    } else {
                        // If server returns error in JSON
                        error_message(
                            response.message || "Something went wrong!"
                        );
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
}
