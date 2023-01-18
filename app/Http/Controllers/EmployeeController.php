<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use DatePeriod;
use DateInterval;
use App\Models\User;
use App\Models\Extras;
use App\Mail\MailNotify;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Validation\Rule;

class EmployeeController extends Controller
{
    //
    // 
    public function getTable(Request $request)
    {
        $filter = $request->input();

        $where = array();
        if ($filter['employee']) $where[] = array('employee_id', '=', $filter['employee']);
        if ($filter['office']) $where[] = array('office', '=', $filter['office']);
        if ($filter['department']) $where[] = array('department', '=', $filter['department']);
        $data['result'] = DB::table('employees')->where($where)->paginate(12);
        foreach ($data['result'] as $key => $value) {
            $data['result'][$key]->office = DB::table('offices')->where('code', $value->office)->value('description');
            $data['result'][$key]->department = DB::table('departments')->where('code', $value->department)->value('description');
        }
        return view('user/employee_list', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        $data['uid'] = $formFields['uid'];

        $data['campuses_select'] = DB::table('campuses')->get();
        $data['courses_select'] = DB::table('courses')->get();
        $data['yearlevels_select'] = DB::table('yearlevels')->get();
        $data['sections_select'] = DB::table('sections')->get();
        $data['users_select'] = DB::table('users')->where("user_type", "Professor")->get();

        // dd($data);
        return view('user/employee_modal', $data);
    }

    public function profileTab(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        $data['uid'] = $formFields['uid'];

        $data['readAccess'] = explode(",", Extras::getAccessList("read", Auth::user()->username));
        // dd($data);   
        return view('user/employee_tab', $data);
    }

    public function profile(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        $data['uid'] = $formFields['uid'];

        $data['record'] = DB::table('employees')->where("employee_id", $data['uid'])->get();
        $data = json_decode($data['record'], true)[0];

        $data['office_select'] = DB::table('offices')->get();
        $data['department_select'] = DB::table('departments')->get();

        $data['readAccess'] = explode(",", Extras::getAccessList("read", Auth::user()->username));
        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));

        return view('user/employee_profile', $data);
    }

    public function record(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        $data['uid'] = $formFields['uid'];

        $data['record'] = DB::table('employees')->where("employee_id", $data['uid'])->get();
        $data = json_decode($data['record'], true)[0];
        $data['country_select'] = DB::table('countries')->get();

        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));

        return view('user/employee_record', $data);
    }

    public function document(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        $data['uid'] = $formFields['uid'];

        $data['record'] = DB::table('employees')->where("employee_id", $data['uid'])->get();
        $data = json_decode($data['record'], true)[0];

        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));

        return view('user/employee_document', $data);
    }

    public function oec(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        $data['uid'] = $formFields['uid'];

        $data['record'] = DB::table('employees')->where("employee_id", $data['uid'])->get();
        $data = json_decode($data['record'], true)[0];

        $data['readAccess'] = explode(",", Extras::getAccessList("read", Auth::user()->username));
        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));

        return view('user/employee_oec', $data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');
        $formFields = $request->validate([
            'employee_id' => ['required'],
            'fname' => ['required'],
            'lname' => ['required'],
            'mname' => ['required'],
            'campus' => ['required'],
            'contact' => ['required'],
            'year_level' => ['required'],
            'course' => ['required'],
            'section' => ['required'],
            'email' => ['required'],
            'adviser' => ['required']
        ]);

        $fullname = $formFields['fname'] . " " . $formFields['lname'];
        $dataSMS = array(
            'username' => env('SMS_USER'),
            'password' => env('SMS'),
            'port' => 2,
            'recipients' => $formFields['contact'],
            'sms' => "Hello " . $fullname . "! You're successfully been registered please wait for the admin to verify your account."
        );

        $reponse = Extras::sendRequest("http://122.54.191.90:8085/goip_send_sms.html", "get", $dataSMS);
        unset($formFields['uid']);
        Applicant::create($formFields);
        $return = array('status' => 1, 'msg' => 'Successfully added applicant', 'title' => 'Success!');

        return response()->json($return);
    }

    public function schedule(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        $data['uid'] = $formFields['uid'];

        $data['record'] = DB::table('schedules_detail_employee')->where("employee_id", $data['uid'])->get();

        $data['dow'] = array("M" => "Monday", "T" => "Tuesday", "W" => "Wednesday", "TH" => "Thursday", "F" => "Friday", "S" => "Saturday", "SUN" => "Sunday");
        $data['sched_per_day'] = array();
        foreach ($data['dow'] as $dow_code => $dow_desc) {
            $where = array();
            $where[] = array('dayofweek', $dow_code);
            if ($formFields['uid'] != "add") {
                $sched = DB::table('schedules_detail_employee')->where($where)->where("employee_id", $formFields['uid'])->get();
                $data['sched_per_day'][$dow_code] = $sched;
            } else {
                $data['sched_per_day'][$dow_code] = array();
            }
        }

        $data['readAccess'] = explode(",", Extras::getAccessList("read", Auth::user()->username));
        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));
        // dd($data);
        return view('user/employee_schedule', $data);
    }

    public function saveApplicant(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');
        $stud_no = $request->post("student_no");

        $validator = Extras::ValidateRequest(
            $request,
            [
                'student_no' => ['required', Rule::unique('employees')->where(function ($query) use ($stud_no) {
                    return $query->where('student_no', $stud_no);
                })],
                'fname' => ['required'],
                'lname' => ['required'],
                'mname' => ['required'],
                'contact' => ['required'],
                'password' => ['required'],
                'age' => ['required'],
                'email' => ['required'],
                'gender' => ['required']
            ]
        );

        if ($validator['status'] == 0) {
            return response()->json($validator);
            die;
        } else {
            $formFields = $validator['data'];
        }

        $userData = array();
        $userData['username'] = $formFields['student_no'];
        $userData['fname'] = $formFields['fname'];
        $userData['lname'] = $formFields['lname'];
        $userData['mname'] = $formFields['mname'];
        $userData['email'] = $formFields['email'];
        $userData['password'] = bcrypt($formFields['password']);
        $userData['gender'] = $formFields['gender'];
        $userData['user_type'] = "Applicant";
        $userData['status'] = "unverified";
        unset($formFields['password']);

        if ($request->hasFile('file')) {
            $userData['user_image'] = $request->file('file')->store('user_image', 's3');
            $formFields['user_profile'] = $userData['user_image'];
        }

        $fullname = $formFields['fname'] . " " . $formFields['lname'];
        $userData['name'] = $fullname;

        $data = User::create($userData);
        $formFields['employee_id'] = $data->id;

        $dataSMS = array(
            'username' => env('SMS_USER'),
            'password' => env('SMS'),
            'port' => 2,
            'recipients' => str_replace("-", "", str_replace("+63", "0", $formFields['contact'])),
            'sms' => "Hello " . $stud_no . "! You're successfully been registered please wait for the admin to verify your account."
        );

        $reponse = Extras::sendRequest("http://122.54.191.90:8085/goip_send_sms.html", "get", $dataSMS);

        unset($formFields['uid']);

        Applicant::create($formFields);

        $return = array('status' => 1, 'msg' => 'Successfully added applicant', 'title' => 'Success!');

        return response()->json($return);
    }

    public function attendance(Request $request)
    {

        $Events = array();
    
        $dateTo = date("Y-m-d", strtotime($request->input("start")));
        $dateFrom = date("Y-m-d", strtotime($request->input("end")));

        $employeeid = Auth::user()->username;

        $begin = new DateTime($dateTo);
        $end = new DateTime($dateFrom);
        $begin = $begin->modify('+1 day');
        $end = $end->modify('+1 day');

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        foreach ($period as $dt) {
            $date = $dt->format("Y-m-d");
            if($date <= date("Y-m-d")){
                $query = DB::table('timesheets');
                $query->where("employee_id", $employeeid);
                $query->where(DB::raw('date(time_in)'), $date);
                $query->orderBy('time_in', 'desc');

                $result = $query->get();
                
                if (count($result) > 0) {
                    foreach ($result as $ky => $value) {
                        $data = array();
                        $title = Extras::AttendanceDescriptionCheckerIfLate($employeeid, $value->time_in);
                        $color = "#0172c6";
                        if ($title == "Late") {
                            $color = "#ffc700";
                        }
                        $data['title'] = $title;
                        $data['start'] = $value->time_in;
                        $data['end'] = $value->time_out;
                        $data['eventStartEditable'] = false;
                        $data['color'] = $color;
                        $Events[] = $data;
                    }
                } else {
                    $idx = date("N", strtotime($date));
                    // Get Schedule Data
                    $startTime = DB::table('schedules_detail_employee')->where('employee_id', $employeeid)->where('idx', $idx)->orderBy("starttime", "ASC")->value('starttime');

                    if ($startTime) {
                        $endTime = DB::table('schedules_detail_employee')->where('employee_id', $employeeid)->where('idx', $idx)->orderBy("endtime", "DESC")->value('endtime');
                        $color = "#cc1712";
                        $data['title'] = "Absent";
                        $data['start'] = $date . " " . $startTime;
                        $data['end'] = $date . " " . $endTime;
                        $data['eventStartEditable'] = false;
                        $data['color'] = $color;
                        $Events[] = $data;
                    }
                }
            }
        }

        return response()->json($Events);
    }

    public function updateEmployeeData(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');
        // dd($request->input());
        $employee_id = $request->input("employee_id");
        $column = $request->input("column");
        $value = $request->input("value");
        if ($request->hasFile('file')) {
            $users = DB::table('employees')->where('employee_id', $employee_id)->first();
            if ($users->{$column}) {
                Storage::disk('s3')->delete($users->{$column});
            }
            $value = $request->file('file')->store($column, 's3');
        }


        $formFields = array($column => $value);
        $query = DB::table('employees')->where('employee_id', $employee_id)->update($formFields);
        if ($query) {
            $return = array('status' => 1, 'msg' => 'Successfully updated employee', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function testEmail()
    {
        $data = array(
            'subject' => "test",
            'body' => "Test email"
        );
        $email = array('hipolitoluisito783@gmail.com', 'dutertehck@gmail.com');
        try {
            Mail::to($email)->send(new MailNotify($data));
            return response()->json(['Check your mail']);
        } catch (Exception $th) {
            return response()->json(['Something Went Wrong']);
        }
    }
}
