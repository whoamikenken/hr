<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Extras;
use App\Mail\MailNotify;
use App\Models\Tablecolumn;
use Illuminate\Http\Request;
use App\Models\BatchSchedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BatchScheduleController extends Controller
{
    //
    public function index()
    {
        $data['menus'] = DB::table('menus')->get();
        return view('setup/batchscheduling', $data);
    }

    public function getTable()
    {
        $data['result'] = DB::table("batch_schedules")->get();

        // get user creator
        foreach ($data['result'] as $key => $value) {

            $data['result'][$key]->modified_by = DB::table('users')->where('id', $value->modified_by)->value('name');
            $data['result'][$key]->created_by = DB::table('users')->where('id', $value->created_by)->value('name');
        }

        $data['columns'] = Tablecolumn::getColumn("batch_schedules");
        // dd($data);
        return view('setup/batchscheduling_table', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table("batch_schedules")->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
        }

        $data['uid'] = $formFields['uid'];
        $data['sched_select'] = DB::table("schedules")->get();
        $data['course_select'] = DB::table("courses")->get();
        $data['campus_select'] = DB::table("campuses")->get();
        $data['yearlevel_select'] = DB::table("yearlevels")->get();
        // dd($data);
        return view('setup/batchscheduling_modal', $data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'uid' => ['required'],
            'sched_id' => ['required'],
            'yearlevel' => ['required'],
            'course' => ['required'],
            'campus' => ['required'],
            'section' => ['required']
        ]);
        // DB::enableQueryLog();
        $studentList = DB::table("students")->where("section", $formFields['section'])->where("year_level", $formFields['yearlevel'])->where("course", $formFields['course'])->where("campus", $formFields['campus'])->get();
        $email = array();
        $number = array();
        $studentCount = 0;
        // dd($studentList);
        foreach ($studentList as $key => $value) {
            $studentCount++;
            $email[] = $value->email;
            $number[] = str_replace("+63", "0", $value->contact);
            DB::table("schedules_detail_student")->where('student_id', '=', $value->student_id)->delete();
            $schedData = DB::table("schedules_detail")->where("section", $formFields['section'])->get();
            foreach ($schedData as $sch => $schedValue) {
                unset($schedData[$sch]->id);
                $schedData[$sch]->student_id = $value->student_id;
            }
            // Convert TO array
            $schedData = json_decode(json_encode($schedData), true);
            DB::table('schedules_detail_student')->insert($schedData);
            
        }

        $data = array(
            'subject' => "New Schedule",
            'emailtype' => "notify"
        );

        try {
            Mail::to($email)->send(new MailNotify($data));
            response()->json(['Check your mail']);
        } catch (Exception $th) {
            response()->json(['Something Went Wrong']);
        }

        $dataSMS = array(
            'username' => env('SMS_USER'),
            'password' => env('SMS'),
            'port' => 2,
            'recipients' => implode(",", $number),
            'sms' => "Hello! please check your new schedule."
        );

        $reponse = Extras::sendRequest("http://122.54.191.90:8085/goip_send_sms.html", "get", $dataSMS);
        
        $formFields['student_count'] = $studentCount;

        if ($formFields['uid'] == "add") {
            unset($formFields['uid']);
            $formFields['created_by'] = Auth::id();
            BatchSchedule::create($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully added schedule to '.$studentCount.' student.', 'title' => 'Success!');
        } else {
            $formFields['updated_at'] = Carbon::now();
            $formFields['modified_by'] = Auth::id();
            $id = $formFields['uid'];
            unset($formFields['uid']);
            DB::table("batch_schedules")->where('id', $id)->update($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully updated schedule to ' . $studentCount . ' student.', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function delete(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'code' => ['required']
        ]);

        $delete = DB::table("batch_schedules")->where('id', '=', $formFields['code'])->delete();

        if ($delete) {
            $return = array('status' => 1, 'msg' => 'Successfully deleted schedule', 'title' => 'Success!');
        }

        return response()->json($return);
    }
}
