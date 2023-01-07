<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Extras extends Model
{
    use HasFactory;
    
    public static function returnApplicantCols($desc = "")
    {
        
        if ($desc == "General Information") {
            $arrcol = array("applicant_id","er_ref", "maid_ref", "fullname", "fname", "lname", "mname", "contact", "address", "family_contact_name","family_contact","gender", "jobsite","branch", "sales_manager","date_applied","is_first", "abroad_experience","is_walkin", "total_cost", "user_profile", "user_profile_face");
        }elseif($desc == "Passport"){
            $arrcol = array("passport_no", "passport_issued", "passport_validity", "passport_place_issued");
        }elseif($desc == "Vaccination") {
            $arrcol = array("vac_first_dose_date", "vac_first_brand", "vac_first_country", "vac_second_dose_date", "vac_second_brand","vac_second_country", "vac_booster_dose_date", "vac_booster_brand", "vac_booster_country");
        }elseif($desc == "Bio Status") {
            $arrcol = array("bio_trans_date", "bio_lunch_date", "bio_status", "bio_availability");
        } elseif ($desc == "Job Order") {
            $arrcol = array("jo_received", "jo_confirmed", "jo_er_iscancel", "jo_maid_iscancel");
        } elseif ($desc == "Medical Record") {
            $arrcol = array("med_first_date", "med_first_result", "med_first_clinic", "med_first_cost", "med_second_date", "med_second_result", "med_second_clinic","med_second_cost", "med_third_date", "med_third_result", "med_third_clinic","med_third_cost", "med_fourth_date", "med_fourth_result", "med_fourth_clinic", "med_fourth_cost");
        } elseif ($desc == "Certificate") {
            $arrcol = array("cert_pdos_date", "cert_pdos_release_date", "cert_owwa_date","cert_owwa_release_date", "cert_nc2_by_applicant", "cert_nc2_payment_status","cert_nc2_cost","cert_prc", "cert_driver_license");
        } elseif ($desc == "VISA") {
            $arrcol = array("visa_number", "visa_date_received", "visa_date_expired", "visa_reactive_date", "visa_status", "visa_er_iscancel", "visa_maid_iscancel");
        } elseif ($desc == "OEC") {
            $arrcol = array("oec_number", "oec_contract_received", "oec_pagibig", "oec_date_filed","oec_date_expiration", "oec_flight_departure");
        }
        
        $return = '<div class="col-md-6 col-sm-12 col-lg-4"><h6 class="text-center">'.$desc.'</h6>';
        
        foreach ($arrcol as $row) {
            $col = Extras::showDesc($row);
            $return .= '<div class="form-check"><input class="form-check-input" type="checkbox" name="edata" value="'.$row.'"><label class="form-check-label">'.$col.'</label></div>';
        }
        $return .= "</div>";
        return $return;
    }
    
    public static function showDesc($data)
    {
        $return = array (
            "applicant_id" => "Applicant ID",
            "er_ref" => "E.R No",
            "maid_ref" => "MAID No",
            "fullname" => "Name",
            "lname" => "Last Name",
            "fname" => "First Name",
            "mname" => "Middle Name",
            "contact" => "Contact",
            "address" => "Address",
            "family_contact_name" => "Family Contact Name",
            "family_contact" => "Family Contact",
            "gender" => "Gender",
            "jobsite" => "Job Site",
            "branch" => "Branch",
            "sales_manager" => "Sales",
            "date_applied" => "Date Applied",
            "is_first" => "Is First Time?",
            "is_walkin" => "Is Walk In?",
            "total_cost" => "Total Cost",
            "abroad_experience" => "Experience",
            "passport_no" => "Passport No",
            "passport_issued" => "Date Issued",
            "passport_validity" => "Passport Validity",
            "passport_place_issued" => "Country Issued",
            "vac_first_dose_date" => "First Dose Date",
            "vac_first_brand" => "First Dose Brand",
            "vac_first_country" => "First Dose Country",
            "vac_second_dose_date" => "Second Dose Date",
            "vac_second_brand" => "Second Dose Brand",
            "vac_second_country" => "Second Dose Country",
            "vac_booster_dose_date" => "Booster Dose Date",
            "vac_booster_brand" => "Booster Dose Brand",
            "vac_booster_country" => "Booster Dose Country",
            "bio_status" => "Bio Status",
            "bio_trans_date" => "Bio Tranferred Date",
            "bio_lunch_date" => "Bio Lunch Date",
            "bio_availability" => "Availability",
            "jo_received" => "JO Date",
            "jo_confirmed" => "JO Confirm Date",
            "jo_er_iscancel" => "JO Cancel By ER",
            "jo_maid_iscancel" => "JO Cancel By MAID",
            "med_first_date" => "First Medical Date",
            "med_first_result" => "First Medical Result",
            "med_first_clinic" => "First Medical Clinic",
            "med_first_cost" => "First Medical Cost",
            "med_second_date" => "Second Medical Date",
            "med_second_result" => "Second Medical Result",
            "med_second_clinic" => "Second Medical Clinic",
            "med_second_cost" => "Second Medical Cost",
            "med_third_date" => "Third Medical Date",
            "med_third_result" => "Third Medical Result",
            "med_third_clinic" => "Third Medical Clinic",
            "med_third_cost" => "Third Medical Cost",
            "med_fourth_date" => "Fourth Medical Date",
            "med_fourth_result" => "Fourth Medical Result",
            "med_fourth_clinic" => "Fourth Medical Clinic",
            "med_fourth_cost" => "Fourth Medical Cost",
            "cert_pdos_date" => "PDOS Applied",
            "cert_pdos_release_date" => "PDOS Release",
            "cert_owwa_date" => "OWWA Applied",
            "cert_owwa_release_date" => "OWWA Release",
            "cert_nc2_by_applicant" => "NCII By Applicant",
            "cert_nc2_payment_status" => "NCII Payment Status",
            "cert_nc2_cost" => "NCII Cost",
            "cert_driver_license" => "Driver Lic.",
            "cert_prc" => "PRC",
            "visa_number" => "VISA No",
            "visa_date_received" => "VISA Eeceive",
            "visa_date_expired" => "VISA Expiration",
            "visa_reactive_date" => "VISA Reactive",
            "visa_status" => "VISA Status",
            "visa_er_iscancel" => "VISA ER Cancel",
            "visa_maid_iscancel" => "VISA MAID Cancel",
            "oec_number" => "OEC No",
            "oec_contract_received" => "OEC Receive",
            "oec_pagibig" => "OEC Pag-ibig",
            "oec_date_filed" => "OEC Filed",
            "oec_date_expiration" => "OEC Expiration",
            "oec_flight_departure" => "OEC Departure",
            "user_profile_face" => "Face Photo",
            "user_profile" => "Body Photo",
        );
        
        return $return[$data];
    }

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

    public static function filledDiploma(String $applicant_id = null)
    {
        $diplomaResult =  DB::table('diplomas')->where('applicant_id', $applicant_id)->get();
        if(count($diplomaResult) > 0){
            return "Filed";
        }else{
            return "Not Filed";
        }
    }

    public static function countLackingApplicant()
    {
        $result = DB::select("SELECT a.applicant_id FROM applicants a LEFT JOIN diplomas b ON a.applicant_id = b.applicant_id WHERE a.`passport` IS NULL OR a.`med_first_cert` IS NULL OR a.`med_second_cert` IS NULL OR a.`med_third_cert` IS NULL OR a.`med_fourth_cert` IS NULL OR a.`sup_doc_id988a` IS NULL OR a.`sup_pt6` IS NULL OR a.`sup_coe` IS NULL OR a.`sup_hq` IS NULL OR a.`sup_polohk` IS NULL OR a.`sup_infosheet` IS NULL OR a.`sup_privacy_policy` IS NULL OR a.`sup_affidavit` IS NULL OR a.`sup_mmr_vac` IS NULL OR a.`cert_ereg` IS NULL OR a.`cert_peos` IS NULL OR a.`cert_pdos` IS NULL OR a.`cert_owwa` IS NULL OR a.`cert_nc2` IS NULL OR a.`cert_ofw_infosheet` IS NULL OR a.`visa` IS NULL OR a.`oec_covid_dec` IS NULL OR a.`oec_insurance` IS NULL OR a.`oec_pregnancy_test` IS NULL OR a.`oec_swab_test` IS NULL OR a.`user_profile` IS NULL OR a.`user_profile_face` IS NULL OR a.`user_video` IS NULL OR b.`diploma`");

        return count($result);
    }

    public static function countApplicantRegistered($month = "")
    {
        
        if(!$month) $month = date("m");
        $result = DB::select("SELECT applicant_id FROM applicants WHERE MONTH(`date_applied`) = $month");

        return count($result);
    }

    public static function countStudentRegistered($month = "")
    {
        if (!$month) $month = date("m");
        $result = DB::select("SELECT student_id FROM students WHERE MONTH(`date_applied`) = $month");
        return count($result);
    }

    public static function countStudentRegisteredAll()
    {
        $result = DB::select("SELECT student_id FROM students");

        return count($result);
    }

    public static function countApplicantRegisteredAll()
    {
        $result = DB::select("SELECT applicant_id FROM applicants");

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

    public static function getStudentInCampus($campus = null)
    {
        $result = DB::select("SELECT * FROM applicants WHERE campus = '$campus' AND isactive = 'Active'");

        return count($result);
    }

    public static function getBranchDeployedMonth($month = null, $branch = null)
    {
        $result = DB::select("SELECT * FROM applicants WHERE branch = '$branch' AND MONTH(oec_flight_departure) = $month AND YEAR(oec_flight_departure) = YEAR(CURDATE()) AND isactive = 'Active'");

        return count($result);
    }

    public static function getCampusStudentMonth($month = null, $campus = null)
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

    public static function getCampusesList($campus = null)
    {
        $wh = "WHERE 1";
        if ($campus) $wh .= " AND code = '$campus'";
        $result = DB::select("SELECT * FROM campuses $wh");

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
        return array(999, 13, 5, 801, 802, 803, 804);
    }

    public static function getNoDel()
    {
        return array(999, 13, 5, 801, 802, 803, 804);
    }

    public static function getNoEdit()
    {
        return array(5,999);
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

    public static function getSubjectForDropdown($where = array())
    {
        $data = DB::table('subjects')->where($where)->get();
        return $data;
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
}
