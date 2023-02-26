<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Extras;
use App\Jobs\SendEmail;
use App\Models\Timesheet;
use App\Models\WorkFromHome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','saveLogs', 'saveWorkTask', 'getAttendance']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('username', 'password');
        // dd($credentials);
        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard('api')->user();
        $employeeDetail = DB::table('employees')->where("employee_id", $credentials['username'])->get();
        $workPara = DB::table('work_paras')->first();

        return response()->json([
            'status' => 'success',
            'image' => Storage::disk("s3")->url($employeeDetail[0]->user_profile),
            'name' => $employeeDetail[0]->fname." ". $employeeDetail[0]->lname,
            'employee_id' => $employeeDetail[0]->employee_id,
            'latitude' => $workPara->latitude,
            'longitude' => $workPara->longitude,
            'token' => $token
        ]);
    }

    public function getAttendance(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|string',
            'date' => 'required|string',
        ]);
        $timeIn = $timeOut = "";
        $empID = $request->employee_id;
        $date = $request->date;

        $timeIn = DB::table('timesheets_trail_history')->where("employee_id", $empID)->where(DB::raw('date(log_time)'), $date)->where("log_type", "IN")->value("log_time");

        $timeOut = DB::table('timesheets_trail_history')->where("employee_id", $empID)->where(DB::raw('date(log_time)'), $date)->where("log_type", "OUT")->value("log_time");

        if(!$timeIn){
            $timeIn = "No Time In";
        }

        if (!$timeOut) {
            $timeOut = "No Time Out";
        }

        return response()->json([
            'status' => 'success',
            'time_in' => $timeIn,
            'time_out' => $timeOut,
        ]);
    }

    public function saveLogs(Request $request)
    {
        $log = $request->input();
        $base64 = Extras::fix_base64($log['base_64']);
        $image = base64_decode($base64);
        $dateLog = date("Y-m-d", substr($log['time'], 0, 10));
        $lastLog = Timesheet::getLastlogs($log['employee_id'], $dateLog);
        $logType = "";
        // dd($lastLog);

        $timesheetHistoryData = array();
        $timesheetHistoryData['employee_id'] = $log['employee_id'];
        $timesheetHistoryData['local_time'] = $log['time'];
        $timesheetHistoryData['log_time'] = date("Y-m-d H:i:s", substr($log['time'], 0, 10));
        $timesheetHistoryData['username'] = $log['username'];
        $timesheetHistoryData['ip'] = $log['ip'];
        $timesheetHistoryData['location'] = $log['location'];
        $timesheetHistoryData['machine_type'] = $log['machine_type'];
        if($lastLog['log_type'] == "new"){
            $timesheetHistoryData['log_type'] = "IN";
            $timesheetTrailData = $timesheetHistoryData;

            $logType = "IN";
            // DB::table('timesheets_trail')->insert($timesheetTrailData);
        }elseif($lastLog['log_type'] == "IN"){
            $timesheetHistoryData['log_type'] = "OUT";
            $timesheetTrailData = $timesheetHistoryData;
            $timesheetData = array();
            $timesheetData['employee_id'] = $log['employee_id'];
            $timesheetData['time_in'] = $lastLog['log_time'];
            $timesheetData['time_out'] = $timesheetHistoryData['log_time'];
            $timesheetData['machine_in'] = $lastLog['machine_type'];
            $timesheetData['machine_out'] = $timesheetHistoryData['machine_type'];
            $timesheetData['ip_in'] = $lastLog['ip'];
            $timesheetData['ip_out'] = $timesheetHistoryData['ip'];
            $timesheetData['location_in'] = $lastLog['location'];
            $timesheetData['location_out'] = $timesheetHistoryData['location'];
            $timesheetData['type'] = $lastLog['machine_type']." - ". $timesheetHistoryData['machine_type'];
            $timesheetData['username'] = "Webcheckin";

            $logType = "OUT";
            // DB::table('timesheets_trail')->insert($timesheetTrailData);
            // DB::table('timesheets')->insert($timesheetData);
            // DB::table('timesheets_trail')->where('employee_id', '=', $log['employee_id'])->where(DB::raw('date(log_time)'), $dateLog)->delete();
        }elseif($lastLog['log_type'] == "OUT"){
            return response()->json([
                'status' => 'over'
            ]);
            die;
        }
        $imageLink = "";
        $titleImage = "user_logs/" . $log['employee_id'] . '-' . $log['time'] . '.png';
        $p = Storage::disk('s3')->put($titleImage, $image);

        if ($p) {
            $imageLink = $titleImage;
        } else {
            $imageLink = "none";
        }


        $timesheetHistoryData['image'] = $imageLink;
        DB::table('timesheets_trail_history')->insert($timesheetHistoryData);

        return response()->json([
            'status' => 'success',
            'log_type' => $logType
        ]);
    }

    public function saveWorkTask(Request $request)
    {
        $log = $request->input();
        $base64 = Extras::fix_base64($log['base_64']);
        $image = base64_decode($base64);

        $WFHData = array();
        $WFHData['employee_id'] = $log['employee_id'];
        $WFHData['purpose'] = $log['purpose'];
        $WFHData['date'] = $log['date'];
        $WFHData['work_done'] = $log['work_done'];

        $approverOffice = Extras::getApproverHead($log['employee_id']);
        if (!$approverOffice) {
            $WFHData['office_head'] = 1;
        }else{
            $WFHData['office_head'] = $approverOffice;
        }
        
        $WFHData['applied_by'] = $log['employee_id'];
        $WFHData['created_by'] = DB::table("users")->where("username", "=", $log['employee_id'])->value("id");
        
        $p = Storage::disk('s3')->put("work_request/".$log['file_name'], $image);
        if ($p) {
            $WFHData['accomplishment_file'] = "work_request/".$log['file_name'];
        } else {
            $WFHData[''] = "none";
        }

        $createWFH = WorkFromHome::create($WFHData);
        $lastId = $createWFH->id;

        $getApproverEmail = DB::table("employees")->where("employee_id", "=", $approverOffice)->value("email");

        $WFHData['fullname'] = Extras::getEmployeeName($log['employee_id']);
        $WFHData['headfullname'] = Extras::getEmployeeName($approverOffice);
        $data = array(
            'emailtype' => "wfh_notification",
            'subject' => "Work Task Request",
            'email' => $getApproverEmail,
            'from_title' => "AtTask",
            'data' => $WFHData
        );
        try {
            SendEmail::dispatch($data);
            // Mail::to($getApproverEmail)->send(new MailNotify($data));
        } catch (Exception $th) {
            dump($th);
        }
        // Update finance email stat
        $emailData = array('email_office_head' => 1);
        DB::table('work_from_homes')->where('id', $lastId)->update($emailData);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::guard('api')->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::guard('api')->user(),
            'authorisation' => [
                'token' => Auth::guard('api')->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function getmaid(Request $request)
    {
        
        $data = json_decode($request->getContent());
        // dd($data);
        if(Auth::guard('api')->user()->user_type == "Api" || Auth::guard('api')->user()->user_type == "Admin"){
            $id = "";
            $con = false;
            if(isset($data->er_id) && $data->er_id != ""){
                $con = true;
                $id = $data->er_id;
            }elseif (isset($data->maid_id) && $data->maid_id != "") {
                $con = true;
                $id = $data->maid_id;
            }

            if($con == false){
                return response()->json([
                    'status' => 'false',
                    'msg' => 'Please check your payload'
                ]);
            }else{
                $record = DB::select("SELECT * FROM applicants WHERE er_ref = '$id' or maid_ref = '$id'");
                return response()->json([
                    'status' => 'success',
                    'msg' => $record
                ]);
            }
        }else{
            Auth::guard('api')->logout();
            return response()->json([
                'status' => 'success',
                'msg' => 'Your account does not have permission to use this.' 
            ]);
        }
    }
}
