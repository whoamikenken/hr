<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\Extras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data['readAccess'] = explode(",", Extras::getAccessList("read", Auth::user()->username));
        $data['addAccess'] = explode(",", Extras::getAccessList("add", Auth::user()->username));
        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));
        $data['deleteAccess'] = explode(",", Extras::getAccessList("delete", Auth::user()->username));

        $menus = DB::table('menus')->where('root', '=', '0')->orderBy('order', 'ASC')->get();
        foreach ($menus as $key => $value) {
            if ($value->link) {
                $data['menus'][$value->title] = $value;
            } else {
                $subMenus = json_decode(DB::table('menus')->where("root", "=", $value->menu_id)->orderBy("title", "asc")->get());

                foreach ($subMenus as $ky => $men) {

                    if (!in_array($men->menu_id, $data['readAccess'])) {
                        unset($subMenus[$ky]);
                    }
                }

                if (count($subMenus) > 0) {
                    $data['menus'][$value->title] =  $subMenus;
                }
            }
        }

        $data['navSelected'] = ($request->nav) ? $request->nav : 0;
        $data['menuSelected'] = ($request->menu_id) ? $request->menu_id : 1;
        $viewRequest = ($request->route) ? $request->route : "home";
        $data['isApprover'] = Extras::CheckIfApprover(Auth::user()->username);
        $data['requestCount'] = DB::table('work_from_homes')->where("office_head", Auth::user()->username)->where("status", "PENDING")->where("read_office_head", 0)->count();

        $data['myRequestCount'] = DB::table('work_from_homes')->where("employee_id", Auth::user()->username)->where("read_employee", 0)->count();
        return view($viewRequest, $data);
    }

    public function dashboard(){
    
        if(Auth::user()->user_type == "Admin"){
        $data['employee_month'] = Extras::countEmployeeRegistered();
        $data['employee_count'] = Extras::countEmployeeRegisteredAll();
        $data['employee_present'] = Extras::countPresentEmployee();
        $data['employee_absent'] = Extras::countAbsentEmployee();
        $data['student_count'] = Extras::countAbsentEmployee();
        $data['top_employee'] = DB::table('users')->select("*", DB::raw('(SELECT COUNT(*) FROM work_from_homes WHERE employee_id = users.username AND status = "APPROVE") as total_att'))->where("user_type", "=", 'Employee')->orderBy("total_att", "desc")->paginate(9);
        foreach ($data['top_employee'] as $key => $value) {
            $office = DB::table('employees')->where('employee_id', $value->username)->value('office');
            $department = DB::table('employees')->where('employee_id', $value->username)->value('department');
            $data['top_employee'][$key]->office = DB::table('offices')->where('code', $office)->value('description');
            $data['top_employee'][$key]->department = DB::table('departments')->where('code', $department)->value('description');
        }
        $data['announcement'] = DB::table('announcements')->select(array('id','title','description'))->paginate(9);
        return view('dashboard/admin', $data);
        }else{
            
            $data['top_employee'] = DB::table('users')->select("*", DB::raw('(SELECT COUNT(*) FROM timesheets WHERE employee_id = users.username) as total_att'))->where("user_type", "=", 'Employee')->orderBy("total_att", "desc")->paginate(9);
            foreach ($data['top_employee'] as $key => $value) {
                $office = DB::table('employees')->where('employee_id', $value->username)->value('office');
                $department = DB::table('employees')->where('employee_id', $value->username)->value('department');
                $data['top_employee'][$key]->office = DB::table('offices')->where('code', $office)->value('description');
                $data['top_employee'][$key]->department = DB::table('departments')->where('code', $department)->value('description');
            }
            $data['announcement'] = DB::table('announcements')->select(array('id', 'title', 'description'))->paginate(9);
            return view('dashboard/admin', $data);
        }
    }

    public function getDropdownData(Request $request){
        $data = $request->input();
        $where = array();
        $mode = $data['mode'];
        $limit = 100;
        if (isset($mode) && $mode == "single") {
            $options["items"][] = array('id' => "", 'name' => "Select Option");
        } else {
            $options["items"][] = array('id' => "all", 'name' => "All");
        }
        $options = array("incomplete_results" => false, "items" => array(), "total_count" => 0);
        if ($data['dataSearch'] == "user") {
            if (!isset($data['search'])) $data['search'] = "";
            $where[] = array("user_type", "=", "Employee");
            $where[] = array("name", "LIKE", "%" . $data['search'] . "%");
            $record = DB::table('users')->where($where)->limit($limit)->get();
            foreach ($record as $key => $value) {
                $options["items"][] = array('id' => $value->username, 'name' => $value->username . " - " . $value->name);
                unset($options["incomplete_results"]);
                unset($options["total_count"]);
            }
        } elseif ($data['dataSearch'] == "office") {
            if (!isset($data['search'])) $data['search'] = "";
            $where[] = array("description", "LIKE", "%" . $data['search'] . "%");
            $record = DB::table('offices')->where($where)->limit($limit)->get();
            foreach ($record as $key => $value) {
                $options["items"][] = array('id' => $value->code, 'name' => $value->description);
                unset($options["incomplete_results"]);
                unset($options["total_count"]);
            }
        } elseif ($data['dataSearch'] == "department") {
            if (!isset($data['search'])) $data['search'] = "";
            $where[] = array("description", "LIKE", "%" . $data['search'] . "%");
            $record = DB::table('departments')->where($where)->limit($limit)->get();
            foreach ($record as $key => $value) {
                $options["items"][] = array('id' => $value->code, 'name' => $value->description);
                unset($options["incomplete_results"]);
                unset($options["total_count"]);
            }
        } elseif ($data['dataSearch'] == "schedule") {
            if (!isset($data['search'])) $data['search'] = "";
            $where[] = array("description", "LIKE", "%" . $data['search'] . "%");
            $record = DB::table('schedules')->where($where)->limit($limit)->get();
            foreach ($record as $key => $value) {
                $options["items"][] = array('id' => $value->id, 'name' => $value->description);
                unset($options["incomplete_results"]);
                unset($options["total_count"]);
            }
        }
        
        
        echo json_encode($options);
    }

    public function getDropdownDataInit(Request $request)
    {
        $data = $request->input();
        $where = array();
        $return = array();
        if($data['id'] && isset($data['id'])){
            if ($data['desc'] == "user") {
                $where[] = array("username", "=", $data['id']);
                $record = DB::table('users')->where($where)->get();
                $return = array('desc' => $record[0]->username." - ".$record[0]->name, 'id' => $record[0]->username);
            } elseif ($data['desc'] == "office") {
                $where[] = array("code", "=", $data['id']);
                $record = DB::table('offices')->where($where)->get();
                $return = array('desc' => $record[0]->description, 'id' => $record[0]->id);
            } elseif ($data['desc'] == "department") {
                $where[] = array("code", "=", $data['id']);
                $record = DB::table('departments')->where($where)->get();
                $return = array('desc' => $record[0]->description, 'id' => $record[0]->id);
            } elseif ($data['desc'] == "schedule") {
                $where[] = array("id", "=", $data['id']);
                $record = DB::table('schedules')->where($where)->get();
                $return = array('desc' => $record[0]->description, 'id' => $record[0]->id);
            }
            
        }
        

        echo json_encode($return);
    }

    public function departureMontlyBarChart()
    {
        $start    = (new DateTime(date("Y-")."01-01"))->modify('first day of this month');
        $end      = (new DateTime(date("Y-") . "12-31"))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        // $highestAmounContribute = $this->setup->getHighestContribution();
        $highest = 0;
        $data = "[";
        $month = "[";
        foreach ($period as $dt) {
            
            $val = Extras::getDepartureMonth($dt->format("m"));
            if ($val != 0) {
                $data = $data . $val . ",";
                if ($val > $highest) $highest = $val;
            } else {
                $data = $data . "0,";
            }

            $month = $month . '"' . $dt->format("F") . '",';
        }
     
        $data = substr($data, 0, -1);
        $data = $data . "]";
        $month = substr($month, 0, -1);
        $month = $month . "]";
        $return['data'] = $data;
        $return['month'] = $month;
        $percentageAdded = (30 / 100) * $highest;
        $return['high'] = $highest + $percentageAdded;
        // echo '<pre>'; print_r(;die;
        echo json_encode($return);
    }

    public function performanceMontlyBarChart()
    {
        $start    = (new DateTime(date("Y-") . "01-01"))->modify('first day of this month');
        $end      = (new DateTime(date("Y-") . "12-31"))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        $highest = 0;
        $dataEmployee = "[";
        $month = "[";
        foreach ($period as $dt) {

            // Employee
            $Employeedept = Extras::countEmployeeRegistered($dt->format("m"));
            if ($Employeedept != 0) {
                $dataEmployee = $dataEmployee . $Employeedept . ",";
                if ($Employeedept > $highest) $highest = $Employeedept;
            } else {
                $dataEmployee = $dataEmployee . "0,";
            }
            $month = $month . '"' . $dt->format("F") . '",';
        }

        // Employee
        $dataEmployee = substr($dataEmployee, 0, -1);
        $dataEmployee = $dataEmployee . "]";

        $month = substr($month, 0, -1);
        $month = $month . "]";
        $return['employee']['data'] = $dataEmployee;

        $return['month'] = $month;
        $percentageAdded = (30 / 100) * $highest;
        $return['high'] = $highest + $percentageAdded;
        
        echo json_encode($return);
    }

    public function officeMontlyBarChart()
    {
        $start    = (new DateTime(date("Y-") . "01-01"))->modify('first day of this month');
        $end      = (new DateTime(date("Y-") . "12-31"))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        $getBranchList = Extras::getOfficeList();

        $return = $data = array();
        $highest = 0;
        $month = "[";

        foreach ($period as $dt) {
            $month = $month . '"' . $dt->format("F") . '",';
            foreach ($getBranchList as $key => $value) {
                $count = Extras::getOfficeEmployeeAttendanceMonth($dt->format("m"), $value->code);
                $data['dataset'][$value->code]['label'] = $value->description;
                $data['dataset'][$value->code]['backgroundColor'] = $value->color;
                $data['dataset'][$value->code]['borderRadius'] = 5;
                $data['dataset'][$value->code]['borderWidth'] = 2;
                $data['dataset'][$value->code]['borderColor'] = $value->color;
                $data['dataset'][$value->code]['data'][] = $count;
                if ($count > $highest) $highest = $count;
            }
        }

        foreach ($data['dataset'] as $key => $value) {
            $return['dataset'][] = $value;
        }
        // dd($return);
        // dd($return['']);
        $month = substr($month, 0, -1);
        $month = $month . "]";

        $return['month'] = $month;
        $percentageAdded = (30 / 100) * $highest;
        $return['high'] = $highest + $percentageAdded;
        // echo '<pre>'; print_r(;die;
        echo json_encode($return);
    }

    public function branchMontlyBarChart()
    {
        $start    = (new DateTime(date("Y-") . "01-01"))->modify('first day of this month');
        $end      = (new DateTime(date("Y-") . "12-31"))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        
        $getBranchList = Extras::getBranchList();

        $return = $data = array();
        $highest = 0;
        $month = "[";
        
        foreach ($period as $dt) {
            $month = $month . '"' . $dt->format("F") . '",';
            foreach ($getBranchList as $key => $value) {
                $count = Extras::getBranchDeployedMonth($dt->format("m"), $value->code);
                $data['dataset'][$value->code]['label'] = $value->description;
                $data['dataset'][$value->code]['backgroundColor'] = $value->color;
                $data['dataset'][$value->code]['borderRadius'] = 5;
                $data['dataset'][$value->code]['borderWidth'] = 2;
                $data['dataset'][$value->code]['borderColor'] = $value->color;
                $data['dataset'][$value->code]['data'][] = $count;
                if ($count > $highest) $highest = $count;
            }
        }

        foreach ($data['dataset'] as $key => $value) {
            $return['dataset'][] = $value;
        }
        // dd($return);
        // dd($return['']);
        $month = substr($month, 0, -1);
        $month = $month . "]";

        $return['month'] = $month;
        $percentageAdded = (30 / 100) * $highest;
        $return['high'] = $highest + $percentageAdded;
        // echo '<pre>'; print_r(;die;
        echo json_encode($return);
    }

    public function branchPieApplicant()
    {
        $branchesResult = DB::table('branches')->get();

        $data = "[";
        $label = "[";
        foreach ($branchesResult as $key => $value) {

            $val = Extras::getApplicantInBranch($value->code);
            if ($val != 0) {
                $data = $data . $val . ",";
            } else {
                $data = $data . "0,";
            }

            $label = $label . '"' . $value->description . '",';
        }

        $data = substr($data, 0, -1);
        $data = $data . "]";
        $label = substr($label, 0, -1);
        $label = $label . "]";
        $return['data'] = $data;
        $return['label'] = $label;
        echo json_encode($return);
    }

    public function officePieEmployee()
    {
        $campusResult = DB::table('offices')->get();

        $highest = 0;
        $data = array();
        foreach ($campusResult as $key => $value) {
            $count = Extras::getEmployeeInOffce($value->code);
            $data['dataset']['label'][] = $value->description;
            $data['dataset']['backgroundColor'][] = $value->color;
            $data['dataset']['data'][] = $count;
            if ($count > $highest) $highest = $count;
        }

        foreach ($data['dataset'] as $key => $value) {
            $return['dataset'][$key] = $value;
        }

        $percentageAdded = (30 / 100) * $highest;
        $return['high'] = $highest + $percentageAdded;
        echo json_encode($return);
    }

    public function getUserPieCount()
    {
        $userStatus = array('students', 'applicants', 'Professor');

        $data = "[";
        $label = "[";
        foreach ($userStatus as $key => $value) {
            // dd($value);
            $val = Extras::countUser($value);
            if ($val != 0) {
                $data = $data . $val . ",";
            } else {
                $data = $data . "0,";
            }

            $label = $label . '"' . $value . ': '. $val.'",';
        }

        $data = substr($data, 0, -1);
        $data = $data . "]";
        $label = substr($label, 0, -1);
        $label = $label . "]";
        $return['data'] = $data;
        $return['label'] = $label;
        echo json_encode($return);
    }

    public function biostatusPieApplicant()
    {
        $bioStatus = Extras::getBioStatusDesc();

        $data = "[";
        $label = "[";
        foreach ($bioStatus as $key => $value) {

            $val = Extras::getApplicantCountWithBioStatus($value->bio_status);
            if ($val != 0) {
                $data = $data . $val . ",";
            } else {
                $data = $data . "0,";
            }

            $label = $label . '"' . $value->bio_status . ': '. $val.'",';
        }

        $data = substr($data, 0, -1);
        $data = $data . "]";
        $label = substr($label, 0, -1);
        $label = $label . "]";
        $return['data'] = $data;
        $return['label'] = $label;
        echo json_encode($return);
    }
}
