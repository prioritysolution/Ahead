<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProcessLogin extends Controller
{
    public function showLogin()
    {
        $title = config('app.name') . ' | LogIn';

        return view('Auth.login', compact('title'));
    }

    public function process_login(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_name'      => 'required|string',
                'user_pass' => 'required:string',
            ]);

            $validate_user = DB::select("Call usp_UserValidate(?,?);", [$validated['user_name'], $validated['user_pass']]);
            $pUser_Id = $validate_user[0]->UsrId;
            if ($pUser_Id == '0') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }
            $pUser_branch = $validate_user[0]->BrId;
            $pUser_Name = $validate_user[0]->EmpNm;
            $pUser_Grp = $validate_user[0]->UsrGrpId;
            $pDb_Type = $validate_user[0]->DBType;
            $pIsAttend = $validate_user[0]->CheckIn;
            $pAttend_Date = $validate_user[0]->CurDate;
            $pAttend_Time = $validate_user[0]->CheckTm;
            $pEmp_Id = $validate_user[0]->EmpId;



            $LoginKey = Str::random(64);
            $ua = $request->userAgent();
            $ip = $request->ip();
            $sessionFingerprint = hash_hmac('sha256', $ua . '|' . $ip, config('app.key'));
            $loginPush = DB::select("Call usp_UserAfterLogIn(?,?,?,?,?,?);", [$pUser_Id, $pUser_Grp, $pUser_branch, 1, $ip, $LoginKey]);
            $loginId = $loginPush[0]->SessionId;

            $request->session()->regenerate();
            Session::put('session_token', $LoginKey);
            Session::put('FingetPrint', $sessionFingerprint);
            Session::put('User_Name', $pUser_Name);
            Session::put('Branch_Id', $pUser_branch);
            Session::put('User_Id', $pUser_Id);
            Session::put('User_Grp', $pUser_Grp);
            Session::put('Login_Id', $loginId);
            Session::put('Dashboard', $pDb_Type);
            Session::put('EmpId', $pEmp_Id);
            if ($pIsAttend != 0) {
                Session::put('IsAttend', $pIsAttend);
                Session::put('AttendDate', $pAttend_Date);
                Session::put('AttendTime', $pAttend_Time);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful!',
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

    public function process_logout(Request $request)
    {
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function show_dashboard()
    {

        $title = config('app.name') . ' | Dashboard';
        $month = Carbon::now()->format('m'); // 01–12
        $year  = Carbon::now()->format('Y'); // 4-digit
        $report = DB::select("Call usp_getAttendanceMonth(?,?,?,?);",[$month,$year,Session::get('EmpId'),1]);
        $report = collect($report);

        if (Session::has('Dashboard')) {
            $dash_type = Session::get('Dashboard');

            $view = match ($dash_type) {
                1 => 'dashboard.admindashboard',
                2 => 'dashboard.directordash',
                3 => 'dashboard.employeedash',
                default => 'Auth.layout',
            };
            return view($view, [
                'title' => $title,
                'report' => $report
            ]);
        }
    }

    public function process_updpass()
    {
        $title = config('app.name') . ' | Change Password';

        return view('Auth.changepass', ['title' => $title]);
    }

    public function process_cng_pass(Request $request)
    {
        try {
            $validated = $request->validate([
                'pUserPass'      => 'required|string',
            ]);

            $pPunchIn = DB::select("Call usp_UpdateUsrPwd(?,?);", [Session::get('User_Id'), $validated['pUserPass']]);

            if (empty($pPunchIn)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry Could Not Process This Request !!'
                ], 401);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User Password Is Changed Successfully !!'
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
}
