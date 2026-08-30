"use strict";
$(".select2").select2();
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
                if (response.status !== "success") return;
                $("#print_btn").removeAttr('style');
                $("#slip_row").empty();
                $("#slip_row").append('<div class="col-md-8 mb-3 align-items-center">'+
                                        '<table class="payslip">'+

                                            
                                            '<tr>'+
                                                '<td colspan="6" class="no-border">'+
                                                    '<div style="display:flex;">'+
                                                        '<div style="width:20%;">'+
                                                            '<img src="/assets/img/logo-1.png" height="20">'+
                                                        '</div>'+
                                                        '<div style="width:80%;" class="text-center">'+
                                                            '<div class="bold" style="font-size:16px;">AHEAD Initiatives'+
                                                            '</div>'+
                                                            '32/6 Gariahat Road (South), Kolkata-700031, West Bengal<br>'+
                                                            '<div class="bold" id="salary_tile">'+ response.message[0].ForMnth +'</div>'
                                                        +'</div>'+
                                                    '</div>'+
                                                '</td>'+
                                            '</tr>'+

                                            
                                            '<tr>'+
                                                '<td class="bold">Emp Code</td>'+
                                                '<td>'+ response.message[0].EmpCode +'</td>'+
                                                '<td class="bold">Emp Name</td>'+
                                                '<td colspan="3">'+ response.message[0].EmpNm +'</td>'+
                                                // '<td colspan="2"></td>'+
                                            '</tr>'+

                                            '<tr>'+
                                                '<td class="bold">Designation</td>'+
                                                '<td>'+ response.message[0].Desig +'</td>'+
                                                '<td class="bold">Father Name</td>'+
                                                '<td>'+ response.message[0].GurdNm +'</td>'+
                                                '<td class="bold">EPF No.</td>'+
                                                '<td></td>'+
                                            '</tr>'+

                                            '<tr>'+
                                                '<td class="bold">Department</td>'+
                                                '<td>'+ response.message[0].Departmnt +'</td>'+
                                                '<td class="bold">Branch</td>'+
                                                '<td>'+ response.message[0].Branch +'</td>'+
                                                '<td class="bold">ESIC No</td>'+
                                                '<td></td>'+
                                            '</tr>'+

                                            '<tr>'+
                                                '<td class="bold">Emp Type</td>'+
                                                '<td>'+ response.message[0].EmpTyp +'</td>'+
                                                '<td colspan="2"></td>'+
                                                '<td class="bold">UAN No</td>'+
                                                '<td></td>'+
                                            '</tr>'+

                                            
                                            '<tr>'+
                                                '<th rowspan="2" class="text-center" width="25%">Days</th>'+
                                                '<th colspan="3" class="text-center" width="45%">Amount</th>'+
                                                '<th colspan="2" rowspan="2" class="text-center">Deduction</th>'+
                                            '</tr>'+

                                            '<tr>'+
                                                '<th>Allowances</th>'+
                                                '<th style="text-align: right;">Rate</th>'+
                                                '<th style="text-align: right;">Earning</th>'+

                                            '</tr>'+

                                            
                                            '<tr>'+
                                                
                                                '<td style="padding:0;">'+

                                                    '<table width="100%" style="border-collapse:collapse; font-size:13px;">'+

                                                        
                                                        '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].MnthAttend +'</td>'+
                                                            '<td class="no-border"></td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border">'+
                                                              response.message[0].MnthAttendNo  +
                                                            '</td>'+
                                                        '</tr>'+

                                                        '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].MnthOffWk +'</td>'+
                                                            '<td class="no-border"></td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border">'+
                                                                response.message[0].MnthOffWkNo+
                                                            '</td>'+
                                                        '</tr>'+

                                                        '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].MnthHolD +'</td>'+
                                                            '<td class="no-border"></td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border">'+
                                                                response.message[0].MnthHolDNo+
                                                            '</td>'+
                                                        '</tr>'+

                                                        '<tr>'+
                                                           '<td style="padding:4px;" class="no-border">'+ response.message[0].LNm1 +'</td>'+
                                                            '<td class="no-border"></td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border">'+
                                                                response.message[0].LFig1+
                                                           '</td>'+
                                                        '</tr>'+

                                                        '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].LNm2 +'</td>'+
                                                            '<td class="no-border"></td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border">'+
                                                                response.message[0].LFig2+
                                                            '</td>'+
                                                        '</tr>'+

                                                       '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].LNm3 +'</td>'+
                                                            '<td class="no-border"></td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border">'+
                                                                response.message[0].LFig3+
                                                            '</td>'+
                                                        '</tr>'+

                                                        // '<tr>'+
                                                        //     '<td style="padding:4px;" class="no-border">P-Cop</td>'+
                                                        //     '<td class="no-border"></td>'+
                                                        //     '<td style="padding:4px; text-align:right;" class="no-border">'+
                                                        //         '0.00'+
                                                        //     '</td>'+
                                                        // '</tr>'+

                                                        '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].LNm4 +'</td>'+
                                                            '<td class="no-border"></td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border">'+
                                                                response.message[0].LFig4+
                                                            '</td>'+
                                                        '</tr>'+

                                                        '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].MnthWP +'</td>'+
                                                            '<td class="no-border"></td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border">'+
                                                                response.message[0].MnthWPNo+
                                                            '</td>'+
                                                        '</tr>'+

                                                        '<tr>'+
                                                            '<td style="padding:4px; font-weight:bold;" class="no-border">'+
                                                                response.message[0].MnthTD+
                                                            '</td>'+
                                                            '<td class="no-border"></td>'+
                                                            '<td style="padding:4px; text-align:right; font-weight:bold;" class="no-border">'+ response.message[0].MnthTDNo +'</td>'+
                                                        '</tr>'+

                                                        '<tr>'+
                                                            '<td style="padding:4px; font-weight:bold;" class="no-border">'+
                                                                response.message[0].MnthD+
                                                            '</td>'+
                                                            '<td class="no-border"></td>'+
                                                            '<td style="padding:4px; text-align:right; font-weight:bold;"  class="no-border">'+ response.message[0].MnthTDNo +'</td>'+
                                                        '</tr>'+



                                                        
                                                        '<tr>'+
                                                            '<td colspan="3" style="padding:4px; font-weight:bold; border-top:1px solid #000; text-align:center;">'+
                                                                'Leave Details'+
                                                            '</td>'+
                                                        '</tr>'+

                                                        
                                                        '<tr>'+
                                                            '<th class="bottom-only"></th>'+
                                                            '<th class="bottom-only text-right">Opn.</th>'+
                                                            '<th class="bottom-only text-right">Cls.</th>'+
                                                        '</tr>'+
                                                        
                                                        '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].SLNm1 +'</td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border"> '+ response.message[0].SLFigO1 +' </td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border"> '+ response.message[0].SLFigC1 +' </td>'+
                                                        '</tr>'+

                                                        '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].SLNm2 +'</td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border"> '+ response.message[0].SLFigO2 +' </td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border"> '+ response.message[0].SLFigC2 +' </td>'+
                                                        '</tr>'+

                                                        '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].SLNm3 +'</td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border"> '+ response.message[0].SLFigO3 +' </td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border"> '+ response.message[0].SLFigC3 +' </td>'+
                                                        '</tr>'+

                                                        // '<tr>'+
                                                        //     '<td style="padding:4px;" class="no-border">P-Cop</td>'+
                                                        //     '<td style="padding:4px; text-align:right;" class="no-border"> (1.00) </td>'+
                                                        //     '<td style="padding:4px; text-align:right;" class="no-border"> 0.00 </td>'+
                                                        // '</tr>'+

                                                        '<tr>'+
                                                            '<td style="padding:4px;" class="no-border">'+ response.message[0].SLNm4 +'</td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border"> '+ response.message[0].LFigO4 +' </td>'+
                                                            '<td style="padding:4px; text-align:right;" class="no-border"> '+ response.message[0].SLFigC4 +' </td>'+
                                                        '</tr>'+

                                                    '</table>'+

                                                '</td>'+

                                                
                                                '<td>'+ response.message[0].AllowNm +'<br><br>'+ response.message[0].AllowNm1 +'<br><br>'+ response.message[0].AllowNm2 +'</td>'+
                                                '<td class="text-right">'+
                                                    ''+ response.message[0].BErngs +'<br><br>'+
                                                    ''+ response.message[0].A1Erngs +'<br><br>'+
                                                    ''+ response.message[0].A2Erngs +''+
                                                '</td>'+
                                                '<td class="text-right">'+
                                                    ''+ response.message[0].BErngs +'<br><br>'+
                                                    ''+ response.message[0].A2Erngs +'<br><br>'+
                                                    ''+ response.message[0].A2Erngs +''+
                                                '</td>'+

                                                
                                                '<td colspan="2">'+
                                                    ''+ response.message[0].DedNm1 +' <span style="float:right;">'+ response.message[0].D1Amt +'</span><br>'+
                                                    ''+ response.message[0].DedNm2 +' <span style="float:right;">'+ response.message[0].D2Amt +'</span>'+
                                                '</td>'+
                                            '</tr>'+

                                            
                                            '<tr>'+
                                                '<td></td>'+
                                                '<td class="bold">Total</td>'+
                                                '<td class="text-right bold">'+ response.message[0].TErngs +'</td>'+
                                                '<td class="text-right bold">'+ response.message[0].TErngs +'</td>'+
                                                '<td class="bold">Total Deduction</td>'+
                                                '<td class="text-right bold">'+ response.message[0].TDed +'</td>'+
                                            '</tr>'+

                                            
                                            '<tr>'+
                                                '<td class="bold">Net Payable</td>'+
                                                '<td colspan="3" class="bold">'+ response.message[0].NetAmt +'</td>'+
                                                '<td class="bold">Bank Name</td>'+
                                                '<td>'+ response.message[0].BkNm +'</td>'+
                                            '</tr>'+

                                            '<tr>'+
                                                '<td colspan="4" class="bold text-center">'+ numberToIndianRupees(response.message[0].NetAmt) +'</td>'+
                                                '<td class="bold">Bank A/c no</td>'+
                                                '<td>'+ response.message[0].AcNo +'</td>'+
                                            '</tr>'+

                                        '</table>'+


                                        '<div class="text-center" style="margin-top:5px; font-size:12px;">'+
                                            'This is a System Generated salary Slip & does not require any Signature & Seal'+
                                        '</div>'+
                                        '<div>'+
                                            '<img src="/assets/img/sing.png" height="20" style="float:right;">'+
                                        '</div>'+
                                    '</div>');
                                    console.log(numberToIndianRupees(response.message[0].NetAmt));
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
}

function printSlip(){
    window.print();
}