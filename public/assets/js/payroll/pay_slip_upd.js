"use strict";
$(document).ready(function () {
    $(document).on("input", ".only-decimal", function () {
        let value = this.value.replace(/[^0-9.]/g, "");

        if (value.indexOf(".") !== value.lastIndexOf(".")) {
            value = value.slice(0, value.lastIndexOf("."));
        }

        if (value.includes(".")) {
            let parts = value.split(".");
            value = parts[0] + "." + (parts[1] || "").slice(0, 2);
        }

        this.value = value;
    });
});

$(".select2").select2();

function applyInputEditability() {
    $(".pay-allow-rate").each(function () {
        $(this).prop("readonly", true).addClass("bg-light");
    });

    $(".pay-allow-earning, .pay-deduction-value").each(function () {
        $(this).prop("readonly", false).removeClass("bg-light");
    });
}

$(document).on("input", ".pay-allow-rate", function () {
    const value = cleanDecimalInput($(this).val());
    $(this).val(value);

    const index = $(".pay-allow-rate").index(this);
    const earningInput = $(".pay-allow-earning").eq(index);
    if (earningInput.length) {
        earningInput.val(value);
    }

    applyInputEditability();
    recalculatePayslipTotals();
});

$(document).on("input", ".pay-allow-earning, .pay-deduction-value", function () {
    const value = cleanDecimalInput($(this).val());
    $(this).val(value);
    applyInputEditability();
    recalculatePayslipTotals();
});

function cleanDecimalInput(value) {
    if (value === null || value === undefined || value === "") {
        return "";
    }

    let cleaned = String(value).replace(/[^0-9.]/g, "");
    if (cleaned.indexOf(".") !== cleaned.lastIndexOf(".")) {
        cleaned = cleaned.slice(0, cleaned.lastIndexOf("."));
    }

    if (cleaned.includes(".")) {
        let parts = cleaned.split(".");
        cleaned = parts[0] + "." + (parts[1] || "").slice(0, 2);
    }

    return cleaned;
}

function formatMoney(value) {
    const num = Number.parseFloat(String(value || 0).replace(/,/g, ""));
    if (Number.isNaN(num)) return "0.00";
    return num.toFixed(2);
}

function getAllowanceRows(data) {
    const rows = [
        { name: data.AllowNm, rate: cleanDecimalInput(data.BRate || "0"), earning: cleanDecimalInput(data.BErngs || "0") },
        { name: data.AllowNm1, rate: "0", earning: cleanDecimalInput(data.A1Erngs || "0") },
        { name: data.AllowNm2, rate: "0", earning: cleanDecimalInput(data.A2Erngs || "0") },
        { name: data.AllowNm3, rate: "0", earning: cleanDecimalInput(data.A3Erngs || "0") }
    ];

    return rows.filter(function (row) {
        const name = String(row.name || "").trim();
        const validName = name && name !== "null" && name !== "undefined";
        const hasAmount = String(row.earning || row.rate || "").trim() !== "" && parseFloat(cleanDecimalInput(row.earning || row.rate || 0)) > 0;
        return validName || hasAmount;
    });
}

function getDeductionRows(data) {
    return [
        { name: data.DedNm1, value: data.D1Amt || "0" },
        { name: data.DedNm2, value: data.D2Amt || "0" }
    ].filter(row => row.name && row.name !== "null" && row.name !== "undefined");
}

function recalculatePayslipTotals() {
    const allowanceInputs = $("#slip_row .pay-allow-rate");
    const deductionInputs = $("#slip_row .pay-deduction-value");
    const earningInputs = $("#slip_row .pay-allow-earning");

    let allowanceTotal = 0;
    earningInputs.each(function () {
        const value = cleanDecimalInput($(this).val());
        const numeric = parseFloat(value || 0);
        $(this).val(value);
        allowanceTotal += Number.isNaN(numeric) ? 0 : numeric;
    });

    let deductionTotal = 0;
    deductionInputs.each(function () {
        const value = cleanDecimalInput($(this).val());
        const numeric = parseFloat(value || 0);
        $(this).val(value);
        deductionTotal += Number.isNaN(numeric) ? 0 : numeric;
    });

    const netPayable = allowanceTotal - deductionTotal;

    $("#payslip-total-earning").text(formatMoney(allowanceTotal));
    $("#payslip-total-deduction").text(formatMoney(deductionTotal));
    $("#payslip-net-payable").text(formatMoney(netPayable));
    $("#payslip-net-words").text(numberToIndianRupees(netPayable));

    applyInputEditability();
}

function numberToIndianRupees(num) {
    if (num === 0) return "Zero Rupees Only";

    var a = [
        '', 'One ', 'Two ', 'Three ', 'Four ', 'Five ', 'Six ',
        'Seven ', 'Eight ', 'Nine ', 'Ten ', 'Eleven ', 'Twelve ',
        'Thirteen ', 'Fourteen ', 'Fifteen ', 'Sixteen ',
        'Seventeen ', 'Eighteen ', 'Nineteen '
    ];

    var b = [
        '', '', 'Twenty ', 'Thirty ', 'Forty ', 'Fifty ',
        'Sixty ', 'Seventy ', 'Eighty ', 'Ninety '
    ];

    function inWords(n) {
        if (n < 20) return a[n];
        if (n < 100) return b[Math.floor(n / 10)] + a[n % 10];
        if (n < 1000) return a[Math.floor(n / 100)] + 'Hundred ' + inWords(n % 100);
        if (n < 100000) return inWords(Math.floor(n / 1000)) + 'Thousand ' + inWords(n % 1000);
        if (n < 10000000) return inWords(Math.floor(n / 100000)) + 'Lakh ' + inWords(n % 100000);
        return inWords(Math.floor(n / 10000000)) + 'Crore ' + inWords(n % 10000000);
    }

    var parts = num.toString().split(".");
    var rupees = parseInt(parts[0]);
    var paisa = parts[1] ? parseInt((parts[1] + "00").substring(0, 2)) : 0;

    var result = '';

    if (rupees > 0) {
        result += inWords(rupees) + "Rupees ";
    }

    if (paisa > 0) {
        result += "and " + inWords(paisa) + "Paisa ";
    }

    return result.trim() + " Only";
}

function getNumericInputValue(selector, index) {
    const value = cleanDecimalInput($(selector).eq(index).val());
    return Number.parseFloat(value || 0) || 0;
}

function resetPayslipForm() {
    $("#mn_id, #yer_id, #emp_id").val("").trigger("change");
    $("#slip_row").empty();
}

function updatePayslip() {
    if (!$("#slip_row .payslip").length) {
        warning_alert("Please search and load a payslip first !!");
        return;
    }

    const allowanceRows = getAllowanceRows(window.currentPayslipData || {});
    const earnings = [];

    allowanceRows.forEach(function (row, index) {
        earnings.push({
            name: row.name || "",
            rate: getNumericInputValue(".pay-allow-rate", index),
            amount: getNumericInputValue(".pay-allow-earning", index)
        });
    });

    const basic = earnings.length ? earnings[0].amount : 0;
    const allow1 = earnings.length > 1 ? earnings[1].amount : 0;
    const allow2 = earnings.length > 2 ? earnings[2].amount : 0;
    const allow3 = earnings.length > 3 ? earnings[3].amount : 0;
    const ded1 = getNumericInputValue(".pay-deduction-value", 0);
    const ded2 = getNumericInputValue(".pay-deduction-value", 1);
    const totalEarnings = basic + allow1 + allow2 + allow3;
    const totalDeduction = ded1 + ded2;
    const netAmount = totalEarnings - totalDeduction;
    const jsonData = {
        Basic: basic,
        Allow1Amt: allow1,
        Allow2Amt: allow2,
        Allow3Amt: allow3,
        TotErngs: totalEarnings,
        Ded1Amt: ded1,
        Ded2Amt: ded2,
        TotDed: totalDeduction,
        NetAmt: netAmount,
        AmtWrd: numberToIndianRupees(netAmount)
    };
    const updatePayload = {
        EmpId: $("#emp_id").val(),
        MonthSl: $("#mn_id").val(),
        YrSl: $("#yer_id").val(),
        JsonData: JSON.stringify([jsonData])
    };

    $.ajax({
        url: baseUrl + "/Payroll/UpdatePayslip/Save",
        type: "POST",
        dataType: "json",
        data: Object.assign({
            _token: $("meta[name='csrf-token']").attr("content")
        }, updatePayload),
        beforeSend: function () {
            $("#nb-global-spinner").fadeIn();
        },
        success: function (response) {
            if (response.status === "success") {
                noload_success(response.message);
                resetPayslipForm();
                window.currentPayslipData = null;
            } else {
                error_message(response.message || "Payslip update failed!");
            }
        },
        error: function (xhr) {
            const response = xhr.responseJSON || {};
            error_message(response.message || "Payslip update failed!");
        },
        complete: function () {
            $("#nb-global-spinner").fadeOut();
        }
    });
}

function gen_slip() {
    var mn = $("#mn_id").val();
    var yr = $("#yer_id").val();
    var emp = $("#emp_id").val();

    if (mn == null) {
        warning_alert("Please Select Month !!");
    } else if (yr == null) {
        warning_alert("Please Select Year !!");
    } else if (emp == null) {
        warning_alert("Please Select Employee !!");
    } else {
        $.ajax({
            url: baseUrl + "/Payroll/GetPayslipData",
            type: "GET",
            data: { emp_id: emp, month: mn, year: yr },
            dataType: "json",

            beforeSend: function () {
                $("#nb-global-spinner").fadeIn();
            },

            success: function (response) {
                if (!response || response.status !== "success") {
                    error_message(response && response.message ? response.message : "Payslip data could not be loaded!");
                    return;
                }

                if (!Array.isArray(response.message) || !response.message.length || !response.message[0]) {
                    $("#slip_row").empty();
                    window.currentPayslipData = null;
                    error_message("No payslip data found for the selected month, year, and employee!");
                    return;
                }

                window.currentPayslipData = response.message[0];
                $("#print_btn").removeAttr('style');
                $("#slip_row").empty();
                $("#slip_row").append('<div class="col-md-8 mb-3 align-items-center">' +
                    '<table class="payslip">' +
                    '<tr>' +
                    '<td colspan="6" class="no-border">' +
                    '<div style="display:flex;">' +
                    '<div style="width:20%;"><img src="/assets/img/logo-1.png" height="20"></div>' +
                    '<div style="width:80%;" class="text-center">' +
                    '<div class="bold" style="font-size:16px;">AHEAD Initiatives</div>' +
                    '32/6 Gariahat Road (South), Kolkata-700031, West Bengal<br>' +
                    '<div class="bold" id="salary_tile">Salary Slip For The Month Of ' + String($("#mn_id option:selected").text()).trim().toUpperCase() + ' ' + String($("#yer_id option:selected").text()).trim() + '</div>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="bold">Emp Code</td>' +
                    '<td>' + response.message[0].EmpCode + '</td>' +
                    '<td class="bold">Emp Name</td>' +
                    '<td colspan="3">' + response.message[0].EmpNm + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="bold">Designation</td>' +
                    '<td>' + response.message[0].Desig + '</td>' +
                    '<td class="bold">Father Name</td>' +
                    '<td>' + response.message[0].GurdNm + '</td>' +
                    '<td class="bold">EPF No.</td>' +
                    '<td></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="bold">Department</td>' +
                    '<td>' + response.message[0].Departmnt + '</td>' +
                    '<td class="bold">Branch</td>' +
                    '<td>' + response.message[0].Branch + '</td>' +
                    '<td class="bold">ESIC No</td>' +
                    '<td></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="bold">Emp Type</td>' +
                    '<td>' + response.message[0].EmpTyp + '</td>' +
                    '<td colspan="2"></td>' +
                    '<td class="bold">UAN No</td>' +
                    '<td></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<th rowspan="2" class="text-center" width="25%">Days</th>' +
                    '<th colspan="3" class="text-center" width="45%">Amount</th>' +
                    '<th colspan="2" rowspan="2" class="text-center">Deduction</th>' +
                    '</tr>' +
                    '<tr>' +
                    '<th class="text-center">Allowances</th>' +
                    '<th class="text-center">Rate</th>' +
                    '<th class="text-center">Earning</th>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="padding:0;">' +
                    '<table width="100%" style="border-collapse:collapse; font-size:13px;">' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].MnthAttend + '</td><td class="no-border"></td><td style="padding:4px; text-align:right;" class="no-border">' + response.message[0].MnthAttendNo + '</td></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].MnthOffWk + '</td><td class="no-border"></td><td style="padding:4px; text-align:right;" class="no-border">' + response.message[0].MnthOffWkNo + '</td></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].MnthHolD + '</td><td class="no-border"></td><td style="padding:4px; text-align:right;" class="no-border">' + response.message[0].MnthHolDNo + '</td></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].LNm1 + '</td><td class="no-border"></td><td style="padding:4px; text-align:right;" class="no-border">' + response.message[0].LFig1 + '</td></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].LNm2 + '</td><td class="no-border"></td><td style="padding:4px; text-align:right;" class="no-border">' + response.message[0].LFig2 + '</td></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].LNm3 + '</td><td class="no-border"></td><td style="padding:4px; text-align:right;" class="no-border">' + response.message[0].LFig3 + '</td></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].LNm4 + '</td><td class="no-border"></td><td style="padding:4px; text-align:right;" class="no-border">' + response.message[0].LFig4 + '</td></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].MnthWP + '</td><td class="no-border"></td><td style="padding:4px; text-align:right;" class="no-border">' + response.message[0].MnthWPNo + '</td></tr>' +
                    '<tr><td style="padding:4px; font-weight:bold;" class="no-border">' + response.message[0].MnthTD + '</td><td class="no-border"></td><td style="padding:4px; text-align:right; font-weight:bold;" class="no-border">' + response.message[0].MnthTDNo + '</td></tr>' +
                    '<tr><td style="padding:4px; font-weight:bold;" class="no-border">' + response.message[0].MnthD + '</td><td class="no-border"></td><td style="padding:4px; text-align:right; font-weight:bold;" class="no-border">' + response.message[0].MnthTDNo + '</td></tr>' +
                    '<tr><td colspan="3" style="padding:4px; font-weight:bold; border-top:1px solid #000; text-align:center;">Leave Details</td></tr>' +
                    '<tr><th class="bottom-only"></th><th class="bottom-only text-right">Opn.</th><th class="bottom-only text-right">Cls.</th></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].SLNm1 + '</td><td style="padding:4px; text-align:right;" class="no-border"> ' + response.message[0].SLFigO1 + ' </td><td style="padding:4px; text-align:right;" class="no-border"> ' + response.message[0].SLFigC1 + ' </td></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].SLNm2 + '</td><td style="padding:4px; text-align:right;" class="no-border"> ' + response.message[0].SLFigO2 + ' </td><td style="padding:4px; text-align:right;" class="no-border"> ' + response.message[0].SLFigC2 + ' </td></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].SLNm3 + '</td><td style="padding:4px; text-align:right;" class="no-border"> ' + response.message[0].SLFigO3 + ' </td><td style="padding:4px; text-align:right;" class="no-border"> ' + response.message[0].SLFigC3 + ' </td></tr>' +
                    '<tr><td style="padding:4px;" class="no-border">' + response.message[0].SLNm4 + '</td><td style="padding:4px; text-align:right;" class="no-border"> ' + response.message[0].LFigO4 + ' </td><td style="padding:4px; text-align:right;" class="no-border"> ' + response.message[0].SLFigC4 + ' </td></tr>' +
                    '</table>' +
                    '</td>' +
                    '<td style="vertical-align:top;">' +
                    '<div style="display:flex; flex-direction:column; gap:8px;">' +
                    getAllowanceRows(response.message[0]).map(function (row) {
                        return '<div style="min-height:32px; display:flex; align-items:center;">' + (row.name || '') + '</div>';
                    }).join('') +
                    '</div>' +
                    '</td>' +
                    '<td class="text-right" style="vertical-align:top;">' +
                    '<div style="display:flex; flex-direction:column; gap:8px;">' +
                    getAllowanceRows(response.message[0]).map(function (row) {
                        return '<div style="min-height:32px; display:flex; align-items:center; justify-content:flex-end;"><input type="text" readonly class="pay-allow-rate only-decimal form-control form-control-sm bg-light" value="' + cleanDecimalInput(row.rate || row.earning || "0") + '" style="width:100%; min-width:90px; max-width:120px; text-align:right; height:32px; margin:0;" inputmode="decimal"></div>';
                    }).join('') +
                    '</div>' +
                    '</td>' +
                    '<td class="text-right" style="vertical-align:top;">' +
                    '<div style="display:flex; flex-direction:column; gap:8px;">' +
                    getAllowanceRows(response.message[0]).map(function (row) {
                        return '<div style="min-height:32px; display:flex; align-items:center; justify-content:flex-end;"><input type="text" class="pay-allow-earning only-decimal form-control form-control-sm" value="' + cleanDecimalInput(row.earning || row.rate || "0") + '" style="width:100%; min-width:90px; max-width:120px; text-align:right; height:32px; margin:0;" inputmode="decimal"></div>';
                    }).join('') +
                    '</div>' +
                    '</td>' +
                    '<td colspan="2" style="vertical-align:top;">' +
                    '<div style="display:flex; flex-direction:column; gap:8px;">' +
                    getDeductionRows(response.message[0]).map(function (row) {
                        return '<div style="min-height:32px; display:flex; align-items:center; justify-content:space-between; gap:8px;"><span>' + (row.name || '') + '</span><input type="text" class="pay-deduction-value only-decimal form-control form-control-sm" value="' + cleanDecimalInput(row.value) + '" style="width:100px; text-align:right; height:32px; margin:0;" inputmode="decimal"></div>';
                    }).join('') +
                    '</div>' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td></td>' +
                    '<td class="bold">Total</td>' +
                    '<td class="text-right bold"></td>' +
                    '<td class="text-right bold" id="payslip-total-earning">' + formatMoney(response.message[0].TErngs || 0) + '</td>' +
                    '<td class="bold">Total Deduction</td>' +
                    '<td class="text-right bold" id="payslip-total-deduction">' + formatMoney(response.message[0].TDed || 0) + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="bold">Net Payable</td>' +
                    '<td colspan="3" class="bold text-right" id="payslip-net-payable">' + formatMoney(response.message[0].NetAmt || 0) + '</td>' +
                    '<td class="bold">Bank Name</td>' +
                    '<td>' + response.message[0].BkNm + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td colspan="4" class="bold text-center" id="payslip-net-words">' + numberToIndianRupees(response.message[0].NetAmt || 0) + '</td>' +
                    '<td class="bold">Bank A/c no</td>' +
                    '<td>' + response.message[0].AcNo + '</td>' +
                    '</tr>' +
                    '</table>' +
                    '<div class="text-center" style="margin-top:5px; font-size:12px;">This is a System Generated salary Slip & does not require any Signature & Seal</div>' +
                    '<div><img src="/assets/img/sing.png" height="20" style="float:right;"></div>' +
                    '</div>');

                applyInputEditability();
            },

            complete: function () {
                $("#nb-global-spinner").fadeOut();
            },

            error: function () {
                error_message("Saved attendance load error!");
                $("#nb-global-spinner").fadeOut();
            }
        });
    }
}

function printSlip() {
    window.print();
}
