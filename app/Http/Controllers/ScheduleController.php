<?php

namespace App\Http\Controllers;

use App\Models\Extras;
use App\Models\Schedule;
use App\Models\Tablecolumn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    //
    public function index()
    {
        $data['menus'] = DB::table('menus')->get();
        return view('setup/schedule', $data);
    }

    public function getTable()
    {
        $data['result'] = DB::table("schedules")->get();

        // get user creator
        foreach ($data['result'] as $key => $value) {

            $data['result'][$key]->modified_by = DB::table('users')->where('id', $value->modified_by)->value('name');
            $data['result'][$key]->created_by = DB::table('users')->where('id', $value->created_by)->value('name');
        }

        $data['columns'] = Tablecolumn::getColumn("schedules");
        return view('setup/schedule_table', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table("schedules")->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
        }

        $data['uid'] = $formFields['uid'];
        $data['dow'] =
        array("M" => "Monday", "T" => "Tuesday", "W" => "Wednesday", "TH" => "Thursday", "F" => "Friday", "S" => "Saturday", "SUN" => "Sunday");
        $data['sched_per_day'] = array();
        foreach ($data['dow'] as $dow_code => $dow_desc) {
            $where = array();
            $where[] = array('dayofweek', $dow_code);
            if($formFields['uid'] != "add") {
            $where[] = array('schedid',$formFields['uid']);
            $sched = DB::table('schedules_detail')->where($where)->get();
            $data['sched_per_day'][$dow_code] = $sched;
            }else{
                $data['sched_per_day'][$dow_code] = array();
            }
        }

        return view('setup/schedule_modal', $data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        
        $formFields = $request->validate([
            'uid' => ['required'],
            'code' => ['required'],
            'description' => ['required']
        ]);
        
        $scheduleData = $request->input("schedule");
        
        
        // dd($scheduleData);
        if ($formFields['uid'] == "add") {
            unset($formFields['uid']);
            $formFields['created_by'] = Auth::id();
            $formFields['updated_at'] = Carbon::now();
            $schedCreate = Schedule::create($formFields);
            $lastId = $schedCreate->id;
            $return = array('status' => 1, 'msg' => 'Successfully added schedule', 'title' => 'Success!');

            foreach (explode("|", $scheduleData) as $key => $value) {
                $schedData = explode("~u~", $value);
                $time = explode("-", $schedData[1]);

                $schedDataInsert = array();
                $schedDataInsert['schedid'] = $lastId;
                $schedDataInsert['starttime'] = isset($time[0]) ? date("H:i:s", strtotime($time[0])) : '';
                $schedDataInsert['endtime'] = isset($time[1]) ? date("H:i:s", strtotime($time[1])) : '';
                $schedDataInsert['tardy_start'] = isset($schedData[2]) ? date("H:i:s", strtotime($schedData[2])) : '';
                $schedDataInsert['absent_start'] = isset($schedData[3]) ? date("H:i:s", strtotime($schedData[3])) : '';
                $schedDataInsert['dayofweek'] = $schedData[0];
                $schedDataInsert['idx'] = Extras::getIDX($schedData[0]);
                $schedDataInsert['description'] = $formFields['description'];
                DB::table('schedules_detail')->insert($schedDataInsert);
            }
        } else {
            $formFields['updated_at'] = Carbon::now();
            $formFields['modified_by'] = Auth::id();
            $id = $formFields['uid'];
            unset($formFields['uid']);
            DB::table("schedules")->where('id', $id)->update($formFields);

            // Delete detail
            DB::table("schedules_detail")->where('schedid', '=', $id)->delete();
            foreach (explode("|", $scheduleData) as $key => $value) {
                $schedData = explode("~u~", $value);
                // dd($schedData[0]);
                $time = explode("-", $schedData[1]);

                $schedDataInsert = array();
                $schedDataInsert['schedid'] = $id;
                $schedDataInsert['starttime'] = isset($time[0]) ? date("H:i:s", strtotime($time[0])) : '';
                $schedDataInsert['endtime'] = isset($time[1]) ? date("H:i:s", strtotime($time[1])) : '';
                $schedDataInsert['tardy_start'] = isset($schedData[2]) ? date("H:i:s", strtotime($schedData[2])) : '';
                $schedDataInsert['absent_start'] = isset($schedData[3]) ? date("H:i:s", strtotime($schedData[3])) : '';
                $schedDataInsert['dayofweek'] = $schedData[0];
                $schedDataInsert['idx'] = Extras::getIDX($schedData[0]);
                $schedDataInsert['description'] = $formFields['description'];
                DB::table('schedules_detail')->insert($schedDataInsert);
            }

            $return = array('status' => 1, 'msg' => 'Successfully updated schedule', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function delete(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'code' => ['required']
        ]);

        $delete = DB::table("schedules")->where('id', '=', $formFields['code'])->delete();

        if ($delete) {
            $return = array('status' => 1, 'msg' => 'Successfully deleted schedule', 'title' => 'Success!');
        }

        return response()->json($return);
    }
}
