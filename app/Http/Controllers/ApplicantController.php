<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Extras;
use App\Mail\MailNotify;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{
    //
    
    public function getTable(Request $request)
    {
        $filter = $request->input();
        
        $where = array();
        if($filter['applicant']) $where[] = array('applicant_id', '=', $filter['applicant']);
        $data['result'] = DB::table('applicants')->where($where)->paginate(12);
        foreach ($data['result'] as $key => $value) {
            $data['result'][$key]->campus = DB::table('campuses')->where('code', $value->campus)->value('description');
        }
        return view('user/applicant_list', $data);
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
        return view('user/applicant_modal', $data);
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
        return view('user/applicant_tab', $data);
    }
    
    public function profile(Request $request)
    {
        $data = array();
        
        $formFields = $request->validate([
            'uid' => ['required'],
        ]);
        
        $data['uid'] = $formFields['uid'];
        
        $data['record'] = DB::table('applicants')->where("applicant_id", $data['uid'])->get();
        $data = json_decode($data['record'], true)[0];
        
        $data['campuses_select'] = DB::table('campuses')->get();
        $data['courses_select'] = DB::table('courses')->get();
        $data['yearlevels_select'] = DB::table('yearlevels')->get();
        $data['sections_select'] = DB::table('sections')->get();
        $data['users_select'] = DB::table('users')->where("user_type", "Professor")->get();
        
        $data['readAccess'] = explode(",", Extras::getAccessList("read", Auth::user()->username));
        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));
        
        return view('user/applicant_profile', $data);
    }
    
    public function record(Request $request)
    {
        $data = array();
        
        $formFields = $request->validate([
            'uid' => ['required'],
        ]);
        
        $data['uid'] = $formFields['uid'];
        
        $data['record'] = DB::table('applicants')->where("applicant_id", $data['uid'])->get();
        $data = json_decode($data['record'], true)[0];
        $data['country_select'] = DB::table('countries')->get();
        
        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));
        
        return view('user/applicant_record', $data);
    }
    
    public function document(Request $request)
    {
        $data = array();
        
        $formFields = $request->validate([
            'uid' => ['required'],
        ]);
        
        $data['uid'] = $formFields['uid'];
        
        $data['record'] = DB::table('applicants')->where("applicant_id", $data['uid'])->get();
        $data = json_decode($data['record'], true)[0];
        
        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));
        
        return view('user/applicant_document', $data);
    }
    
    public function oec(Request $request)
    {
        $data = array();
        
        $formFields = $request->validate([
            'uid' => ['required'],
        ]);
        
        $data['uid'] = $formFields['uid'];
        
        $data['record'] = DB::table('applicants')->where("applicant_id", $data['uid'])->get();
        $data = json_decode($data['record'], true)[0];
        
        $data['readAccess'] = explode(",", Extras::getAccessList("read", Auth::user()->username));
        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));
        
        return view('user/applicant_oec', $data);
    }
    
    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');
        $formFields = $request->validate([
            'applicant_id' => ['required'],
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

    public function saveApplicant(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');
        $stud_no = $request->post("student_no");
        
        $validator = Extras::ValidateRequest(
            $request,
            [
                'student_no' => ['required', Rule::unique('applicants')->where(function ($query) use ($stud_no) {
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

        $userData=array();
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
        $formFields['applicant_id'] = $data->id;

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
    
    public function updateApplicantData(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');
        // dd($request->input());
        $applicant_id = $request->input("applicant_id");
        $column = $request->input("column");
        $value = $request->input("value");
        if ($request->hasFile('file')) {
            $users = DB::table('applicants')->where('applicant_id', $applicant_id)->first();
            if ($users->{$column}) {
                Storage::disk('s3')->delete($users->{$column});
            }
            $value = $request->file('file')->store($column, 's3');
        }
        
        
        $formFields = array($column => $value);
        $query = DB::table('applicants')->where('applicant_id', $applicant_id)->update($formFields);
        
        if ($column == "med_first_cost" || $column == "med_second_cost" || $column == "med_third_cost" || $column == "med_fourth_cost" || $column == "cert_nc2_cost") {
            $users = DB::table('applicants')->where('applicant_id', $applicant_id)->first();
            $total_cost = $users->med_first_cost + $users->med_second_cost + $users->med_third_cost + $users->med_fourth_cost + $users->cert_nc2_cost;
            $NewTotalCost = array('total_cost' => $total_cost);
            DB::table('applicants')->where('applicant_id', $applicant_id)->update($NewTotalCost);
        }
        
        if ($query) {
            $return = array('status' => 1, 'msg' => 'Successfully updated applicant', 'title' => 'Success!');
        }
        
        return response()->json($return);
    }
    
    public function testEmail(){
        $data = array(
            'subject' => "test",
            'body' => "Test email"
        );
        $email = array('hipolitoluisito783@gmail.com', 'dutertehck@gmail.com');
        try {
            Mail::to($email)->send(New MailNotify($data));
            return response()->json(['Check your mail']);
        } catch (Exception $th) {
            return response()->json(['Something Went Wrong']);
        }
    }
}
