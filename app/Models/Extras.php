<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Extras extends Model
{
    use HasFactory;

    public static function getMedical(String $code = null)
    {
        return DB::table('medical')->where('code', $code)->value('description');
    }

    public static function getCountry(String $code = null)
    {
        return DB::table('countries')->where('code', $code)->value('description');
    }

    public static function getAccessList(String $code = null, String $username = null)
    {
        return DB::table('users')->where('username', $username)->value($code);
    }

    public static function getAccessListUserType(String $code = null, String $type = null)
    {
        return DB::table('usertype')->where('code', $type)->value($code);
    }

    public static function countEmployeeRegistered($month = "")
    {
        
        if(!$month) $month = date("m");
        $result = DB::select("SELECT employee_id FROM employees WHERE MONTH(`date_applied`) = $month");

        return count($result);
    }

    public static function countPresentEmployee()
    {
        $result =DB::table('employees')->join('timesheets_trail_history', 'employees.employee_id', '=', 'timesheets_trail_history.employee_id')->select('employees.employee_id')->where(DB::raw("date(timesheets_trail_history.log_time)"), "=", date('Y-m-d'))->count();
        return $result;
    }

    public static function countAbsentEmployee()
    {
        $result = DB::table('employees')->join('timesheets_trail_history', 'employees.employee_id', '=', 'timesheets_trail_history.employee_id')->select('employees.employee_id')->where(DB::raw("date(timesheets_trail_history.log_time)"), "=", date('Y-m-d'))->count();

        $resultTotalEmp = DB::table('employees')->count();
        $absent = $resultTotalEmp - $result;
        return $absent;
    }

    public static function countStudentRegisteredAll()
    {
        $result = DB::select("SELECT student_id FROM students");

        return count($result);
    }

    public static function countEmployeeRegisteredAll()
    {
        $result = DB::select("SELECT employee_id FROM employees");

        return count($result);
    }

    public static function countActiveApplicant()
    {
        $result = DB::select("SELECT oec_flight_departure FROM applicants WHERE isactive = 'Active'");

        return count($result);
    }

    public static function countExpiredPassportAndVisa()
    {
        $result = DB::select("SELECT visa_date_expired, passport_validity FROM applicants WHERE `visa_date_expired` < CURDATE() OR passport_validity < CURDATE()");

        return count($result);
    }

    public static function getDepartureMonth($month = null)
    {
        $result = DB::select("SELECT visa_date_expired, passport_validity,oec_flight_departure FROM applicants WHERE MONTH(oec_flight_departure) = $month AND YEAR(oec_flight_departure) = YEAR(CURDATE()) AND isactive = 'Active'");

        return count($result);
    }

    public static function getJobOrderMonth($month = null)
    {
        $result = DB::select("SELECT visa_date_expired, passport_validity,jo_received FROM applicants WHERE MONTH(jo_received) = $month AND YEAR(jo_received) = YEAR(CURDATE()) AND isactive = 'Active'");

        return count($result);
    }

    public static function getApplicantRegistered($month = null)
    {
        $result = DB::select("SELECT visa_date_expired, passport_validity,date_applied FROM applicants WHERE MONTH(date_applied) = $month AND YEAR(date_applied) = YEAR(CURDATE()) AND isactive = 'Active'");

        return count($result);
    }

    public static function getApplicantInBranch($branch = null)
    {
        $result = DB::select("SELECT visa_date_expired, passport_validity,oec_flight_departure FROM applicants WHERE branch = '$branch' AND isactive = 'Active'");

        return count($result);
    }

    public static function getEmployeeInOffce($office = null)
    {
        $result = DB::select("SELECT * FROM employees WHERE office = '$office'");

        return count($result);
    }

    public static function getBranchDeployedMonth($month = null, $branch = null)
    {
        $result = DB::select("SELECT * FROM applicants WHERE branch = '$branch' AND MONTH(oec_flight_departure) = $month AND YEAR(oec_flight_departure) = YEAR(CURDATE()) AND isactive = 'Active'");

        return count($result);
    }

    public static function getOfficeEmployeeAttendanceMonth($month = null, $campus = null)
    {
        $result = DB::select("SELECT * FROM students WHERE campus = '$campus' AND MONTH(date_applied) = $month AND YEAR(date_applied) = YEAR(CURDATE())");

        return count($result);
    }

    public static function getBranchList($branch = null)
    {   
        $wh = "WHERE 1";
        if($branch) $wh .= " AND code = '$branch'"; 
        $result = DB::select("SELECT * FROM branches $wh");

        return $result;
    }

    public static function getOfficeList($office = null)
    {
        $wh = "WHERE 1";
        if ($office) $wh .= " AND code = '$office'";
        $result = DB::select("SELECT * FROM offices $wh");

        return $result;
    }

    public static function getBioStatusDesc()
    {
        $result = DB::select("SELECT bio_status FROM applicants GROUP BY bio_status");

        return $result;
    }

    public static function getMenusList()
    {
        $result = DB::table('menus')->where('root',"=", 0)->where('status', "=", "show")->get();
        return $result;
    }

    public static function getSubMenus($rootMenu = null)
    {
        $result = DB::table('menus')->where('root', "=", $rootMenu)->where('status', "=", "show")->get();
        return $result;
    }

    public static function getApplicantCountWithBioStatus($bio_status = null)
    {
        $result = DB::select("SELECT visa_date_expired, passport_validity FROM applicants WHERE bio_status = '$bio_status' AND isactive = 'Active'");

        return count($result);
    }

    public static function countUser($table = null)
    {
        if($table == "Professor"){
            $result = DB::select("SELECT * FROM users WHERE user_type = 'Professor'");
        }else{
            $result = DB::select("SELECT * FROM $table WHERE isactive = 'Active'");
        }
        return count($result);
    }

    public static function getTopPerformingSales()
    {
        $result = DB::select("SELECT users.*, (SELECT COUNT(*) FROM applicants  WHERE MONTH(oec_flight_departure) = '10' AND YEAR(oec_flight_departure) = YEAR(CURDATE()) AND isactive = 'Active' AND sales_manager = a.id ) AS counter FROM users a WHERE a.`user_type` = 'Sales' ORDER BY counter DESC");

        return $result;
    }

    public static function getNoAdd()
    {
        return array(999, 13, 14, 1, 5, 801, 802, 803, 804,17);
    }

    public static function getNoDel()
    {
        return array(999, 13, 14, 1, 5, 801, 802, 803, 804,17);
    }

    public static function getNoEdit()
    {
        return array(5,999,1,13,14,17);
    }

    public static function requestToEmpsys($link, $type = 'get', $data = null, $token = null){
        $header =  array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        );

        $response = Http::withHeaders($header)->withOptions([
            'debug' => fopen('php://stderr', 'w'),
        ])->retry(3, 60000)->$type(
            $link,
            $data
        );

        $responseData = $response->getBody()->getContents();
        return $responseData;
       
    }

    public static function isExist(String $table = null, String $id = null, String $column = null)
    {
        $isExistQuery =  DB::table($table)->where($column, "=", $id)->get();
        if (count($isExistQuery) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendRequest($link, $type = 'get', $data = null, $token = null)
    {
        $header =  array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        );
    
        $response = Http::withHeaders($header)->withOptions([
            'debug' => fopen('php://stderr', 'w'),
        ])->retry(3, 60000)->$type(
            $link,
            $data
        );

        $responseData = $response->getBody()->getContents();
        return $responseData;
    }

    public static function sendRequestAsync($link, $type = 'get', $data = null, $token = null)
    {
        $promise = Http::async()->withOptions([
            'debug' => fopen('php://stderr', 'w'),
        ])->retry(3, 60000)->$type(
            $link,
            $data
        )->then(function ($response) {
            // echo "Response received!";
            echo $response->body();
        });

    }

    public static function getIDX($data)
    {
        $return = array(
            "M" => "1",
            "T" => "2",
            "W" => "3",
            "TH" => "4",
            "F" => "5",
            "S" => "6",
            "SUN" => "7"
        );

        return $return[$data];
    }

    public static function ValidateRequest($request, array $rule)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            $errorKey = key($validator->errors()->messages());
            $msg = $validator->errors()->messages()[$errorKey][0];
            $return["msg"] = $msg;
            return $return;
        } else {
            $data = $request->input();
            unset($data["_token"]);
            $return['status'] = 1;
            $return['data'] = $data;
            return $return;
        }
    }

    public static function rgb_to_hex($rgba)
    {
        $default = 'rgb(0,0,0)';
        //Return default if no color provided
        if (empty($rgba)) return $default;

        if (strpos($rgba, '#') === 0) {
            return $rgba;
        }

        preg_match('/^rgb?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i', $rgba, $by_color);

        return sprintf('#%02x%02x%02x', $by_color[1], $by_color[2], $by_color[3]);
    }

    public static function hex2rgba($color, $opacity = false)
    {

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if (empty($color))
            return $default;

        //Sanitize $color if "#" is provided 
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if ($opacity) {
            if (abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }

        //Return rgb(a) color string
        return $output;
    }

    public static function getUserForDropdown($where)
    {
        $data = DB::table('budgets')->where($where)->get();
        return $data;
    }

    public static function getApproverHead($employeeID)
    {
        $office = DB::table('employees')->where('employee_id', '=', $employeeID)->value("office");
        $officeHead =  DB::table('offices')->where("code", '=', $office)->value("head_id");
        return $officeHead;
    }


    public static function AttendanceDescriptionCheckerIfLate($employeeid, $date)
    {
        $idx = date("N", strtotime($date));
        $Day = date("Y-m-d", strtotime($date));

        $datetime = new DateTime($date);

        $startTime = DB::table('schedules_detail_employee')->where('employee_id', $employeeid)->where('idx', $idx)->value('starttime');

        if($startTime){
            $startTime = new DateTime($Day . " " . $startTime);
            
            if ($startTime > $datetime || $startTime->format('i') == $datetime->format('i')) {
                // The datetime is in the future
                $result = "On time";
            } elseif ($startTime < $datetime) {
                // The datetime is in the past
                $result = "Late";
            } 
        }else{
            $result = "No Schedule";
        }
        return $result;
    }

    public static function fix_base64($base64)
    {
        $base64 = str_replace(' ', '+', $base64);
        $base64 = str_replace('data:image/jpeg;base64,', '', $base64);
        $base64 = str_replace('\/', '/', $base64);
        return $base64;
    }

    public static function getEmployeeName($employee_id)
    {
        return DB::table('employees')->select(DB::raw("CONCAT(fname,' ', lname) AS name"))->where('employee_id', $employee_id)->value('name');
    }

    public static function getWorkParameterForDropdown()
    {
        $where = array();

        $data = DB::table('work_paras')->where($where)->get();
        return $data;
    }
    
    public static function CheckIfApprover($employee_id)
    {
        $checker =  DB::table('offices')->where('head_id', $employee_id)->get();
        if(count($checker) > 0){
            return true;
        }else{
            return false;
        }
    }
}
