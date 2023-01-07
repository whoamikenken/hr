<?php

namespace App\Http\Controllers;

use App\Models\Extras;
use App\Models\Department;
use App\Models\Tablecolumn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    //
    public function index()
    {
        $data['menus'] = DB::table('menus')->get();
        return view('setup/department', $data);
    }

    public function getTable()
    {
        $data['result'] = DB::table("departments")->get();

        // get user creator
        foreach ($data['result'] as $key => $value) {

            $data['result'][$key]->modified_by = DB::table('users')->where('id', $value->modified_by)->value('name');
            $data['result'][$key]->created_by = DB::table('users')->where('id', $value->created_by)->value('name');
        }

        $data['columns'] = Tablecolumn::getColumn("departments");
        // dd($data);
        return view('setup/department_table', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table("departments")->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
            $data['color'] = Extras::rgb_to_hex($data['color']);
        }

        $data['uid'] = $formFields['uid'];
        return view('setup/department_modal', $data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $validator = Extras::ValidateRequest(
            $request,
            [
                'uid' => ['required'],
                'code' => ['required', ($request->input()['uid'] == "add") ? Rule::unique('agencies', 'code') : ""],
                'department' => ['required'],
                'description' => ['required']
            ]
        );

        if ($validator['status'] == 0) {
            return response()->json($validator);
            die;
        } else {
            $formFields = $validator['data'];
        }

        $formFields['color'] =  Extras::hex2rgba($formFields['color']);

        if ($formFields['color'] == "add") {
            unset($formFields['uid']);
            $formFields['created_by'] = Auth::id();
            $formFields['updated_at'] = "";
            Department::create($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully added department', 'title' => 'Success!');
        } else {
            $formFields['updated_at'] = Carbon::now();
            $formFields['modified_by'] = Auth::id();
            $id = $formFields['uid'];
            unset($formFields['uid']);
            DB::table("departments")->where('id', $id)->update($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully updated department', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function delete(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'code' => ['required']
        ]);

        $delete = DB::table("departments")->where('id', '=', $formFields['code'])->delete();

        if ($delete) {
            $return = array('status' => 1, 'msg' => 'Successfully deleted department', 'title' => 'Success!');
        }

        return response()->json($return);
    }
}
