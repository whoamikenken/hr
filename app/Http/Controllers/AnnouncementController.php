<?php

namespace App\Http\Controllers;

use App\Models\Tablecolumn;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    //
    public function index()
    {
        $data['menus'] = DB::table('menus')->get();
        return view('setup/announcement', $data);
    }

    public function getTable()
    {
        $data['result'] = DB::table("announcements")->get();

        // get user creator
        foreach ($data['result'] as $key => $value) {

            $data['result'][$key]->modified_by = DB::table('users')->where('id', $value->modified_by)->value('name');
            $data['result'][$key]->created_by = DB::table('users')->where('id', $value->created_by)->value('name');
        }

        $data['columns'] = Tablecolumn::getColumn("announcements");
        // dd($data);
        return view('setup/announcement_table', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table("announcements")->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
        }

        $data['uid'] = $formFields['uid'];
        // dd($data);
        return view('setup/announcement_modal', $data);
    }

    public function viewAnnouncement(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'id' => ['required'],
        ]);

        $data['record'] = DB::table("announcements")->where('id', $formFields['id'])->get();
        $data = $data['record'][0];
        $data = json_decode(json_encode($data), true);

        return view('setup/announcement_view', $data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'uid' => ['required'],
            'title' => ['required'],
            'description' => ['required'],
            'content' => ['required']
        ]);

        if ($formFields['uid'] == "add") {
            unset($formFields['uid']);
            $formFields['created_by'] = Auth::id();
            $formFields['updated_at'] = "";
            Announcement::create($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully added announcement', 'title' => 'Success!');
        } else {
            $formFields['updated_at'] = Carbon::now();
            $formFields['modified_by'] = Auth::id();
            $id = $formFields['uid'];
            unset($formFields['uid']);
            DB::table("announcements")->where('id', $id)->update($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully updated announcement', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function delete(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'code' => ['required']
        ]);

        $delete = DB::table("announcements")->where('id', '=', $formFields['code'])->delete();

        if ($delete) {
            $return = array('status' => 1, 'msg' => 'Successfully deleted announcement', 'title' => 'Success!');
        }

        return response()->json($return);
    }
}
