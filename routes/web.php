<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProcessLogin;
use App\Http\Controllers\payrool\ProcessPayrool;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('customeGuest')->group(function () {
    Route::get('/', [ProcessLogin::class, 'showLogin'])->name('login');
    Route::post('/UserLogin', [ProcessLogin::class, 'process_login']);
});




Route::middleware('customeAuth')->group(function () {

    Route::get('/logout', [ProcessLogin::class, 'process_logout'])->name('logout');
    Route::get('/Dashboard', [ProcessLogin::class, 'show_dashboard'])->name('Home');
    Route::get('/User/PasswordUpdate', [ProcessLogin::class, 'process_updpass'])->name('cng-pass');
    Route::post('/User/UpdatePassword', [ProcessLogin::class, 'process_cng_pass']);

    // Payroll
    Route::get('/employeelist', [ProcessPayrool::class, 'get_emplist'])->name('emplist');
    Route::post('/ProcessAttandance/PunchIn', [ProcessPayrool::class, 'process_punch_in']);
    Route::post('/ProcessAttandance/PunchOut', [ProcessPayrool::class, 'process_punch_out']);
    Route::get('/ProcessAttandance/ManualAttandance', [ProcessPayrool::class, 'get_manattand'])->name('manAttnd');
    Route::get('/Report/GetAttandanceDetails', [ProcessPayrool::class, 'gen_attn_rpt'])->name('rpt_getattnd');
    Route::get('/Report/ProcessAttendDetails', [ProcessPayrool::class, 'process_rpt_attnd']);
    Route::get('/ProcessAttandance/CheckAttend', [ProcessPayrool::class, 'check_attend']);
    Route::post('/ProcessAttandance/ManPunchIn', [ProcessPayrool::class, 'process_man_punchin']);
    Route::post('/ProcessAttandance/ManPunchOut', [ProcessPayrool::class, 'process_man_punchout']);
    Route::get('/Payroll/YearCalender', [ProcessPayrool::class, 'year_cal_index'])->name('year-calender');
    Route::get('/Payroll/GetCalenderData', [ProcessPayrool::class, 'get_cal_data']);
    Route::post('/Payroll/ProcessWorkCalender', [ProcessPayrool::class, 'process_wrk_cal']);
    Route::get('/Payroll/LeaveSetup', [ProcessPayrool::class, 'leave_setup_index'])->name('leave-setup');
    Route::get('/Payroll/LeaveSetup/GetLeaveType', [ProcessPayrool::class, 'get_leave_type']);
    Route::post('/Payroll/LeaveSetup/ProcessLeaveSetup', [ProcessPayrool::class, 'process_lev_setup']);
    Route::get('/Payroll/LeaveEntitlementInitialization', [ProcessPayrool::class, 'leave_init_index'])->name('leave-init');
    Route::get('/Payroll/LeaveEntitlementInitialization/LeaveAllow', [ProcessPayrool::class, 'get_leave_allow']);
    Route::post('/Payroll/LeaveEntitlementInitialization/UpdateSetup', [ProcessPayrool::class, 'process_lev_init']);
    Route::get('/Payroll/EmployeeLeaveOpening', [ProcessPayrool::class, 'emp_lev_opn_index'])->name('emp-lv-opn');
    Route::get('/Payroll/EmployeeLeaveOpening/GetLeaveData', [ProcessPayrool::class, 'get_leave_opbalance']);
    Route::post('/Payroll/EmployeeLeaveOpening/PostOpnLeave', [ProcessPayrool::class, 'process_opn_leave']);
    Route::get('/Payroll/LeaveRequisition', [ProcessPayrool::class, 'leave_req_index'])->name('leave-req');
    Route::get('/Payroll/LeaveRequisition/GetApplData',[ProcessPayrool::class,'get_appl_data']);
    Route::get('/Payroll/LeaveRequisition/GetLeaveBalance',[ProcessPayrool::class,'get_leave_balance']);
    Route::post('/Payroll/LeaveRequisition/ProcessRequisition',[ProcessPayrool::class,'process_lev_req']);
    Route::get('/Payroll/LeaveApproval',[ProcessPayrool::class,'lev_apprv_index'])->name('lev-apprv');
    Route::post('/Payroll/LeaveApproval/ApproveRejectLeave',[ProcessPayrool::class,'process_lev_apprvl']);
    Route::get('/Payroll/Allowances',[ProcessPayrool::class,'emp_allow_index'])->name('emp-allow-ns');
    Route::get('/Payroll/Allowances/GetData',[ProcessPayrool::class,'get_allowns_data']);
    Route::post('/Payroll/Allowances/PostAllowance',[ProcessPayrool::class,'process_allowance']);
    Route::get('/Payroll/Deductions',[ProcessPayrool::class,'emp_ded_index'])->name('emp-ded');
    Route::get('/Payroll/Deductions/GetData',[ProcessPayrool::class,'get_ded_data']);
    Route::post('/Payroll/Deductions/PostDeduction',[ProcessPayrool::class,'process_deduction']);
    Route::get('/Payroll/EmployeeProfile/Appointment',[ProcessPayrool::class,'emp_app_index']);
    Route::post('/Payroll/EmployeeProfile/Appointment/AddEmployee',[ProcessPayrool::class,'process_employee']);
    Route::get('/Payroll/EmployeeProfile/GetEmployeeData',[ProcessPayrool::class,'get_emp_data']);
    Route::get('/Payroll/HolidayCalender',[ProcessPayrool::class,'get_holiday_calender'])->name('holi-calender');
    Route::get('/Payroll/MonthlyAttandance',[ProcessPayrool::class,'mnattnd_indedx'])->name('attnd-month');
    Route::get('/Payroll/MonthlyAttandance/GetDetails',[ProcessPayrool::class,'get_mnattnd_data']);
    Route::get('/Payroll/MonthlyAttandance/GetOptions',[ProcessPayrool::class,'get_drp_options']);
    Route::get('/Payroll/MonthlyAttandance/GetSavedAttendance',[ProcessPayrool::class,'get_saved_attnd']);
    Route::post('/Payroll/MonthlyAttandance/PostAttandance',[ProcessPayrool::class,'process_mn_attnd']);
    Route::get('/Payroll/GeneratePayslip',[ProcessPayrool::class,'payslip_index'])->name('gen-payslip');
    Route::get('/Payroll/GetPayslipData',[ProcessPayrool::class,'generate_payslip']);
});
