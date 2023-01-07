<?php

namespace App\Http\Controllers;

use App\Models\Extras;
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
            $showColumn .= Extras::returnApplicantCols("General Information");
            $showColumn .= Extras::returnApplicantCols("Medical Record");
            $showColumn .= Extras::returnApplicantCols("Vaccination");
            $showColumn .= Extras::returnApplicantCols("OEC");
            $showColumn .= Extras::returnApplicantCols("Passport");
            $showColumn .= Extras::returnApplicantCols("Bio Status");
            $showColumn .= Extras::returnApplicantCols("Certificate");
            $showColumn .= Extras::returnApplicantCols("VISA");
            $showColumn .= Extras::returnApplicantCols("Job Order");
            
            $data['showColumn'] = $showColumn;
        }elseif ($data['tag'] == "infosheet") {
            $showColumn = array("GI" => "General Information", "AI" => "Applicant Information", "BS" => "Bio Status", "PI" => "Passport Information","VR" =>"Vacinnation Record", "MR" =>"Medical Record", "JO" =>"Job Order", "VI" =>"Visa Information", "CR" =>"Certificates", "SD" =>"Supporting Documents", "OEC" => "Overseas Employment Certificate");

            $return = '<div class="col-md-6 col-sm-12">';
            $counter = 0;
            foreach ($showColumn as $key => $value) {
                if($counter == 5) $return .= '</div><div class="col-md-6 col-sm-12">';
                $return .= '<div class="form-check"><input class="form-check-input" type="checkbox" name="edata" value="' . $key . '"><label class="form-check-label">' . $value . '</label></div>';

                $counter++;
            }

            $return .= "</div>";
            $data['showColumn'] = $return;
        }

        $data['applicant_select'] = DB::table('applicants')->where("isactive", "Active")->get();
        $data['branch_select'] = DB::table('branches')->get();
        $data['jobsite_select'] = DB::table('jobsites')->get();
        $data['users_select'] = DB::table('users')->where("user_type", "sales")->get();
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


            $table = "applicants";
            $columnList = $formFields['edatalist'];
            $getColumn = explode(",", $columnList);
            foreach ($getColumn as $key => $value) {
                $data['edatalist'][$value] = Extras::showDesc($value);
            }
            if ($table) {
                $data['result'] = DB::table($table)->where($where)->get();
            }
            foreach ($data['result'] as $key => $value) {
                if (isset($data['result'][$key]->sales_manager)) $data['result'][$key]->sales_manager = DB::table('users')->where('id', $value->sales_manager)->value('name');
                if (isset($data['result'][$key]->jobsite)) $data['result'][$key]->jobsite = DB::table('jobsites')->where('code', $value->jobsite)->value('description');
                if (isset($data['result'][$key]->branch)) $data['result'][$key]->branch = DB::table('branches')->where('code', $value->branch)->value('description');
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("public")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("public")->url($value->user_profile);
            }

            // dd($data);
            return response()->view('report/masterlistPDF', $data, 200)->header('Content-Type', 'application/pdf');
        }elseif($formFields['tag'] == "departure"){
            $between = array();
            foreach ($whereFilter as $key => $value) {
                if($key == "from" || $key == "to"){
                    $between[] = $value;
                }else {
                    if ($value) {
                        $where[] = array($key, '=', $value);
                    }
                }
                
            }

            $data['dateof'] = "From ". $between[0]." to ". $between[1];

            $table = "applicants";
            DB::enableQueryLog();
            if ($table) {
                $data['result'] = DB::table($table)->where($where)->whereBetween("oec_flight_departure", $between)->orderBy('oec_flight_departure', 'desc')->get();
            }
            $data['edatalist']['fullname'] = Extras::showDesc('fullname');
            $data['edatalist']['applicant_id'] = Extras::showDesc('applicant_id');
            $data['edatalist']['oec_flight_departure'] = Extras::showDesc('oec_flight_departure');

            foreach ($data['result'] as $key => $value) {
                if (isset($data['result'][$key]->sales_manager)) $data['result'][$key]->sales_manager = DB::table('users')->where('id', $value->sales_manager)->value('name');
                if (isset($data['result'][$key]->jobsite)) $data['result'][$key]->jobsite = DB::table('jobsites')->where('code', $value->jobsite)->value('description');
                if (isset($data['result'][$key]->branch)) $data['result'][$key]->branch = DB::table('branches')->where('code', $value->branch)->value('description');
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("public")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("public")->url($value->user_profile);
            }
            // dd(DB::getQueryLog());
            return response()->view('report/departurelistPDF', $data, 200)->header('Content-Type', 'application/pdf');
        } elseif ($formFields['tag'] == "deployment") {
            $between = array();
            foreach ($whereFilter as $key => $value) {
                if ($key == "from" || $key == "to") {
                    $between[] = $value;
                } else {
                    if ($value) {
                        $where[] = array($key, '=', $value);
                    }
                }
            }

            $data['dateof'] = "From " . $between[0] . " to " . $between[1];

            $table = "applicants";
            DB::enableQueryLog();
            if ($table) {
                $data['result'] = DB::table($table)->where($where)->whereBetween("oec_flight_departure", $between)->orderBy('branch', 'desc')->orderBy('lname', 'desc')->get();
            }
            $data['edatalist']['fullname'] = Extras::showDesc('fullname');
            $data['edatalist']['applicant_id'] = Extras::showDesc('applicant_id');
            $data['edatalist']['maid_ref'] = Extras::showDesc('maid_ref');
            $data['edatalist']['branch'] = Extras::showDesc('branch');
            $data['edatalist']['jobsite'] = Extras::showDesc('jobsite');
            $data['edatalist']['oec_flight_departure'] = Extras::showDesc('oec_flight_departure');

            foreach ($data['result'] as $key => $value) {
                if (isset($data['result'][$key]->sales_manager)) $data['result'][$key]->sales_manager = DB::table('users')->where('id', $value->sales_manager)->value('name');
                if (isset($data['result'][$key]->jobsite)) $data['result'][$key]->jobsite = DB::table('jobsites')->where('code', $value->jobsite)->value('description');
                if (isset($data['result'][$key]->branch)) $data['result'][$key]->branch = DB::table('branches')->where('code', $value->branch)->value('description');
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("public")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("public")->url($value->user_profile);
            }
            // dd(DB::getQueryLog());
            return response()->view('report/departurelistPDF', $data, 200)->header('Content-Type', 'application/pdf');
        } elseif ($formFields['tag'] == "biodata") {
            foreach ($whereFilter as $key => $value) {
                if ($value) {
                    $where[] = array($key, '=', $value);
                }
            }

            $data['dateof'] = "As of " . date("F j, Y");


            $table = "applicants";

            $data['edatalist']['applicant_id'] = Extras::showDesc('applicant_id');
            $data['edatalist']['fullname'] = Extras::showDesc('fullname');
            $data['edatalist']['maid_ref'] = Extras::showDesc('maid_ref');
            $data['edatalist']['branch'] = Extras::showDesc('branch');
            $data['edatalist']['jobsite'] = Extras::showDesc('jobsite');

            $data['edatalist']['bio_trans_date'] = Extras::showDesc('bio_trans_date');
            $data['edatalist']['bio_lunch_date'] = Extras::showDesc('bio_lunch_date');
            $data['edatalist']['bio_status'] = Extras::showDesc('bio_status');
            $data['edatalist']['bio_availability'] = Extras::showDesc('bio_availability');

            if ($table) {
                $data['result'] = DB::table($table)->where($where)->orderBy('jobsite', 'desc')->orderBy('branch', 'desc')->orderBy('bio_status', 'desc')->orderBy('lname', 'asc')->get();
            }

            foreach ($data['result'] as $key => $value) {
                if (isset($data['result'][$key]->sales_manager)) $data['result'][$key]->sales_manager = DB::table('users')->where('id', $value->sales_manager)->value('name');
                if (isset($data['result'][$key]->jobsite)) $data['result'][$key]->jobsite = DB::table('jobsites')->where('code', $value->jobsite)->value('description');
                if (isset($data['result'][$key]->passport_place_issued)) $data['result'][$key]->passport_place_issued = DB::table('countries')->where('code', $value->passport_place_issued)->value('description');
                if (isset($data['result'][$key]->branch)) $data['result'][$key]->branch = DB::table('branches')->where('code', $value->branch)->value('description');
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("public")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("public")->url($value->user_profile);
            }

            return response()->view('report/masterlistPDF', $data, 200)->header('Content-Type', 'application/pdf');
        }elseif ($formFields['tag'] == "joborder") {
            foreach ($whereFilter as $key => $value) {
                if ($value) {
                    $where[] = array($key, '=', $value);
                }
            }

            $data['dateof'] = "As of " . date("F j, Y");


            $table = "applicants";

            $data['edatalist']['applicant_id'] = Extras::showDesc('applicant_id');
            $data['edatalist']['fullname'] = Extras::showDesc('fullname');
            $data['edatalist']['maid_ref'] = Extras::showDesc('maid_ref');
            $data['edatalist']['branch'] = Extras::showDesc('branch');
            $data['edatalist']['jobsite'] = Extras::showDesc('jobsite');

            $data['edatalist']['jo_received'] = Extras::showDesc('jo_received');
            $data['edatalist']['jo_confirmed'] = Extras::showDesc('jo_confirmed');
            $data['edatalist']['jo_er_iscancel'] = Extras::showDesc('jo_er_iscancel');
            $data['edatalist']['jo_maid_iscancel'] = Extras::showDesc('jo_maid_iscancel');

            if ($table) {
                $data['result'] = DB::table($table)->where($where)->orderBy('jobsite', 'desc')->orderBy('branch', 'desc')->get();
            }

            foreach ($data['result'] as $key => $value) {
                if (isset($data['result'][$key]->sales_manager)) $data['result'][$key]->sales_manager = DB::table('users')->where('id', $value->sales_manager)->value('name');
                if (isset($data['result'][$key]->jobsite)) $data['result'][$key]->jobsite = DB::table('jobsites')->where('code', $value->jobsite)->value('description');
                if (isset($data['result'][$key]->passport_place_issued)) $data['result'][$key]->passport_place_issued = DB::table('countries')->where('code', $value->passport_place_issued)->value('description');
                if (isset($data['result'][$key]->branch)) $data['result'][$key]->branch = DB::table('branches')->where('code', $value->branch)->value('description');
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("public")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("public")->url($value->user_profile);
            }

            return response()->view('report/masterlistPDF', $data, 200)->header('Content-Type', 'application/pdf');
        } elseif ($formFields['tag'] == "expiration") {
            foreach ($whereFilter as $key => $value) {
                if ($value) {
                    $where[] = array($key, '=', $value);
                }
            }

            $data['dateof'] = "As of " . date("F j, Y");


            $table = "applicants";

            $data['edatalist']['applicant_id'] = Extras::showDesc('applicant_id');
            $data['edatalist']['fullname'] = Extras::showDesc('fullname');
            if($formFields['edatalist'] == "all"){
                $data['edatalist']['passport_no'] = Extras::showDesc('passport_no');
                $data['edatalist']['passport_validity'] = Extras::showDesc('passport_validity');
                $data['edatalist']['visa_number'] = Extras::showDesc('visa_number');
                $data['edatalist']['visa_date_expired'] = Extras::showDesc('visa_date_expired');
            }elseif($formFields['edatalist'] == "Visa"){
                $data['reportName'] = "Visa Expiration Report";
                $data['edatalist']['visa_number'] = Extras::showDesc('visa_number');
                $data['edatalist']['visa_status'] = Extras::showDesc('visa_status');
                $data['edatalist']['visa_date_received'] = Extras::showDesc('visa_date_received');
                $data['edatalist']['visa_date_expired'] = Extras::showDesc('visa_date_expired');
            } elseif ($formFields['edatalist'] == "Passport") {
                $data['reportName'] = "Passport Expiration Report";
                $data['edatalist']['passport_no'] = Extras::showDesc('passport_no');
                $data['edatalist']['passport_issued'] = Extras::showDesc('passport_issued');
                $data['edatalist']['passport_place_issued'] = Extras::showDesc('passport_place_issued');
                $data['edatalist']['passport_validity'] = Extras::showDesc('passport_validity');
            }
            

            if ($table) {
                $data['result'] = DB::table($table)->where($where)->orWhere('passport_validity', '<', date("Y-m-d"))->orWhere('visa_date_expired', '<', date("Y-m-d"))->orderBy('passport_validity', 'desc')->orderBy('visa_date_expired', 'desc')->get();
            }

            foreach ($data['result'] as $key => $value) {
                if (isset($data['result'][$key]->sales_manager)) $data['result'][$key]->sales_manager = DB::table('users')->where('id', $value->sales_manager)->value('name');
                if (isset($data['result'][$key]->jobsite)) $data['result'][$key]->jobsite = DB::table('jobsites')->where('code', $value->jobsite)->value('description');
                if (isset($data['result'][$key]->passport_place_issued)) $data['result'][$key]->passport_place_issued = DB::table('countries')->where('code', $value->passport_place_issued)->value('description');
                if (isset($data['result'][$key]->branch)) $data['result'][$key]->branch = DB::table('branches')->where('code', $value->branch)->value('description');
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("public")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("public")->url($value->user_profile);
            }

            return response()->view('report/masterlistPDF', $data, 200)->header('Content-Type', 'application/pdf');
        } elseif ($formFields['tag'] == "costbreakdown") {
            $between = array();
            foreach ($whereFilter as $key => $value) {
                if ($key == "from" || $key == "to") {
                    $between[] = $value;
                } else {
                    if ($value) {
                        $where[] = array($key, '=', $value);
                    }
                }
            }

            $data['dateof'] = "As of " . date("F j, Y");

            $table = "applicants";
            // DB::enableQueryLog();
            if ($table) {
                $data['result'] = DB::table($table)->where($where)->orderBy('lname', 'desc')->get();
            }

            $data['edatalist']['fullname'] = Extras::showDesc('fullname');
            $data['edatalist']['applicant_id'] = Extras::showDesc('applicant_id');
            $data['edatalist']['er_ref'] = Extras::showDesc('er_ref');
            $data['edatalist']['maid_ref'] = Extras::showDesc('maid_ref');
            $data['edatalist']['branch'] = Extras::showDesc('branch');
            $data['edatalist']['jobsite'] = Extras::showDesc('jobsite');
            $data['edatalist']['med_first_cost'] = Extras::showDesc('med_first_cost');
            $data['edatalist']['med_second_cost'] = Extras::showDesc('med_second_cost');
            $data['edatalist']['med_third_cost'] = Extras::showDesc('med_third_cost');
            $data['edatalist']['med_fourth_cost'] = Extras::showDesc('med_fourth_cost');
            $data['edatalist']['cert_nc2_cost'] = Extras::showDesc('cert_nc2_cost');
            $data['edatalist']['total_cost'] = Extras::showDesc('total_cost');
            

            foreach ($data['result'] as $key => $value) {
                if (isset($data['result'][$key]->sales_manager)) $data['result'][$key]->sales_manager = DB::table('users')->where('id', $value->sales_manager)->value('name');
                if (isset($data['result'][$key]->jobsite)) $data['result'][$key]->jobsite = DB::table('jobsites')->where('code', $value->jobsite)->value('description');
                if (isset($data['result'][$key]->branch)) $data['result'][$key]->branch = DB::table('branches')->where('code', $value->branch)->value('description');
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("public")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("public")->url($value->user_profile);
            }
            // dd(DB::getQueryLog());
            return response()->view('report/costbreakdownPDF', $data, 200)->header('Content-Type', 'application/pdf');
        } elseif ($formFields['tag'] == "infosheet") {
            $between = array();
            foreach ($whereFilter as $key => $value) {
                if ($key == "from" || $key == "to") {
                    $between[] = $value;
                } else {
                    if ($value) {
                        $where[] = array($key, '=', $value);
                    }
                }
            }

            $data['dateof'] = "As of " . date("F j, Y");

            $table = "applicants";
            if ($table) {
                $data['result'] = DB::table($table)->where($where)->orderBy('lname', 'desc')->get();
            }

            foreach ($data['result'] as $key => $value) {
                $name = $data['result'][$key]->lname." ".$data['result'][$key]->fname;
                if (isset($data['result'][$key]->sales_manager)) $data['result'][$key]->sales_manager = DB::table('users')->where('id', $value->sales_manager)->value('name');
                if (isset($data['result'][$key]->jobsite)) $data['result'][$key]->jobsite = DB::table('jobsites')->where('code', $value->jobsite)->value('description');
                if (isset($data['result'][$key]->branch)) $data['result'][$key]->branch = DB::table('branches')->where('code', $value->branch)->value('description');
                if (isset($data['result'][$key]->passport_place_issued)) $data['result'][$key]->passport_place_issued = DB::table('countries')->where('code', $value->passport_place_issued)->value('description');
                if (isset($data['result'][$key]->passport)) $data['result'][$key]->passport = Storage::disk("public")->url($value->passport);
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("public")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("public")->url($value->user_profile);
            }

            $data['reportName'] = $name;

            $data['edatalist'] = explode(",", $formFields['edatalist']);

            return response()->view('report/infosheetPDF', $data, 200)->header('Content-Type', 'application/pdf');
        } elseif ($formFields['tag'] == "lacking") {
            $between = array();
            foreach ($whereFilter as $key => $value) {
                if ($key == "from" || $key == "to") {
                    $between[] = $value;
                } else {
                    if ($value) {
                        $where[] = array($key, '=', $value);
                    }
                }
            }

            $data['dateof'] = "As of " . date("F j, Y");

            $table = "applicants";
            if ($table) {
                $data['result'] = DB::select("SELECT a.lname, a.fname, a.applicant_id, a.er_ref, a.maid_ref, a.`passport`,a.`med_first_cert`,a.`med_second_cert`,a.`med_third_cert`,a.`med_fourth_cert`,a.`sup_doc_id988a`,a.`sup_pt6`,a.`sup_coe`,a.`sup_hq`,a.`sup_polohk`,a.`sup_infosheet`,a.`sup_privacy_policy`,a.`sup_affidavit`,a.`sup_mmr_vac`,a.`cert_ereg`,a.`cert_peos`,a.`cert_pdos`,a.`cert_owwa`,a.`cert_nc2`,a.`cert_ofw_infosheet`,a.`visa`,a.`oec_covid_dec`,a.`oec_insurance`,a.`oec_pregnancy_test`,a.`oec_swab_test`,a.`user_profile`,a.`user_profile_face`,a.`user_video`,b.`diploma` FROM applicants a LEFT JOIN diplomas b ON a.applicant_id = b.applicant_id WHERE a.`passport` IS NULL OR a.`med_first_cert` IS NULL OR a.`med_second_cert` IS NULL OR a.`med_third_cert` IS NULL OR a.`med_fourth_cert` IS NULL OR a.`sup_doc_id988a` IS NULL OR a.`sup_pt6` IS NULL OR a.`sup_coe` IS NULL OR a.`sup_hq` IS NULL OR a.`sup_polohk` IS NULL OR a.`sup_infosheet` IS NULL OR a.`sup_privacy_policy` IS NULL OR a.`sup_affidavit` IS NULL OR a.`sup_mmr_vac` IS NULL OR a.`cert_ereg` IS NULL OR a.`cert_peos` IS NULL OR a.`cert_pdos` IS NULL OR a.`cert_owwa` IS NULL OR a.`cert_nc2` IS NULL OR a.`cert_ofw_infosheet` IS NULL OR a.`visa` IS NULL OR a.`oec_covid_dec` IS NULL OR a.`oec_insurance` IS NULL OR a.`oec_pregnancy_test` IS NULL OR a.`oec_swab_test` IS NULL OR a.`user_profile` IS NULL OR a.`user_profile_face` IS NULL OR a.`user_video` IS NULL OR b.`diploma` ORDER BY a.`lname` ASC");
            }

            return response()->view('report/lackingdocumentPDF', $data, 200)->header('Content-Type', 'application/pdf');
        } elseif ($formFields['tag'] == "termination") {
            foreach ($whereFilter as $key => $value) {
                if ($value) {
                    $where[] = array($key, '=', $value);
                }
            }

            $data['dateof'] = "As of " . date("F j, Y");


            $table = "applicants";

            $data['edatalist']['applicant_id'] = Extras::showDesc('applicant_id');
            $data['edatalist']['maid_ref'] = Extras::showDesc('passport_no');
            $data['edatalist']['er_ref'] = Extras::showDesc('passport_validity');
            $data['edatalist']['fullname'] = Extras::showDesc('fullname');
            $data['edatalist']['jobsite'] = Extras::showDesc('jobsite');
            $data['edatalist']['branch'] = Extras::showDesc('branch');
    
            if ($table) {
                $data['result'] = DB::table($table)->where($where)->orderBy('jobsite', 'ASC')->orderBy('branch', 'ASC')->orderBy('lname', 'ASC')->get();
            }

            foreach ($data['result'] as $key => $value) {
                if (isset($data['result'][$key]->sales_manager)) $data['result'][$key]->sales_manager = DB::table('users')->where('id', $value->sales_manager)->value('name');
                if (isset($data['result'][$key]->jobsite)) $data['result'][$key]->jobsite = DB::table('jobsites')->where('code', $value->jobsite)->value('description');
                if (isset($data['result'][$key]->passport_place_issued)) $data['result'][$key]->passport_place_issued = DB::table('countries')->where('code', $value->passport_place_issued)->value('description');
                if (isset($data['result'][$key]->branch)) $data['result'][$key]->branch = DB::table('branches')->where('code', $value->branch)->value('description');
                if (isset($data['result'][$key]->user_profile_face)) $data['result'][$key]->user_profile_face = Storage::disk("public")->url($value->user_profile_face);
                if (isset($data['result'][$key]->user_profile)) $data['result'][$key]->user_profile = Storage::disk("public")->url($value->user_profile);
            }

            return response()->view('report/masterlistPDF', $data, 200)->header('Content-Type', 'application/pdf');
        }
        
    }



}
