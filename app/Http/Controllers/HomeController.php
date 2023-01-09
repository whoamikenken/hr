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
        $menus = DB::table('menus')->where('root', '=', '0')->get();
        foreach ($menus as $key => $value) {
            if ($value->link) $data['menus'][$value->title] = $value;
            else $data['menus'][$value->title] = json_decode(DB::table('menus')->where("root", "=", $value->menu_id)->orderBy("title", "asc")->get());
        }

        $data['navSelected'] = ($request->nav) ? $request->nav : 0;
        $data['menuSelected'] = ($request->menu_id) ? $request->menu_id : 1;
        $viewRequest = ($request->route) ? $request->route : "home";

        // dd(Auth::user());

        $data['readAccess'] = explode(",", Extras::getAccessList("read", Auth::user()->username));
        $data['addAccess'] = explode(",", Extras::getAccessList("add", Auth::user()->username));
        $data['editAccess'] = explode(",", Extras::getAccessList("edit", Auth::user()->username));
        $data['deleteAccess'] = explode(",", Extras::getAccessList("delete", Auth::user()->username));

        return view($viewRequest, $data);
    }

    public function dashboard(){
    
        if(Auth::user()->user_type == "Admin"){
        $data['applicant_month'] = Extras::countApplicantRegistered();
        $data['applicant_count'] = Extras::countApplicantRegisteredAll();
        $data['student_month'] = Extras::countStudentRegistered();
        $data['student_count'] = Extras::countStudentRegisteredAll();
        $data['top_adviser'] = DB::table('users')->select("*", DB::raw('(SELECT COUNT(*) FROM students WHERE adviser = users.id) as total_handle'), DB::raw('(SELECT description FROM campuses WHERE code = users.campus) as campusDesc'))->where("user_type", "=", 'Professor')->orderBy("total_handle", "desc")->paginate(8);
        $data['announcement'] = DB::table('announcements')->select(array('id','title','description'))->paginate(8);
        return view('dashboard/admin', $data);
        }else{

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
                $options["items"][] = array('id' => $value->id, 'name' => $value->username . " - " . $value->name);
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
                $options["items"][] = array('id' => $value->code, 'name' => $value->description);
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
                $where[] = array("id", "=", $data['id']);
                $record = DB::table('users')->where($where)->get();
                $return = array('desc' => $record[0]->username." - ".$record[0]->name, 'id' => $record[0]->id);
            } elseif ($data['desc'] == "office") {
                $where[] = array("code", "=", $data['id']);
                $record = DB::table('offices')->where($where)->get();
                $return = array('desc' => $record[0]->description, 'id' => $record[0]->id);
            } elseif ($data['desc'] == "department") {
                $where[] = array("code", "=", $data['id']);
                $record = DB::table('departments')->where($where)->get();
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
        $dataStudent = $dataApplicant = "[";
        $month = "[";
        foreach ($period as $dt) {

            // Applicant
            $applicantdept = Extras::countApplicantRegistered($dt->format("m"));
            if ($applicantdept != 0) {
                $dataApplicant = $dataApplicant . $applicantdept . ",";
                if ($applicantdept > $highest) $highest = $applicantdept;
            } else {
                $dataApplicant = $dataApplicant . "0,";
            }

            // Student
            $studentdept = Extras::countStudentRegistered($dt->format("m"));
            if ($studentdept != 0) {
                $dataStudent = $dataStudent . $studentdept . ",";
                if ($studentdept > $highest) $highest = $studentdept;
            } else {
                $dataStudent = $dataStudent . "0,";
            }

            $month = $month . '"' . $dt->format("F") . '",';
        }

        // Student
        $dataStudent = substr($dataStudent, 0, -1);
        $dataStudent = $dataStudent . "]";

        // Applicant
        $dataApplicant = substr($dataApplicant, 0, -1);
        $dataApplicant = $dataApplicant . "]";


        $month = substr($month, 0, -1);
        $month = $month . "]";
        $return['student']['data'] = $dataStudent;
        $return['applicant']['data'] = $dataApplicant;

        $return['month'] = $month;
        $percentageAdded = (30 / 100) * $highest;
        $return['high'] = $highest + $percentageAdded;
        
        echo json_encode($return);
    }

    public function campusMontlyBarChart()
    {
        $start    = (new DateTime(date("Y-") . "01-01"))->modify('first day of this month');
        $end      = (new DateTime(date("Y-") . "12-31"))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        $getBranchList = Extras::getCampusesList();

        $return = $data = array();
        $highest = 0;
        $month = "[";

        foreach ($period as $dt) {
            $month = $month . '"' . $dt->format("F") . '",';
            foreach ($getBranchList as $key => $value) {
                $count = Extras::getCampusStudentMonth($dt->format("m"), $value->code);
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

    public function campusPieStudent()
    {
        $campusResult = DB::table('campuses')->get();

        $highest = 0;
        $data = array();
        foreach ($campusResult as $key => $value) {
            $count = Extras::getStudentInCampus($value->code);
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
