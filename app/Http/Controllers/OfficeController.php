<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Extras;
use App\Models\Office;
use App\Models\Tablecolumn;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OfficeController extends Controller
{
    //
    public function index()
    {
        $data['menus'] = DB::table('menus')->get();
        return view('setup/office', $data);
    }
    
    public function getTable()
    {
        $data['result'] = DB::table("offices")->get();
        
        // get user creator
        foreach ($data['result'] as $key => $value) {
            
            $data['result'][$key]->modified_by = DB::table('users')->where('id', $value->modified_by)->value('name');
            $data['result'][$key]->created_by = DB::table('users')->where('id', $value->created_by)->value('name');
        }
        
        $data['columns'] = Tablecolumn::getColumn("offices");
        // dd($data);
        return view('setup/office_table', $data);
    }
    
    public function getModal(Request $request)
    {
        $data = array();
        
        $formFields = $request->validate([
            'uid' => ['required'],
        ]);
        
        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table("offices")->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
            $data['color'] = Extras::rgb_to_hex($data['color']);
        }
        

        $data['work_parameter_select'] = Extras::getWorkParameterForDropdown();

        $data['uid'] = $formFields['uid'];
        $data['department_select'] = DB::table('departments')->get();
        return view('setup/office_modal', $data);
    }
    
    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');
        
        $validator = Extras::ValidateRequest($request,
        [
            'uid' => ['required'],
            'code' => ['required', ($request->input()['uid'] == "add") ? Rule::unique('agencies', 'code') : ""],
            'department' => ['required'],
            'description' => ['required']
        ]);
        
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
            Office::create($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully added office', 'title' => 'Success!');
        } else {
            $formFields['updated_at'] = Carbon::now();
            $formFields['modified_by'] = Auth::id();
            $id = $formFields['uid'];
            unset($formFields['uid']);
            DB::table("offices")->where('id', $id)->update($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully updated office', 'title' => 'Success!');
        }
        
        return response()->json($return);
    }
    
    public function delete(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');
        
        $formFields = $request->validate([
            'code' => ['required']
        ]);
        
        $delete = DB::table("offices")->where('id', '=', $formFields['code'])->delete();
        
        if ($delete) {
            $return = array('status' => 1, 'msg' => 'Successfully deleted office', 'title' => 'Success!');
        }
        
        return response()->json($return);
    }
}
