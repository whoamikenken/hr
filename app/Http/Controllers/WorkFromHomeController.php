<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Extras;
use App\Jobs\SendEmail;
use App\Mail\MailNotify;
use App\Models\Tablecolumn;
use App\Models\WorkFromHome;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class WorkFromHomeController extends Controller
{
    //
    public function index()
    {
        $data['menus'] = DB::table('menus')->get();
        return view('wfh/wfh', $data);
    }

    public function getTable()
    {
        $where = array();
        $where[] = array('employee_id', '=', Auth::user()->username);

        $data['result'] = DB::table('work_from_homes')->where($where)->get();

        // get user creator
        foreach ($data['result'] as $key => $value) {

            $data['result'][$key]->updated_by = DB::table('users')->where('id', $value->updated_by)->value('name');
            $data['result'][$key]->created_by = DB::table('users')->where('id', $value->created_by)->value('name');
        }

        $data['columns'] = Tablecolumn::getColumn("work_from_homes");
        // dd($data);
        return view('wfh/wfh_table', $data);
    }

    public function getModal(Request $request)
    {
        $data = array();
        $where = array();
        $formFields = $request->validate([
            'uid' => ['required'],
            'mode' => [''],
        ]);

        if ($formFields['uid'] != "add") {
            $data['record'] = DB::table('work_from_homes')->where('id', $formFields['uid'])->get();
            $data = $data['record'][0];
            $data = json_decode(json_encode($data), true);
        } else {
            $where[] = array("status", "PENDING");
        }

        $data['mode'] = (isset($formFields['mode'])) ? "true" : "false";

        // dd($data);
        $data['uid'] = $formFields['uid'];

        return view('wfh/wfh_modal')->with($data);
    }

    public function store(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $validator = Extras::ValidateRequest($request, [
            'uid' => ['required'],
            'purpose' => ['required'],
            'date' => ['required'],
            'work_done' => ['required']
        ]);

        if ($validator['status'] == 0) {
            return response()->json($validator);
            die;
        } else {
            $formFields = $validator['data'];
        }
        dd($formFields);

        $formFields['expense'] = implode(",", $formFields['expense']);
        $expenseList = $formFields['expense'];
        $status = "PENDING";
        if (isset($formFields['claim_status'])) $status = $formFields['claim_status'];

        // Get Budget ID
        $budget_id = $formFields['budget'];

        // Upload Document
        if ($request->hasFile('payment_doc')) {

            if ($formFields['uid'] != "add") {
                $users = DB::table('work_from_homes')->where('id', $formFields['uid'])->first();
                if ($users->payment_doc) {
                    Storage::disk('public')->delete($users->payment_doc);
                }
            }
            $fileResponse = $request->file('payment_doc')->store('reciept', 'public');
            $formFields['payment_doc'] = $fileResponse;
        }

        if ($formFields['uid'] == "add") {
            unset($formFields['uid']);
            $formFields['created_by'] = Auth::id();
            $formFields['updated_at'] = "";
            $claimCreate = WorkFromHome::create($formFields);
            $lastId = $claimCreate->id;
            $updateClaimID['claim_id'] = "C" . sprintf('%05d', $lastId);
            DB::table('work_from_homes')->where('id', $lastId)->update($updateClaimID);
            $return = array('status' => 1, 'msg' => 'Successfully added claim', 'title' => 'Success!');
            Extras::processMaidExpenses($expenseList, $lastId, $status,);

            // Update Budget 
            if ($status == "CLAIMED") {
                Extras::processBudgetClaiming($budget_id, $formFields['expense'], "process");
                // Email To Cost
                $getClaimData = Extras::getExpenseDataForEmail($expenseList, $budget_id, $lastId);

                $getAllFinanceUser = Extras::getUsersList($getClaimData['agency'], "Cost Manager");
                $email = array();
                foreach ($getAllFinanceUser as $key => $value) {
                    $email[] = $value->email;
                }

                $data = array(
                    'emailtype' => "claim_notification",
                    'subject' => "Claim Request",
                    'email' => $email,
                    'from_title' => $getClaimData['agency_title'],
                    'data' => $getClaimData
                );

                try {
                    SendEmail::dispatch($data);
                } catch (Exception $th) {
                    dump($th);
                }

                // Update cost email stat
                $emailData = array('email_cost' => 1);
                DB::table('work_from_homes')->where('id', $lastId)->update($emailData);
            } else {
                // Email To Finance
                $getClaimData = Extras::getExpenseDataForEmail($expenseList, $budget_id, $lastId);

                $getAllFinanceUser = Extras::getUsersList($getClaimData['agency'], "Finance Manager");
                $email = array();
                foreach ($getAllFinanceUser as $key => $value) {
                    $email[] = $value->email;
                }

                $data = array(
                    'emailtype' => "claim_notification",
                    'subject' => "Claim Request",
                    'email' => $email,
                    'from_title' => $getClaimData['agency_title'],
                    'data' => $getClaimData
                );

                try {
                    SendEmail::dispatch($data);
                    // $response = Mail::to($email)->send(new MailNotify($data));
                } catch (Exception $th) {
                    dump($th);
                }
                // Update finance email stat
                $emailData = array('email_finance' => 1);
                DB::table('work_from_homes')->where('id', $lastId)->update($emailData);
            }
        } else {

            $formFields['updated_at'] = Carbon::now();
            $formFields['updated_by'] = Auth::id();
            $id = $formFields['uid'];
            unset($formFields['uid']);

            // Check Old Status Process if Diff
            $oldStat = DB::table('work_from_homes')->where('id', $id)->value("claim_status");

            if ($oldStat != $status) {
                // Update Budget 
                if ($status == "CLAIMED") {
                    Extras::processBudgetClaiming($budget_id, $formFields['expense'], "process");
                    $work_from_homestatCost = DB::table('work_from_homes')->where('id', $id)->value('email_cost');
                    if ($work_from_homestatCost == 0) {
                        // Email To Cost
                        $getClaimData = Extras::getExpenseDataForEmail($expenseList, $budget_id, $id);

                        $getAllFinanceUser = Extras::getUsersList($getClaimData['agency'], "Cost Manager");
                        $email = array();
                        foreach ($getAllFinanceUser as $key => $value) {
                            $email[] = $value->email;
                        }

                        $data = array(
                            'emailtype' => "claim_notification",
                            'subject' => "Claim Request",
                            'email' => $email,
                            'from_title' => $getClaimData['agency_title'],
                            'data' => $getClaimData
                        );

                        try {
                            SendEmail::dispatch($data);
                        } catch (Exception $th) {
                            dump($th);
                        }
                        // Update cost email stat
                        $emailData = array('email_cost' => 1);
                        DB::table('work_from_homes')->where('id', $id)->update($emailData);
                    }
                } elseif ($status == "PENDING") {
                    // Check If Revert To Budget
                    Extras::processBudgetClaiming($budget_id, $formFields['expense'], "revert");
                }
                Extras::processMaidExpenses($expenseList, $id, $status, $formFields['budget'], $oldStat);
            }
            // dd($formFields);
            $formFields['claim_id'] = "C" . sprintf('%05d', $id);
            DB::table('work_from_homes')->where('id', $id)->update($formFields);
            $return = array('status' => 1, 'msg' => 'Successfully updated claim', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function delete(Request $request)
    {
        $return = array('status' => 0, 'msg' => 'Error', 'title' => 'Error!');

        $formFields = $request->validate([
            'code' => ['required']
        ]);

        $expensesData = DB::table('work_from_homes')->where('id', $formFields['code'])->first();

        // Get Budget ID
        $budget_id = DB::table('work_from_homes')->where('id', $formFields['code'])->value("budget");

        // Revert Money To Budget If Claimed
        if ($expensesData->claim_status == "CLAIMED") {
            Extras::processBudgetClaiming($budget_id, $expensesData->expense, "revert");
            Extras::processMaidExpensesDelete($expensesData->expense, $formFields['code']);
        } else {
            // delete Other Maid Expenses DAta
            Extras::processMaidExpensesDelete($expensesData->expense, $formFields['code'], false);
        }

        $delete = DB::table('work_from_homes')->where('id', '=', $formFields['code'])->delete();

        if ($delete) {
            $return = array('status' => 1, 'msg' => 'Successfully deleted claim', 'title' => 'Success!');
        }

        return response()->json($return);
    }

    public function markRead(Request $request)
    {
        $return = array('status' => 0, 'msg' => '', 'title' => '!');

        $validator = Extras::ValidateRequest($request, [
            'uid' => ['required']
        ]);

        if ($validator['status'] == 0) {
            return response()->json($validator);
            die;
        } else {
            $formFields = $validator['data'];
        }

        $updateClaimData = array();
        if (Auth::user()->user_type == "Finance Manager") {
            $updateClaimData = array('read_finance' => 1);
        } elseif (Auth::user()->user_type == "Cost Manager") {
            $updateClaimData = array('read_cost' => 1);
        }

        DB::table('work_from_homes')->where('id', $formFields['uid'])->update($updateClaimData);

        return response()->json($return);
    }
}
