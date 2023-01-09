<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Extras;
use App\Models\Usertype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsertypeController extends Controller
{
    
    public function getTable()
    {
        $data['result'] = DB::table('usertype')->get();

        // get user creator
        foreach ($data['result'] as $key => $value) {

            $data['result'][$key]->modified_by = DB::table('users')->where('id', $value->modified_by)->value('name');
            $data['result'][$key]->created_by = DB::table('users')->where('id', $value->created_by)->value('name');
        }

        return view('user/usertype_table', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required'],
        ]);

        $readAccess = $editAccess = $addAccess = $delAccess = array();

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table('usertype')->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
            $readAccess = explode(",",$data['read']);
            $editAccess = explode(",", $data['edit']);
            $addAccess = explode(",", $data['add']);
            $delAccess = explode(",", $data['delete']);
        }

        $data['uid'] = $formFields['uid'];

        // No Cost Permission
        $noEdit = Extras::getNoEdit();
        $noAdd = Extras::getNoAdd();
        $noDelete = Extras::getNoDel();

        $menus = Extras::getMenusList();
        $access = array();
        $access["Main"][] = array('root_id' => 0, "menu_id" => 1, "title" => "Dashboard");
        $access["Main"][] = array('root_id' => 0, "menu_id" => 2, "title" => "Employee List");
        $access["Main"][] = array('root_id' => 0, "menu_id" => 3, "title" => "User Management");
        $access["Main"][] = array('root_id' => 0, "menu_id" => 13, "title" => "My Profile");
        $access["Main"][] = array('root_id' => 0, "menu_id" => 14, "title" => "My Attendance");
        $access["Main"][] = array('root_id' => 0, "menu_id" => 15, "title" => "Work Request");
        $access["Main"][] = array('root_id' => 0, "menu_id" => 16, "title" => "Manage Request");
        foreach ($menus as $key => $value) {
            $getSubmenus = Extras::getSubMenus($value->menu_id);
            if ($value->menu_id == 2) {
                $access["Employee Management"][] = array('root_id' => 888, "menu_id" => 803, "title" => "Profile");
                $access["Employee Management"][] = array('root_id' => 888, "menu_id" => 804, "title" => "Schedule");
            }
            foreach ($getSubmenus as $row => $val) {
                $access[$value->title][] = array('root_id' => $value->menu_id, "menu_id" => $val->menu_id, "title" => $val->title);
            }
        }

        $accessColumn = "<div class='row'>";
        foreach ($access as $mainMenu => $subMenu) {
            $accessColumn .= '<div class="col-md-6 col-sm-12 mb-5"><h3 class="text-center fs-bold">' . $mainMenu . '</h3>';
            $accessColumn .= '<table>
                <thead>
                    <tr class="text-center">
                        <th class="p-1">Menu</th>
                        <th class="p-1">Read</th>
                        <th class="p-1">Add</th>
                        <th class="p-1">Delete</th>
                        <th class="p-1">Edit</th>
                    </tr>
                </thead>';

            foreach ($subMenu as $ky => $subMenuVal) {
                $subMenuVal = (object) $subMenuVal;
                $accessColumn .= '</tr>';
                
                $accessColumn .= '
                    <td class="pe-1">
                        '.$subMenuVal->title.'
                    </td>';
                $accessColumn .=  '<td class="pe-1 text-center">
                    <input class="form-check-input" type="checkbox" name="rAccess" value="' . $subMenuVal->menu_id . '" root="'. $subMenuVal->root_id.'" '.(in_array($subMenuVal->menu_id, $readAccess)?"checked='checked'":"").'>
                </td>';

                $accessColumn .=  '<td class="pe-1 text-center">';
                if (!in_array($subMenuVal->menu_id, $noAdd)) {
                    $accessColumn .=  '<input class="form-check-input" type="checkbox" name="aAccess" value="' . $subMenuVal->menu_id . '" root="'. $subMenuVal->root_id.'" '.(in_array($subMenuVal->menu_id, $addAccess)?"checked='checked'":"").'>';
                }
                $accessColumn .=  '</td>';

                $accessColumn .=  '<td class="pe-1 text-center">';
                if (!in_array($subMenuVal->menu_id, $noDelete)) {
                    $accessColumn .=  '<input class="form-check-input" type="checkbox" name="dAccess" value="' . $subMenuVal->menu_id . '" root="'. $subMenuVal->root_id.'" '.(in_array($subMenuVal->menu_id, $delAccess)?"checked='checked'":"").'>';
                }
                $accessColumn .=  '</td>';

                $accessColumn .=  '<td class="pe-1 text-center">';
                if(!in_array($subMenuVal->menu_id, $noEdit)){
                    $accessColumn .=  '<input class="form-check-input" type="checkbox" name="eAccess" value="' . $subMenuVal->menu_id . '" root="'. $subMenuVal->root_id.'" '.(in_array($subMenuVal->menu_id, $editAccess)?"checked='checked'":"").'>';
                }
                $accessColumn .=  '</td>';

                $accessColumn .= '</tr>';
            }
            $accessColumn .= "</table></div>";
        }
        $accessColumn .= "</div>";

        // dd($accessColumn);
        $data['showAccess'] = $accessColumn;
        return view('user/usertype_modal', $data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'uid' => ['required'],
            'code' => ['required'],
            'description' => ['required']
        ]);
        
        
        if ($formFields['uid'] == "add") {
            unset($formFields['uid']);
            $formFields['created_by'] = Auth::id();
            $formFields['read'] = $request->input("edatalistRead");
            $formFields['add'] = $request->input("edatalistAdd");
            $formFields['delete'] = $request->input("edatalistDel");
            $formFields['edit'] = $request->input("edatalistEdit");
            $formFields['updated_at'] = "";
            Usertype::create($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully added user type', 'title' => 'Success!');
        } else {
            $formFields['updated_at'] = Carbon::now();
            $formFields['modified_by'] = Auth::id();
            $formFields['read'] = $request->input("edatalistRead");
            $formFields['add'] = $request->input("edatalistAdd");
            $formFields['delete'] = $request->input("edatalistDel");
            $formFields['edit'] = $request->input("edatalistEdit");
            $id = $formFields['uid'];
            unset($formFields['uid']);
            DB::table('usertype')->where('id', $id)->update($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully updated user type', 'title' => 'Success!');
        }

        // Update Other user with same type
        $userPermission = array();
        $userPermission['read'] = $formFields['read'];
        $userPermission['add'] = $formFields['add'];
        $userPermission['edit'] = $formFields['edit'];
        $userPermission['delete'] = $formFields['delete'];
        DB::table('users')->where('user_type', $formFields['code'])->update($userPermission);

        return response()->json($return);
    }

    public function delete(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'code' => ['required']
        ]);

        $delete = DB::table('usertype')->where('id', '=', $formFields['code'])->delete();

        if ($delete) {
            $return = array('status' => 1, 'msg' => 'Successfully deleted user type', 'title' => 'Success!');
        }

        return response()->json($return);
    }
}
