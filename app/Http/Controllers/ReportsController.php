<?php

namespace App\Http\Controllers;

use App\Models\Extras;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportsController extends Controller
{
    //
    public function getModalFilter(Request $request)
    {
        $data = array();

        $formFields = $request->validate([
            'tag' => ['required'],
            'reportName' => ['required'],
        ]);

        $data['tag'] = $formFields['tag'];
        $data['reportName'] = $formFields['reportName'];

        $column = array();
        $showColumn = "";
        if($data['tag'] == "hrreport"){
            $column = array();
            $showColumn .= Extras::returnEmployeeCols("General Information");
            $showColumn .= Extras::returnEmployeeCols("Contact Information");
            
            $data['showColumn'] = $showColumn;
        }

        // $data['employee_select'] = DB::table('employees')->where("isactive", "Active")->get();
        // $data['users_select'] = DB::table('users')->where("user_type", "sales")->get();
        // dd($showColumn);
        return view('report/report_filter_modal', $data);
    }

    public function generateReport(Request $request)
    {
        $data = array();

        $formFields = $request->input();

        $whereFilter = $formFields;
        unset($whereFilter['_token']);
        unset($whereFilter['tag']);
        unset($whereFilter['edata']);
        unset($whereFilter['edatalist']);
        unset($whereFilter['reportName']);

        $data['reportName'] = $formFields['reportName'];
        $table = "";
        $where = array();
        
        if($formFields['tag'] == "hrreport"){
            foreach ($whereFilter as $key => $value) {
                if($value){
                    $where[] = array($key, '=', $value);
                }
            }

            $data['dateof'] = "As of " .date("F j, Y");


            $table = "employees";
            $columnList = $formFields['edatalist'];
            $getColumn = explode(",", $columnList);
            foreach ($getColumn as $key => $value) {
                $data['edatalist'][$value] = Extras::showDesc($value);
            }
            if ($table) {
                $data['result'] = DB::table($table)->where($where)->get();
            }
            foreach ($data['result'] as $key => $value) {
                if (isset($data['result'][$key]->office)) $data['result'][$key]->office = DB::table('offices')->where('code', $value->office)->value('description');
                if (isset($data['result'][$key]->department)) $data['result'][$key]->department = DB::table('departments')->where('code', $value->department)->value('description');
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("s3")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("s3")->url($value->user_profile);
            }

            // dd($data);
            return response()->view('report/masterlistPDF', $data, 200)->header('Content-Type', 'application/pdf');
        }elseif ($formFields['tag'] == "attendance") {
            $between = array();
            foreach ($whereFilter as $key => $value) {
                if ($key == "from" || $key == "to") {
                    $between[] = $value;
                } else {
                    if ($value) {
                        $where[] = array("timesheets.".$key, '=', $value);
                    }
                }
            }
            if(count($between) > 1){
                $data['dateof'] = "From " . $between[0] . " to " . $between[1];
            }else{
                $data['dateof'] = "As of " . date("F j, Y");
            }
            

            $table = "timesheets";
            // DB::enableQueryLog();
            if ($table) {
                $data['result'] = DB::table($table)->join('employees', 'employees.employee_id', '=', 'timesheets.employee_id')->where($where)->orderBy('timesheets.time_in', 'desc')->get();
            }

            $data['edatalist']['fullname'] = Extras::showDesc('fullname');
            $data['edatalist']['employee_id'] = Extras::showDesc('employee_id');
            $data['edatalist']['office'] = Extras::showDesc('office');
            $data['edatalist']['department'] = Extras::showDesc('department');
            

            foreach ($data['result'] as $key => $value) {
               
                if (isset($data['result'][$key]->office)) $data['result'][$key]->office = DB::table('offices')->where('code', $value->office)->value('description');
                if (isset($data['result'][$key]->department)) $data['result'][$key]->department = DB::table('departments')->where('code', $value->department)->value('description');
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("s3")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("s3")->url($value->user_profile);

                $otherData = Timesheet::employeeLogsData($value->employee_id, $value->time_in, $value->time_out);
                $data['result'][$key]->status = $otherData['status'];
                $data['result'][$key]->late = $otherData['minutesLate'];
                $data['result'][$key]->starttime = Extras::convertTo12HourFormatTIME($otherData['starttime']);
                $data['result'][$key]->endtime = Extras::convertTo12HourFormatTIME($otherData['endtime']);
                $data['result'][$key]->time_in = Extras::convertTo12HourFormatYMD($data['result'][$key]->time_in);
                $data['result'][$key]->time_out = Extras::convertTo12HourFormatYMD($data['result'][$key]->time_out);
            }
            // dd(DB::getQueryLog());
            return response()->view('report/attendancePDF', $data, 200)->header('Content-Type', 'application/pdf');
        }  
    }
}
