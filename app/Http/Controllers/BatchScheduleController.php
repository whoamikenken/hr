<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Extras;
use App\Jobs\SendEmail;
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
            $data['result'][$key]->office = DB::table('offices')->where('id', $value->office)->value('description');
            $data['result'][$key]->department = DB::table('departments')->where('id', $value->department)->value('description');
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
        return view('setup/batchscheduling_modal', $data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'uid' => ['required'],
            'sched_id' => ['required'],
            'office' => ['required'],
            'department' => ['required']
        ]);
        // DB::enableQueryLog();
        $employeeList = DB::table("employees")->where("office", $formFields['office'])->where("department", $formFields['department'])->get();
        // dd($employeeList);
        $email = array();
        $number = array();
        $employeeCount = 0;
        // dd($employeeList);
        foreach ($employeeList as $key => $value) {
            $employeeCount++;
            $email[] = $value->email;
            $number[] = str_replace("+63", "0", $value->contact);
            DB::table("schedules_detail_employee")->where('employee_id', '=', $value->employee_id)->delete();
            $schedData = DB::table("schedules_detail")->where("sched_id", $formFields['sched_id'])->get();
            foreach ($schedData as $sch => $schedValue) {
                unset($schedData[$sch]->id);
                $schedData[$sch]->employee_id = $value->employee_id;
            }
            // Convert TO array
            $schedData = json_decode(json_encode($schedData), true);
            DB::table('schedules_detail_employee')->insert($schedData);
            
        }

        $dataEmail = array(
            'emailtype' => "notify",
            'subject' => "New Schedule",
            'email' => $email,
            'from_title' => "HR",
        );

        try {
            SendEmail::dispatch($dataEmail);
        } catch (Exception $th) {
            dump($th);
        }

        $dataSMS = array(
            'username' => env('SMS_USER'),
            'password' => env('SMS'),
            'port' => 2,
            'recipients' => implode(",", $number),
            'sms' => "Hello! please check your new schedule."
        );

        $reponse = Extras::sendRequest("http://122.54.191.90:8085/goip_send_sms.html", "get", $dataSMS);
        
        $formFields['employee_count'] = $employeeCount;

        if ($formFields['uid'] == "add") {
            unset($formFields['uid']);
            $formFields['created_by'] = Auth::id();
            BatchSchedule::create($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully added schedule to '.$employeeCount.' student.', 'title' => 'Success!');
        } else {
            $formFields['updated_at'] = Carbon::now();
            $formFields['modified_by'] = Auth::id();
            $id = $formFields['uid'];
            unset($formFields['uid']);
            DB::table("batch_schedules")->where('id', $id)->update($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully updated schedule to ' . $employeeCount . ' student.', 'title' => 'Success!');
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
