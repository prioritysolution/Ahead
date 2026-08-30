"use strict";
$(".select2").select2();
$(document).ready(function () {
    $(document).on("input", ".only-numbers", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

    $(".bs-datepicker-format").inputmask("99/99/9999").datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        todayBtn: "linked",
        autoclose: true,
    });
    pop_edit();
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

function setDatePickerValue(selector, dateStr) {
    if (!dateStr) return;
    console.log(dateStr);
    // dateStr = "2025-12-18"
    let parts = dateStr.split("-");
    let formattedDate = parts[0] + "/" + parts[1] + "/" + parts[2]; // dd/mm/yyyy
    console.log(formattedDate);

    $(selector).datepicker("setDate", formattedDate).trigger("change");
}

function checkNull(value) {
    return value === null ||
        value === undefined ||
        value === "" ||
        value === "null"
        ? ""
        : value;
}

function getCookie(name) {
    const match = document.cookie.match(
        new RegExp("(^| )" + name + "=([^;]+)")
    );
    return match ? decodeURIComponent(match[2]) : null;
}
function deleteCookie(name) {
    document.cookie =
        name +
        "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; SameSite=Strict; Secure";
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

function pop_edit(){
    var emp_id = getCookie("edt_emp_id");
    if (emp_id != null) {
        $.ajax({
            url: baseUrl + "/Payroll/EmployeeProfile/GetEmployeeData", // Replace with your route
            type: "GET", // GET or POST
            data: { emp_id: emp_id }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                // Handle success response
                if (response.status === "success") {
                    var data = response.message;
                    if (data.length > 0) {
                        data.forEach(function (type) {
                            $("#save_btn").html(
                                '<i id="btnIcon" class="fa fa-edit"></i> Update'
                            );
                            $("#emp_id").val(type.EId);
                            $("#emp_code").val(checkNull(type.ECode));
                            $("#emp_fname").val(checkNull(type.FstNm));
                            $("#emp_mname").val(checkNull(type.MdlNm));
                            $("#emp_lname").val(checkNull(type.LstNm));
                            setDatePickerValue("#emp_dob",type.EDoB);
                            // $("#emp_dob").val(checkNull(type.EDoB));
                            $("#emp_age").val(checkNull(type.EAge));
                            $("#emp_gend").val(checkNull(type.GndrCd)).trigger('change');
                            $("#emp_res").val(checkNull(type.ERes));
                            $("#emp_qlf").val(checkNull(type.EQual));
                            // $("#emp_doj").val(checkNull(type.emp_doj));
                            setDatePickerValue("#emp_doj",type.EJDt);
                            // $("#emp_dor").val(checkNull(type.ERDt));
                            setDatePickerValue("#emp_dor",type.ERDt);
                            $("#emp_wbr").val(checkNull(type.EBrIds));
                            $("#emp_domn").val(checkNull(type.EDomain)).trigger('change');
                            $("#emp_dept").val(checkNull(type.EDept)).trigger('change');
                            $("#emp_degd").val(checkNull(type.EDesig)).trigger('change');
                            $("#emp_mob").val(checkNull(type.MobNo));
                            $("#emp_whtno").val(checkNull(type.WAppNo));
                            $("#emp_mail").val(checkNull(type.Email));
                            $("#emp_sts").val(checkNull(type.StatCd)).trigger('change');
                            $("#emp_type").val(checkNull(type.EType)).trigger('change');
                            $("#emp_br").val(checkNull(type.EBrNms));
                            $("#emp_epf").val(checkNull(type.Epf));
                            $("#emp_esic").val(checkNull(type.Esic));
                            $("#emp_uan").val(checkNull(type.Uan));
                            $("#emp_bank").val(checkNull(type.EBank));
                            $("#emp_bacct").val(checkNull(type.EAcNo));
                            $("#act_sts").val(checkNull(type.Actv)).trigger('change');
                        });
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
                // deleteCookie("edt_emp_id");
                $("#nb-global-spinner").fadeOut();
            },
        });
    }
}

function cal_age(p) {
    if (p != "") {
        var dobStr = format_date(p); // "yyyy-mm-dd"
        var dob = new Date(dobStr);
        var curr_date = new Date();
        var age = curr_date.getFullYear() - dob.getFullYear();
        var monthDiff = curr_date.getMonth() - dob.getMonth();

        if (
            monthDiff < 0 ||
            (monthDiff === 0 && curr_date.getDate() < dob.getDate())
        ) {
            age--;
        }

        $("#emp_age").val(age);
    }
}

function post_emp() {
    var emp_id = $("#emp_id").val();
    var emp_code = $("#emp_code").val();
    var emp_fname = $("#emp_fname").val();
    var emp_mname = $("#emp_mname").val();
    var emp_lname = $("#emp_lname").val();
    var emp_dob = $("#emp_dob").val();
    var emp_age = $("#emp_age").val();
    var emp_gend = $("#emp_gend").val();
    var emp_res = $("#emp_res").val();
    var emp_qlf = $("#emp_qlf").val();
    var emp_doj = $("#emp_doj").val();
    var emp_ret = $("#emp_dor").val();
    var emp_wbr = $("#emp_wbr").val();
    var emp_dom = $("#emp_domn").val();
    var emp_dep = $("#emp_dept").val();
    var emp_deg = $("#emp_degd").val();
    var emp_mob = $("#emp_mob").val();
    var emp_wno = $("#emp_whtno").val();
    var emp_mail = $("#emp_mail").val();
    var emp_sts = $("#emp_sts").val();
    var emp_type = $("#emp_type").val();
    var emp_branch = $("#emp_br").val();
    var emp_epf = $("#emp_epf").val();
    var emp_esic = $("#emp_esic").val();
    var emp_uan = $("#emp_uan").val();
    var emp_bank = $("#emp_bank").val();
    var emp_bacno = $("#emp_bacct").val();
    var emp_active = $("#act_sts").val();

    if (emp_code == "") {
        warning_alert("Please Enter Employee Code !");
    } else if (emp_fname == "" && emp_lname == "") {
        warning_alert("Please Enter Employee Name !");
    } else if (emp_dob == "") {
        warning_alert("Please Enter Employee Date Of Birth !");
    } else if (emp_age <= 0) {
        warning_alert("Employee Age Cannot Be Zero !");
    } else if (emp_gend == null) {
        warning_alert("Please Select Employee Gender !");
    } else if (emp_doj == "") {
        warning_alert("Please Enter Employee joining Date !");
    } else if (emp_ret == "") {
        warning_alert("Please Enter Employee Retirement Date !");
    } else if (emp_dom == null) {
        warning_alert("Please Select Domain !");
    } else if (emp_dep == null) {
        warning_alert("Please Select Employee Depertment !");
    } else if (emp_deg == null) {
        warning_alert("Please Select Employee Designation !");
    } else if (emp_mob == "") {
        warning_alert("Please Enter Mobile No !");
    } else if (emp_sts == null) {
        warning_alert("Please Select Employee Status !");
    } else if (emp_type == null) {
        warning_alert("Please Select Employee Type !");
    } else if (emp_branch == "") {
        warning_alert("Please Enter Employee Branch !");
    }
    else if(emp_active==null){
        warning_alert("Please Select Employee Status !");
    }
     else {
        $.ajax({
            url: baseUrl + "/Payroll/EmployeeProfile/Appointment/AddEmployee", // Replace with your route
            type: "POST", // GET or POST
            data: {
                emp_code: emp_code,
                emp_fname: emp_fname,
                emp_mname: emp_mname,
                emp_lname: emp_lname,
                emp_dob: format_date(emp_dob),
                emp_age: emp_age,
                emp_gend: emp_gend,
                emp_res: emp_res,
                emp_qlf: emp_qlf,
                emp_doj: format_date(emp_doj),
                emp_ret: format_date(emp_ret),
                emp_wbr: emp_wbr,
                emp_dom: emp_dom,
                emp_dep: emp_dep,
                emp_deg: emp_deg,
                emp_mob: emp_mob,
                emp_wno: emp_wno,
                emp_mail: emp_mail,
                emp_sts: emp_sts,
                emp_type: emp_type,
                emp_branch: emp_branch,
                emp_epf: emp_epf,
                emp_esic: emp_esic,
                emp_uan: emp_uan,
                emp_bank: emp_bank,
                emp_bacno: emp_bacno,
                emp_id: emp_id,
                emp_active:emp_active
            }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                if (response.status === "success") {
                    var data = response.message;
                    Swal.fire({
                        title: "Success",
                        text: data,
                        icon: "success",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace(baseUrl + "/employeelist");
                        }
                    });
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
