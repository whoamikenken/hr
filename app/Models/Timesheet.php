<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timesheet extends Model
{
    use HasFactory;

    public static function getLastlogs($employeeid, $date)
    {   
        $return['log_type'] = "new";
        $query = DB::table('timesheets_trail_history')->select("log_type", "log_time","ip","location","machine_type")->where(DB::raw('date(log_time)'), $date)->where('employee_id', $employeeid)->get();
        foreach ($query as $row) {
            $return['log_type'] = $row->log_type;
            $return['log_time'] = $row->log_time;
            $return['ip'] = $row->ip;
            $return['location'] = $row->location;
            $return['machine_type'] = $row->machine_type;
        }
        return $return;
    }

    public static function employeeLogsData($employeeid, $timein, $timeout)
    {
        $return['status'] = "";
        $return['mins_late'] = "";
        $return['mins_undertime'] = "";
        $idx = date('N', strtotime($timein));
        $timeInFormat = date("H:i:s", strtotime($timein));
        $query = DB::table('schedules_detail_employee')->select("*")->where('idx', $idx)->where('employee_id', $employeeid)->first();
        if(empty($query)){
            $checkerLate = array('status' => "No Schedule", 'minutesLate' => 0, 'starttime' =>"00:00", 'endtime' => "00:00");
        }else{
            $checkerLate = Timesheet::checkTardy($query->starttime, $timeInFormat, $query->tardy_start, $query->absent_start);
            
            $checkerLate['starttime'] = $query->starttime;
            $checkerLate['endtime'] = $query->endtime;
            // dd($checkerLate);
        }
        
        return $checkerLate;
    }

    public static function checkTardy($startTime, $endTime, $tardyStartTime, $absentStartTime)
    {
        $startTime = DateTime::createFromFormat('H:i:s', $startTime);
        $endTime = DateTime::createFromFormat('H:i:s', $endTime);
        $tardyStartTime = DateTime::createFromFormat('H:i:s', $tardyStartTime);
        $absentStartTime = DateTime::createFromFormat('H:i:s', $absentStartTime);
        $lateTime = $endTime->diff($startTime);

        if ($lateTime->invert === 1) {
            // user arrived after start time
            $tardyTime = $tardyStartTime->diff($startTime)->i;
            $absentTime = $absentStartTime->diff($startTime)->i;
            $minutesLate = $lateTime->h * 60 + $lateTime->i;

            if ($minutesLate > $absentTime) {
                // user arrived more than the absent start time
                return array("status" => "Absent", "minutesLate" => $minutesLate);
            } elseif ($minutesLate > $tardyTime) {
                // user arrived more than the tardy start time
                return array("status" => "Tardy", "minutesLate" => $minutesLate);
            } else {
                // user arrived less than or equal to the tardy start time
                return array("status" => "On Time", "minutesLate" => $minutesLate);
            }
        } else {
            // user arrived before start time
            return array("status" => "On Time", "minutesLate" => 0);
        }
    }

}
