<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Extras;
use App\Jobs\SendEmail;
use App\Mail\MailNotify;
use App\Models\Tablecolumn;
use App\Models\WorkFromHome;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class WorkFromHomeController extends Controller
{
    //
    public function index()
    {
        $data['menus'] = DB::table('menus')->get();
        return view('wfh/wfh', $data);
    }

    public function getTableManage()
    {
        $where = array();
        $where[] = array('office_head', '=', Auth::user()->username);

        $data['result'] = DB::table('work_from_homes')->where($where)->get();
        // get user creator
        foreach ($data['result'] as $key => $value) {
            $data['result'][$key]->employee_id = DB::table('users')->where('id', $value->employee_id)->value('name');
            $data['result'][$key]->office_head = DB::table('users')->where('id', $value->office_head)->value('name');
            $data['result'][$key]->updated_by = DB::table('users')->where('id', $value->updated_by)->value('name');
            $data['result'][$key]->created_by = DB::table('users')->where('id', $value->created_by)->value('name');
        }

        $data['columns'] = Tablecolumn::getColumn("work_from_homes");

        return view('wfh/wfh_table_manage', $data);
    }

    public function getTable()
    {
        $where = array();
        $where[] = array('employee_id', '=', Auth::user()->username);

        $data['result'] = DB::table('work_from_homes')->where($where)->get();
        // get user creator
        foreach ($data['result'] as $key => $value) {
            $data['result'][$key]->employee_id = DB::table('users')->where('id', $value->employee_id)->value('name');
            $data['result'][$key]->office_head = DB::table('users')->where('id', $value->office_head)->value('name');
            $data['result'][$key]->updated_by = DB::table('users')->where('id', $value->updated_by)->value('name');
            $data['result'][$key]->created_by = DB::table('users')->where('id', $value->created_by)->value('name');
        }

        $data['columns'] = Tablecolumn::getColumn("work_from_homes");
       
        return view('wfh/wfh_table', $data);
    }

    public function getModalManage(Request $request)
    {
        $data = array();
        $where = array();
        $formFields = $request->validate([
            'uid' => ['required'],
            'mode' => [''],
        ]);

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table('work_from_homes')->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
        } else {
            $where[] = array("status", "PENDING");
        }

        $data['mode'] = (isset($formFields['mode'])) ? "true" : "false";

        // dd($data);
        $data['uid'] = $formFields['uid'];

        $data['approver'] = true;
        return view('wfh/wfh_modal')->with($data);
    }

    public function getModal(Request $request)
    {
        $data = array();
        $where = array();
        $formFields = $request->validate([
            'uid' => ['required'],
            'mode' => [''],
        ]);

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table('work_from_homes')->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
        } else {
            $where[] = array("status", "PENDING");
        }

        $data['mode'] = (isset($formFields['mode'])) ? "true" : "false";

        // dd($data);
        $data['uid'] = $formFields['uid'];

        return view('wfh/wfh_modal')->with($data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $validator = Extras::ValidateRequest($request, [
            'uid' => ['required'],
            'purpose' => ['required'],
            'date' => ['required'],
            'work_done' => ['required']
        ]);

        if ($validator['status'] == 0) {
            return response()->json($validator);
            die;
        } else {
            $formFields = $validator['data'];
        }

        
        $WFHData = $formFields;
        // dd($WFHData);
        // Upload Document
        if ($request->hasFile('accomplishment_file')) {

            if ($WFHData['uid'] != "add") {
                $users = DB::table('work_from_homes')->where('id', $formFields['uid'])->first();
                if ($users->accomplishment_file) {
                    Storage::disk('s3')->delete($users->accomplishment_file);
                }
            }
            $fileResponse = $request->file('accomplishment_file')->store('work_request', 's3');
            $WFHData['accomplishment_file'] = $fileResponse;
        }else{
            unset($WFHData['accomplishment_file']);
        }


        if ($formFields['uid'] == "add") {

            $approverOffice = Extras::getApproverHead(Auth::user()->username);
            if (!$approverOffice) {
                $return = array('status' => 2, 'msg' => 'No Office Head Set', 'title' => 'Info!');
                return response()->json($return);
                die;
            }

            $WFHData['office_head'] = $approverOffice;
            $WFHData['applied_by'] = Auth::user()->username;
            $WFHData['employee_id'] = Auth::user()->username;


            $WFHData['created_by'] = Auth::id();
            $createWFH = WorkFromHome::create($WFHData);
            $lastId = $createWFH->id;
            $getApproverEmail = DB::table("employees")->where("employee_id","=", $approverOffice)->value("email");

            $WFHData['fullname'] = Extras::getEmployeeName(Auth::user()->username);
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
            $return = array('status' => 1, 'msg' => 'Successfully submitted request', 'title' => 'Success!');
        } else {

            if($WFHData['status'] == "APPROVE"){
                $WFHData['date_approved'] = date("Y-m-d");
            }
            $WFHData['updated_at'] = Carbon::now();
            $WFHData['updated_by'] = Auth::id();
            $WFHData['email_employee'] = 1;
            $WFHData['read_employee'] = 0;
            $id = $WFHData['uid'];
            unset($WFHData['uid']);
            DB::table('work_from_homes')->where('id', $id)->update($WFHData);
            

            $employee_id = DB::table('work_from_homes')->where('id', $id)->value("employee_id");

            $approverOffice = DB::table('work_from_homes')->where('id', $id)->value("office_head");

            $getRequesterEmail = DB::table("employees")->where("employee_id", "=", $employee_id)->value("email");

            $WFHData['fullname'] = Extras::getEmployeeName($approverOffice);
            $WFHData['headfullname'] = Extras::getEmployeeName($employee_id);
            $data = array(
                'emailtype' => "wfh_notification_update",
                'subject' => "Work Task Request Update",
                'email' => $getRequesterEmail,
                'from_title' => "AtTask",
                'data' => $WFHData
            );

            try {
                SendEmail::dispatch($data);
                // Mail::to($getRequesterEmail)->send(new MailNotify($data));
            } catch (Exception $th) {
                dump($th);
            }
            $return = array('status' => 1, 'msg' => 'Successfully submitted request', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function delete(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'code' => ['required']
        ]);

        $expensesData = DB::table('work_from_homes')->where('id', $formFields['code'])->first();

        $delete = DB::table('work_from_homes')->where('id', '=', $formFields['code'])->delete();

        if ($delete) {
            $return = array('status' => 1, 'msg' => 'Successfully deleted work task', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function markRead(Request $request)
    {
        $return = array('status' => 0, 'msg' => '', 'title' => '!');

        $validator = Extras::ValidateRequest($request, [
            'uid' => ['required']
        ]);

        if ($validator['status'] == 0) {
            return response()->json($validator);
            die;
        } else {
            $formFields = $validator['data'];
        }

        $updateWFHData = array();
        $updateWFHData = array('read_employee' => 1);

        DB::table('work_from_homes')->where('id', $formFields['uid'])->update($updateWFHData);
        $counter = DB::table('work_from_homes')->where("employee_id", Auth::user()->username)->where("read_employee", 0)->count();
        if ($counter == 0) {
            $return['title'] = "none";
        } else {
            $return['title'] = $counter;
        }
        return response()->json($return);
    }

    public function markReadManage(Request $request)
    {
        $return = array('status' => 0, 'msg' => '', 'title' => '!');

        $validator = Extras::ValidateRequest($request, [
            'uid' => ['required']
        ]);

        if ($validator['status'] == 0) {
            return response()->json($validator);
            die;
        } else {
            $formFields = $validator['data'];
        }

        $updateWFHData = array();
        $updateWFHData = array('read_office_head' => 1);

        DB::table('work_from_homes')->where('id', $formFields['uid'])->update($updateWFHData);
        $counter = DB::table('work_from_homes')->where("office_head", Auth::user()->username)->where("status", "PENDING")->where("read_office_head", 0)->count();
        if($counter == 0){
            $return['title'] = "none";
        }else{
            $return['title'] = $counter;
        }
        

        return response()->json($return);
    }
}
