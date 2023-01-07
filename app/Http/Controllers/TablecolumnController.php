<?php

namespace App\Http\Controllers;

use App\Models\Tablecolumn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TablecolumnController extends Controller
{
    public function getTable()
    {
        $data['result'] = DB::table('setups')->get();

        return view('config/tablecolumn_table', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'uid' => ['required']
        ]);
        
        if ($formFields['uid'] != "add") {
            $record = DB::table('tablecolumns')->where('table_id', $formFields['uid'])->get();
            
            if (isset($record[0])) {
                foreach ($record as $key => $value) {
                    $data['record'][] = $value->title;
                }
            }else{
                $data['record'] = array();
            }
        }
        
        
        $data['uid'] = $formFields['uid'];

        $table = DB::table('setups')->where('id', $formFields['uid'])->get();
        $table = $table[0]->table;
        
        $column = DB::select('SHOW COLUMNS FROM '. $table);
        
        $data['column'] = Tablecolumn::processColumnName($column);

        return view('config/tablecolumn_modal', $data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');
        $formFields = $request->input();
        unset($formFields['_token']);

        $table_id = $formFields['uid'];
        Tablecolumn::where('table_id', $table_id)->delete();
        unset($formFields['uid']);
        
        foreach ($formFields as $key => $value) {
            $insert = array();
            $insert['column'] = $key;
            $insert['title'] = Tablecolumn::getColumnDescription($key);
            $insert['table_id'] = $table_id;
            $insert['table'] = Tablecolumn::getTableName($table_id);
            $insert['status'] = "Show";
            $insert['created_by'] = Auth::id();
            Tablecolumn::create($insert);
        }

        $return = array('status' => 1, 'msg' => 'Successfully updated table config', 'title' => 'Success!');

        return response()->json($return);
    }

}
