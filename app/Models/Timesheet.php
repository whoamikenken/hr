<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timesheet extends Model
{
    use HasFactory;

    public static function getLastlogs($employeeid, $date)
    {   
        $return['log_type'] = "new";
        $query = DB::table('timesheets_trail')->select("log_type", "log_time","ip","location","machine_type")->where(DB::raw('date(log_time)'), $date)->where('employee_id', $employeeid)->get();
        foreach ($query as $row) {
            $return['log_type'] = $row->log_type;
            $return['log_time'] = $row->log_time;
            $return['ip'] = $row->ip;
            $return['location'] = $row->location;
            $return['machine_type'] = $row->machine_type;
        }
        return $return;
    }
}
