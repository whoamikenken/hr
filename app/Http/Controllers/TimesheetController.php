<?php

namespace App\Http\Controllers;

use App\Models\Tablecolumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimesheetController extends Controller
{
    //
    public function index()
    {
        $data['menus'] = DB::table('menus')->get();
        return view('logs/web_logs', $data);
    }

    public function getTable()
    {
        $where = array();
        // $where[] = array('office_head', '=', Auth::user()->username);

        $data['result'] = DB::table('timesheets_trail_history')->where($where)->get();
        // get user creator
        foreach ($data['result'] as $key => $value) {
            $data['result'][$key]->name = DB::table('users')->where('id', $value->employee_id)->value('name');
        }

        return view('logs/web_logs_table', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();
        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table('timesheets_trail_history')->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
        }
        return view('logs/web_logs_modal')->with($data);
    }
}
