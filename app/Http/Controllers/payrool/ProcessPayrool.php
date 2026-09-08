<?php

namespace App\Http\Controllers\payrool;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;
use Carbon\Carbon;
use App\Traits\fileupload;

class ProcessPayrool extends Controller
{
    use FileUpload;
    public function get_emplist()
    {
        try {
            $emp_list = DB::select('Call usp_ViewEmployeeList(?);', [0]);
            $title = config('app.name') . ' | Employee List';

            return view('payroll.employeelist', compact('emp_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.employeelist', [
                'emp_list' => [],  // empty list so view doesn’t break
                'title'     => config('app.name') . ' | Employee List',
                'error'     => 'Something Went To Wrong !!'
            ]);
        }
    }

    public function process_punch_in(Request $request)
    {
        try {
            $now = Carbon::now('Asia/Kolkata');
            $pAttendDate = $now->toDateString();
            $pAttendDateFormatted = $now->format('d-m-Y');
            $pAttendTime = $now->format('H:i:s');
            $pAttendTime12 = $now->format('h:i:s A');
            // $pAttendDate = Carbon::parse($pAttendDate)->format('Y-m-d');
            // $pAttendTime = Carbon::parse($pAttendTime)->format('H:i:s');

            $pPunchIn = DB::select("Call usp_InsertAttendance(?,?,?,?,?,?,?);", [Session::get('EmpId'), $request->pEmpStatus, null, $pAttendDate, $pAttendTime, $request->pEmpPunchIn, Session::get('User_Id')]);

            if (empty($pPunchIn)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Attend Is Not Completed !!'
                ], 401);
            }
            Session::put('IsAttend', 1);
            Session::put('AttendDate', $pAttendDateFormatted);
            Session::put('AttendTime', $pAttendTime12);

            return response()->json([
                'status' => 'success',
                'message' => 'Thank You Have A Great Day !!',
                'AttendDate' => Session::get('AttendDate'),
                'AttendTime' => Session::get('AttendTime')
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function process_punch_out(Request $request)
    {
        try {
            $now = Carbon::now('Asia/Kolkata');
            $pAttendDate = $now->toDateString();
            $pAttendTime = $now->format('H:i:s');
            // $pAttendDate = Carbon::parse($pAttendDate)->format('Y-m-d');
            // $pAttendTime = Carbon::parse($pAttendTime)->format('H:i:s');

            $pPunchIn = DB::select("Call usp_InsertCheckOut(?,?,?,?,?);", [Session::get('EmpId'), $pAttendDate, $pAttendTime, $request->pEmpPunchOut, Session::get('User_Id')]);

            if (empty($pPunchIn)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Attend Is Not Completed !!'
                ], 401);
            }
            Session::forget('IsAttend');
            Session::forget('AttendDate');
            Session::forget('AttendTime');

            return response()->json([
                'status' => 'success',
                'message' => 'Good By !!'
            ], 200);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function get_manattand()
    {
        try {
            $title = config('app.name') . ' | Post Attandance';

            $emp_List = DB::select("Call usp_getEmployeeList(?);", [Session::get('User_Id')]);
            $ststus = DB::select("Call usp_getOptionList(12);");

            return view('payroll.manualattand', compact('emp_List', 'ststus', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.manualattand', [
                'emp_List' => [],  // empty list so view doesn’t break
                'ststus' => [],
                'title'     => config('app.name') . ' | Post Attandance',
                'error'     => 'Something Went To Wrong !!'
            ]);
        }
    }

    public function gen_attn_rpt()
    {
        try {
            $title = config('app.name') . ' | Attandance Report';
            $emp_list = DB::Select("Call usp_getEmployeeList(?);", [Session::get('User_Id')]);

            return view('payroll.rptattnd', compact('emp_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.rptattnd', [
                'emp_list' => [],  // empty list so view doesn’t break
                'title'     => config('app.name') . ' | Attandance Report',
                'error'     => 'Something Went To Wrong !!'
            ]);
        }
    }

    public function process_rpt_attnd(Request $request)
    {
        try {

            $validated = $request->validate([
                'pFrm_Date'      => 'required|date',
                'pTo_Date'       => 'required|date',
                'pEmp_Id'       => 'required|integer'
            ]);

            $data = DB::select("Call usp_getAttendance(?,?,?,?);", [$validated['pFrm_Date'], $validated['pTo_Date'], $validated['pEmp_Id'], Session::get('User_Id')]);
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function check_attend(Request $request)
    {
        try {

            $validated = $request->validate([
                'pCHeckAttend'       => 'required|integer'
            ]);
            $check = DB::select("Call usp_getAttendanceStatus(?);", [$validated['pCHeckAttend']]);
            return response()->json([
                'status' => 'success',
                'data' => $check
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function process_man_punchin(Request $request)
    {
        try {

            $validated = $request->validate([
                'pEmp_Id'       => 'required|integer',
                'pEmpStatus'    => 'required|integer',
                'pAttendDate'  => 'required|date',
                'pPunchTime'    => 'required|date_format:H:i'
            ]);

            $pPunchIn = DB::select("Call usp_InsertAttendance(?,?,?,?,?,?,?);", [$validated['pEmp_Id'], $validated['pEmpStatus'], null, $validated['pAttendDate'], $validated['pPunchTime'] ?? null, $request->pRemarks, Session::get('User_Id')]);
            if (!empty($request->pPunchOutTime)) {
                $punchOut = DB::select("Call usp_InsertCheckOut(?,?,?,?,?);", [$validated['pEmp_Id'], $validated['pAttendDate'], $request->pPunchOutTime, null, Session::get('User_Id')]);

                if (empty($pPunchIn)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Attend Is Not Completed !!'
                    ], 401);
                }
            }

            if (empty($pPunchIn)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Attend Is Not Completed !!'
                ], 401);
            }


            return response()->json([
                'status' => 'success',
                'message' => 'Attandance Posted Is Successful !!',

            ], 200);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function process_man_punchout(REquest $request)
    {
        try {

            $validated = $request->validate([
                'pEmp_Id'       => 'required|integer',
                'pAttendDate'  => 'required|date',
                'pPunchOutTime'    => 'required|date_format:H:i'
            ]);


            $pPunchIn = DB::select("Call usp_InsertCheckOut(?,?,?,?,?);", [$validated['pEmp_Id'], $validated['pAttendDate'], $validated['pPunchOutTime'], $request->pRemarks, Session::get('User_Id')]);

            if (empty($pPunchIn)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Attend Is Not Completed !!'
                ], 401);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Punch Out Is Successful !!'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function year_cal_index()
    {
        try {
            // Try to load year list
            $year_list = DB::select('CALL usp_VwFinYear()');

            $title = config('app.name') . ' | Working Calendar';

            // Return view normally
            return view('payroll.yearcalender', compact('year_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.yearcalender', [
                'year_list' => [],  // empty list so view doesn’t break
                'title'     => config('app.name') . ' | Working Calendar',
                'error'     => 'Something Went To Wrong !!'
            ]);
        }
    }

    public function get_cal_data(Request $request)
    {
        try {

            $validated = $request->validate([
                'pYear_Id'      => 'required|integer',
            ]);

            $result = DB::select("CALL usp_VwCalendarData(?)", [
                $validated['pYear_Id']
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => $result
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function process_wrk_cal(Request $request)
    {
        try {

            $validated = $request->validate([
                'pYear_Id'      => 'required|integer',
                'tblData' => 'required|json'
            ]);

            DB::statement("CALL usp_InsertUpdtCalendarData(?,?)", [
                $validated['pYear_Id'],
                $validated['tblData']
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Working Calender Is Successfully Updated !!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function leave_setup_index()
    {
        try {
            // Try to load year list
            $leave_type = DB::select('CALL usp_VwLeaveTypeAll()');
            $val_list = DB::select('Call usp_getOptionList (13);');

            $title = config('app.name') . ' | Leave Setup';

            // Return view normally
            return view('payroll.leavesetup', compact('leave_type', 'title', 'val_list'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.leavesetup', [
                'leave_type' => [],  // empty list so view doesn’t break
                'val_list' => [],
                'title'     => config('app.name') . ' | Leave Setup',
                'error'     => $errorMessage ||  'Something Went To Wrong !!'
            ]);
        }
    }

    public function get_leave_type(Request $request)
    {
        try {

            $validated = $request->validate([
                'pType_Id'      => 'required|integer',
            ]);

            $result = DB::select("CALL usp_VwLeaveType(?)", [
                $validated['pType_Id']
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => $result
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function process_lev_setup(Request $request)
    {
        try {

            $validated = $request->validate([
                'pLeave_Name' => 'required|string',
                'pSh_Name'    => 'required|string',
                'pLeave_No'   => 'required|integer|min:1',
                'pDays_No'    => 'nullable|required_if:pLeave_No,3|integer|min:1',
                'pActive'     => 'required|boolean',
                'pDoc_Req'    => 'required|boolean'
            ]);

            $result = DB::select("CALL usp_InsertUpdtLeaveType(?,?,?,?,?,?,?,?)", [
                $request->pLeave_Id,
                $validated['pLeave_Name'],
                $validated['pSh_Name'],
                $request->boolean('pDoc_Req') ? 1 : 0,
                $validated['pLeave_No'],
                $request->pValidaty,
                $validated['pDays_No'],
                $request->boolean('pActive') ? 1 : 0
            ]);
            $store_id = $result[0]->Id;
            if ($store_id > 0) {
                if ($request->pLeave_Id != '') {
                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Leave Setup Successfully Updated !!'
                    ]);
                } else {
                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Leave Setup Is Successfully Save !!'
                    ]);
                }
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Operation Could Not Compleated !!'
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function leave_init_index()
    {
        try {
            // Try to load year list
            $year_list = DB::select('CALL usp_VwFinYear()');

            $title = config('app.name') . ' | Leave Entitlement Initialization';

            // Return view normally
            return view('payroll.leaveinit', compact('year_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.leaveinit', [
                'year_list' => [],  // empty list so view doesn’t break
                'title'     => config('app.name') . ' | Leave Entitlement Initialization',
                'error'     => 'Something Went To Wrong !!'
            ]);
        }
    }

    public function get_leave_allow(Request $request)
    {
        try {

            $validated = $request->validate([
                'pYear_Id'      => 'required|integer',
            ]);

            $result = DB::select("CALL usp_VwLeaveAlloc(?)", [
                $validated['pYear_Id']
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => $result
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function process_lev_init(Request $request)
    {
        try {

            $validated = $request->validate([
                'pYear_Id'      => 'required|integer',
                'pinit_Data'    => 'required|json'
            ]);

            DB::statement("CALL usp_InsertUpdtLeaveEntlData(?,?,?)", [
                $validated['pYear_Id'],
                $validated['pinit_Data'],
                Session::get('User_Id')
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Leave Initialization Is Successfully Updated'
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function emp_lev_opn_index(Request $request)
    {
        try {
            // Try to load year list
            $finyear_list = DB::select('CALL usp_VwFinYear()');
            $emp_list = DB::select("call usp_VwEmployee(?);", [Session::get('User_Id')]);
            $mn_list = DB::select("Call usp_VwMonth();");
            $year_list = DB::select("Call usp_VwYear();");


            $title = config('app.name') . ' | Employee Leave Opening';

            // Return view normally
            return view('payroll.empleaveopn', compact('year_list', 'finyear_list', 'emp_list', 'mn_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.empleaveopn', [
                'year_list' => [],  // empty list so view doesn’t break
                'finyear_list' => [],
                'emp_list' => [],
                'mn_list' => [],
                'title'     => config('app.name') . ' | Employee Leave Opening',
                'error'     => 'Something Went Wrong !!'
            ]);
        }
    }

    public function get_leave_opbalance(Request $request)
    {
        try {

            $validated = $request->validate([
                'pEmp_Id'      => 'required|integer',
                'pFin_Year'    => 'required|integer',
                'pMonth'       => 'required|integer',
                'pYear'        => 'required|integer'
            ]);

            $result = DB::select("CALL usp_VwLeaveBalance(?,?,?,?)", [
                $validated['pFin_Year'],
                $validated['pMonth'],
                $validated['pYear'],
                $validated['pEmp_Id']
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => $result
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function process_opn_leave(Request $request)
    {
        try {

            $validated = $request->validate([
                'pEmp_Id'      => 'required|integer',
                'pFin_Year'    => 'required|integer',
                'pMonth'       => 'required|integer',
                'pYear'        => 'required|integer',
                'pTableData'   => 'required|json'
            ]);

            $result = DB::select("CALL usp_InsertUpdtLeaveOpenData(?,?,?,?,?,?)", [
                $validated['pEmp_Id'],
                $validated['pFin_Year'],
                $validated['pMonth'],
                $validated['pYear'],
                $validated['pTableData'],
                Session::get('User_Id')
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Leave Opening Balance Successfully Set !!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function leave_req_index()
    {
        try {
            // Try to load year list
            $leave_type = DB::select('CALL usp_VwLeaveTypeAll()');
            $emp_list = DB::select("call usp_VwEmployee(?);", [Session::get('User_Id')]);
            $half_type = DB::select("Call usp_getOptionList (14);");


            $title = config('app.name') . ' | Leave Requisition';

            // Return view normally
            return view('payroll.leavereq', compact('half_type', 'leave_type', 'emp_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.leavereq', [
                'half_type' => [],  // empty list so view doesn’t break
                'leave_type' => [],
                'emp_list' => [],
                'title'     => config('app.name') . ' | Leave Requisition',
                'error'     => 'Something Went Wrong !!'
            ]);
        }
    }

    public function get_appl_data(Request $request)
    {
        try {

            $validated = $request->validate([
                'pEmp_Id'      => 'required|integer',
                'pAppl_No'    => 'required|string',
            ]);

            $result = DB::select("CALL usp_getLeaveAppl(?,?)", [
                $validated['pEmp_Id'],
                $validated['pAppl_No']
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => $result
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function get_leave_balance(Request $request)
    {
        try {

            $validated = $request->validate([
                'pEmp_Id'      => 'required|integer',
                'pType_Id'    => 'required|integer',
            ]);

            $result = DB::select("CALL usp_getLeaveBalance(?,?)", [
                $validated['pEmp_Id'],
                $validated['pType_Id']
            ]);

            if (empty($result)) {
                throw new Exception("No Data Found !!");
            }

            return response()->json([
                'status'  => 'success',
                'message' => $result
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function process_lev_req(Request $request)
    {
        try {

            $validated = $request->validate([
                'pEmp_Id'          => 'required|integer',
                'pLeave_Type'      => 'required|integer',
                'lev_frm'          => 'required|date',
                'lev_to'           => 'required|date',
                'pLev_Reason'      => 'required|string',
                'pHalf_Day_Flag'   => 'required|boolean',
                'pHalf_Day_type'   => 'exclude_if:pHalf_Day_Flag,0|required|integer',
            ]);

            $isHalf = (int) $request->pHalf_Day_Flag;
            $half_type = null;
            if ($request->pHalf_Day_type != 'null') {
                $half_type = $request->pHalf_Day_type;
            };

            $result = DB::select("CALL usp_InsertUpdtLeaveAppl(?,?,?,?,?,?,?,?,?,?)", [
                $request->pAppl_Id,
                $validated['pEmp_Id'],
                $validated['pLeave_Type'],
                $validated['lev_frm'],
                $validated['lev_to'],
                $isHalf,
                $half_type,
                $validated['pLev_Reason'],
                null,
                Session::get('User_Id')
            ]);
            $pAppl_No = $result[0]->No;
            $pFile_Name = $result[0]->FileNmUpld;
            if ($request->hasFile('doc_file')) {
                $valid_file = $request->validate([
                    'doc_file'         => 'file|mimes:jpg,jpeg,png,webp,pdf|max:2048'
                ]);

                if ($pFile_Name != '') {
                    $this->uploadLeaveFile($valid_file['doc_file'], $pFile_Name);
                }
            }

            return response()->json([
                'status'  => 'success',
                'message' => $pAppl_No
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function lev_apprv_index()
    {
        try {
            // Try to load year list
            $appl_list = DB::select("Call usp_getLeaveApprvList(?);", [Session::get('User_Id')]);
            $sts_list = DB::select("Call usp_getOptionList (15);");
            $title = config('app.name') . ' | Leave Approval';

            // Return view normally
            return view('payroll.leaveapprv', compact('appl_list', 'sts_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.leaveapprv', [
                'appl_list' => [],  // empty list so view doesn’t break
                'sts_list' => [],
                'title'     => config('app.name') . ' | Leave Approval',
                'error'     => $errorMessage
            ]);
        }
    }

    public function process_lev_apprvl(Request $request)
    {
        try {

            $validated = $request->validate([
                'pAppl_Id'      => 'required|integer',
                'pSts_Cd'    => 'required|integer',
            ]);

            DB::statement("CALL usp_UpdateLvApproval(?,?,?,?)", [
                Session::get('User_Id'),
                $validated['pAppl_Id'],
                $validated['pSts_Cd'],
                $request->pRemarks
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Leave Application Status Changed Successfully !!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function emp_allow_index()
    {
        try {
            // Try to load year list
            $allow_list = DB::select("Call usp_VwAllowance();");
            $title = config('app.name') . ' | Allowances';

            // Return view normally
            return view('payroll.allowence', compact('allow_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.allowence', [
                'allow_list' => [],  // empty list so view doesn’t break
                'title'     => config('app.name') . ' | Allowances',
                'error'     => $errorMessage
            ]);
        }
    }

    public function get_allowns_data(Request $request)
    {
        try {

            $validated = $request->validate([
                'pAllow_Id'      => 'required|integer',
            ]);

            $pAllowId = $validated['pAllow_Id'];

            $result = collect(DB::select("CALL usp_VwAllowance()"))
                ->firstWhere('Id', $pAllowId);

            return response()->json([
                'status'  => 'success',
                'message' => $result
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function process_allowance(Request $request)
    {
        try {

            $validated = $request->validate([
                'pAllow_Name'      => 'required|string',
                'pAmount' => 'nullable|numeric|required_without:pPerc',
                'pPerc'   => 'nullable|numeric|required_without:pAmount',
            ]);

            DB::statement("Call usp_InsertUpdtAllowance(?,?,?,?,?,?);", [
                $request->pAll_Id,
                $validated['pAllow_Name'],
                $validated['pAmount'],
                $validated['pPerc'],
                $request->pRound,
                1
            ]);

            $message = 'Allowance Details Successfully Saved !!';

            if ($request->pAll_Id != '') {
                $message = 'Allowance Details Successfully Updated !!';
            }

            return response()->json([
                'status'  => 'success',
                'message' => $message
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function emp_ded_index()
    {
        try {
            // Try to load year list
            $ded_list = DB::select("Call usp_VwDeduction();");
            $title = config('app.name') . ' | Deductions';

            // Return view normally
            return view('payroll.deduction', compact('ded_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.deduction', [
                'ded_list' => [],  // empty list so view doesn’t break
                'title'     => config('app.name') . ' | Deductions',
                'error'     => $errorMessage
            ]);
        }
    }

    public function get_ded_data(Request $request)
    {
        try {

            $validated = $request->validate([
                'pAllow_Id'      => 'required|integer',
            ]);

            $pAllowId = $validated['pAllow_Id'];

            $result = collect(DB::select("CALL usp_VwDeduction()"))
                ->firstWhere('Id', $pAllowId);

            return response()->json([
                'status'  => 'success',
                'message' => $result
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function process_deduction(Request $request)
    {
        try {

            $validated = $request->validate([
                'pAllow_Name'      => 'required|string',
                'pAmount' => 'nullable|numeric|required_without:pPerc',
                'pPerc'   => 'nullable|numeric|required_without:pAmount',
            ]);

            DB::statement("Call usp_InsertUpdtDeduction(?,?,?,?,?,?);", [
                $request->pAll_Id,
                $validated['pAllow_Name'],
                $validated['pAmount'],
                $validated['pPerc'],
                $request->pRound,
                1
            ]);

            $message = 'Deduction Details Successfully Saved !!';

            if ($request->pAll_Id != '') {
                $message = 'Deduction Details Successfully Updated !!';
            }

            return response()->json([
                'status'  => 'success',
                'message' => $message
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function emp_app_index()
    {
        try {
            // Try to load year list
            $gend_list = DB::select("Call usp_getOptionList(3);");
            $domain_list = DB::select("Call usp_getDomainList();");
            $dep_list = DB::select("Call usp_getDepartmentList();");
            $deg_list = DB::select("Call usp_getDesignationList();");
            $sts_list = DB::select("Call usp_getEmpStatusList();");
            $emp_type = DB::select("Call usp_getOptionList(16);");
            $emp_sts = DB::select("Call usp_getOptionList(17);");
            $title = config('app.name') . ' | Deductions';

            // Return view normally
            return view('payroll.empprof', compact('title', 'gend_list', 'domain_list', 'dep_list', 'deg_list', 'sts_list', 'emp_type', 'emp_sts'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.deduction', [
                'gend_list' => [],
                'domain_list' => [],
                'dep_list' => [],
                'deg_list' => [],
                'sts_list' => [],
                'emp_type' => [],
                'emp_sts' => [],
                'title'     => config('app.name') . ' | Deductions',
                'error'     => $errorMessage
            ]);
        }
    }

    public function process_employee(Request $request)
    {
        try {

            $validated = $request->validate([
                'emp_code'      => 'required|string',
                'emp_fname' => 'required|string',
                'emp_mname' => 'nullable|string',
                'emp_lname' => 'required|string',
                'emp_dob' => 'required|date',
                'emp_age' => 'required|integer',
                'emp_gend' => 'required|integer',
                'emp_res' => 'nullable|string',
                'emp_qlf' => 'nullable|string',
                'emp_doj' => 'required|date',
                'emp_ret' => 'required|string',
                'emp_wbr' => 'nullable|string',
                'emp_dom' => 'required|integer',
                'emp_dep' => 'required|integer',
                'emp_deg' => 'required|integer',
                'emp_mob' => 'required|integer|min:1',
                'emp_wno' => 'nullable|integer|min:1',
                'emp_mail' => 'nullable|email',
                'emp_sts' => 'required|integer',
                'emp_type' => 'required|integer',
                'emp_branch' => 'required|string',
                'emp_epf' => 'nullable|string',
                'emp_esic' => 'nullable|string',
                'emp_uan' => 'nullable|string',
                'emp_bank' => 'nullable|string',
                'emp_bacno' => 'nullable|string',
                'emp_active' => 'required|integer'
            ]);

            $sql = DB::select("Call usp_InsertEmployeeProfile(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);", [
                $validated['emp_code'],
                $validated['emp_fname'],
                $validated['emp_mname'],
                $validated['emp_lname'],
                $validated['emp_dob'],
                $validated['emp_age'],
                $validated['emp_gend'],
                $validated['emp_res'],
                $validated['emp_qlf'],
                $validated['emp_doj'],
                $validated['emp_ret'],
                $validated['emp_wbr'],
                $validated['emp_dom'],
                $validated['emp_dep'],
                $validated['emp_deg'],
                $validated['emp_mob'],
                $validated['emp_wno'],
                $validated['emp_mail'],
                $validated['emp_sts'],
                $validated['emp_type'],
                $validated['emp_branch'],
                $validated['emp_epf'],
                $validated['emp_esic'],
                $validated['emp_uan'],
                $validated['emp_bank'],
                $validated['emp_bacno'],
                $validated['emp_active'],
                Session::get('User_Id'),
                $request->emp_id
            ]);

            $emp_id = $sql[0]->Id;

            if ($emp_id != 0) {
                $message = 'Employee Details Successfully Saved !!';

                if ($request->emp_id != '') {
                    $message = 'Employee Details Successfully Updated !!';
                }

                return response()->json([
                    'status'  => 'success',
                    'message' => $message
                ]);
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Operation Could Not Be Completed !!'
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function get_emp_data(Request $request)
    {
        try {

            $validated = $request->validate([
                'emp_id' => 'required|integer'
            ]);

            $sql = DB::select("Call usp_ViewEmployeeList(?);", [
                $validated['emp_id'],
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => $sql
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function get_holiday_calender()
    {
        try {
            $hol_list = DB::select('Call usp_VwHolidayData(?);', [2]);
            $title = config('app.name') . ' | Holiday Calender';

            return view('payroll.holidaycand', compact('hol_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.holidaycand', [
                'hol_list' => [],  // empty list so view doesn’t break
                'title'     => config('app.name') . ' | Holiday Calender',
                'error'     => 'Something Went To Wrong !!'
            ]);
        }
    }

    public function mnattnd_indedx()
    {
        try {
            $mon_list = DB::select('Call usp_VwMonth();');
            $year_list = DB::select("Call usp_VwYear();");
            $emp_list = DB::select("Call usp_VwEmployee(?);", [Session::get('User_Id')]);
            $title = config('app.name') . ' | Monthly Attandance';

            return view('payroll.mnattnd', compact('mon_list', 'year_list', 'emp_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.mnattnd', [
                'mon_list' => [],  // empty list so view doesn’t break
                'year_list' => [],
                'emp_list' => [],
                'title'     => config('app.name') . ' | Monthly Attandance',
                'error'     => 'Something Went To Wrong !!'
            ]);
        }
    }

    public function get_mnattnd_data(Request $request)
    {
        try {

            $validated = $request->validate([
                'month' => 'required|integer',
                'year' => 'required|integer',
                'emp_id' => 'required|integer'
            ]);

            $sql = DB::select("Call usp_VwMnthDates(?,?);", [
                $validated['month'],
                $validated['year']
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => $sql
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function get_drp_options(Request $request)
    {
        try {

            $validated = $request->validate([
                'pOption' => 'required|integer',
            ]);

            $sql = DB::select("Call usp_getOptionList(?);", [
                $validated['pOption'],
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => $sql
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function get_saved_attnd(Request $request)
    {
        try {

            $validated = $request->validate([
                'emp_id' => 'required|integer',
                'month' => 'required|integer',
                'year' => 'required|integer'
            ]);

            $sql = DB::select("Call usp_getAttendanceMonth(?,?,?,?);", [
                $validated['month'],
                $validated['year'],
                $validated['emp_id'],
                2
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => $sql
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function process_mn_attnd(Request $request)
    {
        try {

            $validated = $request->validate([
                'emp_id' => 'required|integer',
                'json' => 'required|json',
            ]);

            $sql = DB::statement("Call usp_InsertAttendanceMonthly(?,?,?);", [
                $validated['emp_id'],
                $validated['json'],
                Session::get('User_Id')
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Attandance Posted Successfully !'
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function payslip_index(Request $request)
    {
        try {
            $mon_list = DB::select('Call usp_VwMonth();');
            $year_list = DB::select("Call usp_VwYear();");
            $emp_list = DB::select("Call usp_VwEmployee(?);", [Session::get('User_Id')]);
            $title = config('app.name') . ' | Generate Payslip';

            return view('payroll.payslip', compact('mon_list', 'year_list', 'emp_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.payslip', [
                'mon_list' => [],  // empty list so view doesn’t break
                'year_list' => [],
                'emp_list' => [],
                'title'     => config('app.name') . ' | Generate Payslip',
                'error'     => 'Something Went Wrong'
            ]);
        }
    }

    public function generate_payslip(Request $request)
    {
        try {

            $validated = $request->validate([
                'month' => 'required|integer',
                'year' => 'required|integer',
                'emp_id' => 'required|integer'
            ]);

            $sql = DB::select("Call usp_getSalaryDetails(?,?,?,?);", [
                2,
                $validated['month'],
                $validated['year'],
                $validated['emp_id']
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => $sql
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {

            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $ex) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }

    public function upd_payslip_index(Request $request)
    {
        try {
            $mon_list = DB::select('Call usp_VwMonth();');
            $year_list = DB::select("Call usp_VwYear();");
            $emp_list = DB::select("Call usp_VwEmployee(?);", [Session::get('User_Id')]);
            $title = config('app.name') . ' | Generate Payslip';

            return view('payroll.upd_payslip', compact('mon_list', 'year_list', 'emp_list', 'title'))
                ->with('error', null);
        } catch (\Exception $e) {

            // If table missing OR procedure missing OR database error
            $errorMessage = $e->getMessage();

            return view('payroll.upd_payslip', [
                'mon_list' => [],  // empty list so view doesn’t break
                'year_list' => [],
                'emp_list' => [],
                'title'     => config('app.name') . ' | Generate Payslip',
                'error'     => 'Something Went Wrong'
            ]);
        }
    }

    public function update_payslip(Request $request)
    {
        try {
            $validated = $request->validate([
                'EmpId' => 'required|integer',
                'MonthSl' => 'required|integer',
                'YrSl' => 'required|integer',
                'JsonData' => 'required|json'
            ]);

            $salaryData = json_decode($validated['JsonData'], true, 512, JSON_THROW_ON_ERROR);
            if (!array_is_list($salaryData)) {
                $salaryData = [$salaryData];
            }

            DB::statement('Call usp_UpdateSalary(?,?,?,?);', [
                $validated['EmpId'],
                $validated['MonthSl'],
                $validated['YrSl'],
                json_encode($salaryData, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payslip updated successfully.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $ex->errors()
            ], 422);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $ex->getMessage()
            ], 500);
        }
    }
}
