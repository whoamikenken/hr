<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Campus;
use App\Models\Extras;
use App\Models\Tablecolumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CampusController extends Controller
{
    public function index()
    {
        $data['menus'] = DB::table('menus')->get();
        return view('setup/campus', $data);
    }

    public function getTable()
    {
        $data['result'] = DB::table("campuses")->get();

        // get user creator
        foreach ($data['result'] as $key => $value) {

            $data['result'][$key]->modified_by = DB::table('users')->where('id', $value->modified_by)->value('name');
            $data['result'][$key]->created_by = DB::table('users')->where('id', $value->created_by)->value('name');
        }

        $data['columns'] = Tablecolumn::getColumn("campuses");
        // dd($data);
        return view('setup/campus_table', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table("campuses")->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
        }

        $data['uid'] = $formFields['uid'];
        $data['color'] = Extras::rgb_to_hex($data['color']);
        // dd($data['color']);
        return view('setup/campus_modal', $data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'uid' => ['required'],
            'code' => ['required'],
            'color' => ['required'],
            'description' => ['required']
        ]);

        $formFields['color'] =  Extras::hex2rgba($formFields['color']);


        if ($formFields['color'] == "add") {
            unset($formFields['uid']);
            $formFields['created_by'] = Auth::id();
            $formFields['updated_at'] = "";
            Campus::create($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully added campus', 'title' => 'Success!');
        } else {
            $formFields['updated_at'] = Carbon::now();
            $formFields['modified_by'] = Auth::id();
            $id = $formFields['uid'];
            unset($formFields['uid']);
            DB::table("campuses")->where('id', $id)->update($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully updated campus', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function delete(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'code' => ['required']
        ]);

        $delete = DB::table("campuses")->where('id', '=', $formFields['code'])->delete();

        if ($delete) {
            $return = array('status' => 1, 'msg' => 'Successfully deleted campus', 'title' => 'Success!');
        }

        return response()->json($return);
    }
}
