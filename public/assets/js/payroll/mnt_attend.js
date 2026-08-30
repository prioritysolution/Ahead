"use strict";
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

function initSelect2(container) {
    container.find(".select2").each(function () {
        if ($(this).hasClass("select2-hidden-accessible")) {
            $(this).select2("destroy");
        }

        $(this).select2({
            width: "100%",
            dropdownParent: $(this).closest("td"), // VERY important for tables
        });
    });
}
function initTimePickers(container) {
    container.find(".timepicker2").each(function () {
        if (!this._flatpickr) {
            flatpickr(this, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",
                time_24hr: false,
                minuteIncrement: 1,
                allowInput: true,
                onChange: function () {
                    calculateHoursForRow($(this.element).closest("tr"));
                },
            });
        }
    });
}
function calculateHoursForRow(row) {
    let inTime = row.find(".in_time").val();
    let outTime = row.find(".out_time").val();

    if (!inTime || !outTime) return;

    let start = moment(inTime, "hh:mm A");
    let end = moment(outTime, "hh:mm A");

    if (end.isBefore(start)) end.add(1, "day");

    let diff = moment.duration(end.diff(start));
    let hrs = diff.hours() + ":" + String(diff.minutes()).padStart(2, "0");

    row.find(".work_hrs").val(hrs);
}
function loaddrp(callback) {
    let req1 = $.ajax({
        url: baseUrl + "/Payroll/MonthlyAttandance/GetOptions",
        type: "GET",
        data: { pOption: 12 },
        dataType: "json",
    });

    let req2 = $.ajax({
        url: baseUrl + "/Payroll/MonthlyAttandance/GetOptions",
        type: "GET",
        data: { pOption: 14 },
        dataType: "json",
    });

    $("#srcBtn").prop("disabled", true);
    $("#nb-global-spinner").fadeIn();

    $.when(req1, req2)
        .done(function (res1, res2) {
            if (res1[0].status === "success") {
                let opt1 = `<option value="">Select Status</option>`;
                res1[0].message.forEach((o) => {
                    opt1 += `<option value="${o.Id}">${o.Value}</option>`;
                });
                $(".status1").html(opt1);
            }

            if (res2[0].status === "success") {
                let opt2 = `<option value="">Select Status</option>`;
                res2[0].message.forEach((o) => {
                    opt2 += `<option value="${o.Id}">${o.Value}</option>`;
                });
                $(".status2").html(opt2);
            }

            if (typeof callback === "function") callback();

            $("#nb-global-spinner").fadeOut();
            $("#srcBtn").prop("disabled", false);
        })
        .fail(function () {
            error_message("Dropdown load failed!");
            $("#nb-global-spinner").fadeOut();
            $("#srcBtn").prop("disabled", false);
        });
}

function loadSavedAttendance(empId, month, year) {
    $.ajax({
        url: baseUrl + "/Payroll/MonthlyAttandance/GetSavedAttendance",
        type: "GET",
        data: { emp_id: empId, month: month, year: year },
        dataType: "json",

        beforeSend: function () {
            $("#nb-global-spinner").fadeIn();
        },

        success: function (response) {
            if (response.status !== "success") return;

            let saved = response.message;

            $("#days_tbl tr").each(function () {
                let row = $(this);
                let rowDate = row.find("td:eq(1)").text();

                let match = saved.find((x) => x.MDate === rowDate);
                if (!match) return;

                row.find(".status1")
                    .val(match.Status)
                    .trigger("change.select2");
                row.find(".status2").val(match.Flag).trigger("change.select2");

                row.find(".in_time").val(match.InTime);
                row.find(".out_time").val(match.OutTime);
                row.find(".work_hrs").val(match.TotHr);
                row.find(".remarks").val(match.Remrks);
            });

            cal_tot();
        },

        complete: function () {
            $("#nb-global-spinner").fadeOut();
        },

        error: function () {
            error_message("Saved attendance load error!");
            $("#nb-global-spinner").fadeOut();
        },
    });
}

function get_list() {
    var pMonth = $("#mn_id").val();
    var pYear = $("#yer_id").val();
    var pEmp_Id = $("#emp_id").val();

    if (pMonth == null) {
        warning_alert("Please Select Month !!");
    } else if (pYear == null) {
        warning_alert("Please Select Year !!");
    } else if (pEmp_Id == null) {
        warning_alert("Please Select Employee !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/MonthlyAttandance/GetDetails",
            type: "GET",
            data: { emp_id: pEmp_Id, month: pMonth, year: pYear },
            dataType: "json",

            beforeSend: function () {
                $("#srcBtn").prop("disabled", true);
                $("#nb-global-spinner").fadeIn();
            },

            success: function (response) {
                if (response.status !== "success") {
                    error_message(response.message || "Something went wrong!");
                    return;
                }

                let data = response.message;
                $("#days_tbl").empty();

                let sl = 1;
                data.forEach(function (month) {
                    $("#days_tbl").append(`
                    <tr>
                        <td>${sl++}</td>
                        <td style="display:none;">${month.date}</td>
                        <td>${month.datedisp}</td>
                        <td>
                            <select class="status1 form-control" onchange="cal_tot();"></select>
                        </td>
                        <td>
                            <select class="status2 form-control"></select>
                        </td>
                        <td><input type="text" class="form-control timepicker2 in_time" /></td>
                        <td><input type="text" class="form-control timepicker2 out_time" /></td>
                        <td><input type="text" readonly class="form-control work_hrs" /></td>
                        <td><textarea class="form-control remarks"></textarea></td>
                    </tr>
                `);
                });

                $("#prm_tbl").html(`
                <tr><td><b>Present</b></td><td><input type="text" id="prs" readonly class="form-control"/></td></tr>
                <tr><td><b>Half Day</b></td><td><input type="text" id="hlf_d" readonly class="form-control"/></td></tr>
                <tr><td><b style="white-space: normal; word-wrap: break-word;">Weekly Holiday</b></td><td><input type="text" id="sat_day" readonly class="form-control"/></td></tr>
                <tr><td><b>Holidays</b></td><td><input type="text" id="hold" readonly class="form-control"/></td></tr>
                <tr><td><b>Leave</b></td><td><input type="text" id="leav" readonly class="form-control"/></td></tr>
                <tr><td><b>Absent</b></td><td><input type="text" id="abs" readonly class="form-control"/></td></tr>
                <tr><td><b>Total</b></td><td><input type="text" id="tot" readonly class="form-control"/></td></tr>
            `);

                loaddrp(function () {
                    initSelect2($("#days_tbl"));
                    initTimePickers($("#days_tbl"));
                    loadSavedAttendance(pEmp_Id, pMonth, pYear);
                });
            },

            complete: function () {
                $("#nb-global-spinner").fadeOut();
                $("#srcBtn").prop("disabled", false);
                $(window).trigger("resize");
            },

            error: function () {
                error_message("Table API error!");
                $("#nb-global-spinner").fadeOut();
                $("#srcBtn").prop("disabled", false);
            },
        });
    }
}

function format_date(p) {
    if (p == "") {
        return "";
    } else {
        let parts = p.split("-"); // ["12","10","2025"]
        let dateObj = new Date(parts[2], parts[1] - 1, parts[0]);
        dateObj = dayjs(dateObj).format("YYYY-MM-DD");
        return dateObj;
    }
}

function getAttendanceJson() {
    var data = [];

    $("#days_tbl tr").each(function () {
        var $tr = $(this);

        var attnDate = $tr.find("td:eq(1)").text().trim(); // hidden date column
        var attnStat = $tr.find(".status1").val();
        var attnFlag = $tr.find(".status2").val() || null;
        var inTimeRaw = $tr.find(".in_time").val();
        var outTimeRaw = $tr.find(".out_time").val();
        var remarks = $tr.find(".remarks").val();

        // Convert times to HH:mm if present
        var attnInTm = inTimeRaw
            ? dayjs(
                  format_date(attnDate) + " " + inTimeRaw,
                  "YYYY-MM-DD hh:mm A",
              ).format("HH:mm")
            : null;

        var attnOutTm = outTimeRaw
            ? dayjs(
                  format_date(attnDate) + " " + outTimeRaw,
                  "YYYY-MM-DD hh:mm A",
              ).format("HH:mm")
            : null;

        data.push({
            AttnDate: attnDate,
            AttnStat: attnStat,
            AttnFlag: attnFlag,
            AttnInTm: attnInTm,
            AttnOutTm: attnOutTm,
            AttnRem: remarks,
        });
    });

    return JSON.stringify(data);
}

function cal_tot() {
    let present = 0,
        hlf_d = 0,
        absent = 0,
        Sat_Day = 0,
        hold = 0,
        leave = 0;

    $(".status1").each(function () {
        let val = $(this).val();

        if (val === "1") present++;
        else if (val === "10") present++;
        else if (val === "8") Sat_Day++;
        else if (val === "9") hold++;
        else if (val === "4") leave++;
        else if (val === "5") leave++;
        else if (val === "6") leave++;
        else if (val === "7") leave++;
        else if (val === "3") hlf_d++;
        else if (val === "2") absent++; // NULL + EMPTY + 2 all treated as absent
    });

    $("#prs").val(present);
    $("#sat_day").val(Sat_Day);
    $("#hold").val(hold);
    $("#leav").val(leave);
    $("#abs").val(absent);
    $("#hlf_d").val(hlf_d);
    $("#tot").val(present + Sat_Day + hold + leave + absent + hlf_d);
}

function post_mnt_attnd() {
    var pEmp_Id = $("#emp_id").val();
    var pPresent = $("#prs").val();
    var tbl_length = $("#days_tbl tr").length;
    let isValid = true;
    $("#days_tbl tr").each(function (index) {
        const status1Val = $(this).find(".status1").val();
        const status2Val = $(this).find(".status2").val();

        if (status1Val === "4" && (!status2Val || status2Val.trim() === "")) {
            isValid = false;
            // errorRow = index + 1; // 1-based row number
            return false; // break loop
        }
    });

    if (tbl_length === 0) {
        warning_alert("Please Fetch Data First !!");
    } else if (pPresent === "0") {
        warning_alert("Please Put Attandance Details !!");
    } else if (!isValid) {
        warning_alert("Please Select Half-Day Type !!");
    } else if (pEmp_Id == null) {
        warning_alert("Please Select Employee !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/MonthlyAttandance/PostAttandance",
            type: "POST",
            data: { emp_id: pEmp_Id, json: getAttendanceJson() },
            dataType: "json",

            beforeSend: function () {
                $("#srcBtn").prop("disabled", true);
                $("#nb-global-spinner").fadeIn();
            },

            success: function (response) {
                if (response.status !== "success") {
                    error_message(response.message || "Something went wrong!");
                    return;
                }
                post_message(response.message);
            },

            complete: function () {
                $("#nb-global-spinner").fadeOut();
                $("#srcBtn").prop("disabled", false);
                $(window).trigger("resize");
            },

            error: function (e) {
                console.log(e);
                error_message("Table API error!");
                $("#nb-global-spinner").fadeOut();
                $("#srcBtn").prop("disabled", false);
            },
        });
    }
}
