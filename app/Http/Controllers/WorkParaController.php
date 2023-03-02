<?php

namespace App\Http\Controllers;

use App\Models\WorkPara;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WorkParaController extends Controller
{
    //
    public function getTable()
    {
        $data['result'] = DB::table('work_paras')->get();

        return view('config/workpara_table', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required']
        ]);

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table('work_paras')->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
        }

        $data['uid'] = $formFields['uid'];

        return view('config/workpara_modal', $data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'uid' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'description' => ['required']
        ]);

        if ($formFields['uid'] == "add") {
            unset($formFields['uid']);
            $formFields['created_by'] = Auth::id();
            $formFields['updated_at'] = "";
            WorkPara::create($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully added work parameter', 'title' => 'Success!');
        } else {
            $formFields['updated_at'] = Carbon::now();
            // $formFields['modified_by'] = Auth::id();
            $id = $formFields['uid'];
            unset($formFields['uid']);
            DB::table("work_paras")->where('id', $id)->update($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully updated work parameter', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function delete(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'code' => ['required']
        ]);

        $delete = DB::table('work_paras')->where('id', '=', $formFields['code'])->delete();

        if ($delete) {
            $return = array('status' => 1, 'msg' => 'Successfully deleted work parameter', 'title' => 'Success!');
        }

        return response()->json($return);
    }
}
