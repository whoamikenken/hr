<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tablecolumn extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'table_id',
        'column',
        'table',
        'status'
    ];

    public $timestamps = false;

    public static function processColumnName($column)
    {
        $returnArray = array();

        $colDescription = Tablecolumn::getColumnArray();
        unset($column[0]);
        foreach ($column as $key => $value) {
            if (isset($colDescription[$value->Field])) {
                $returnArray[] = array(
                    'code' => $value->Field,
                    'description' => $colDescription[$value->Field]
                );
            }
        }
        return json_decode(json_encode($returnArray), FALSE);
    }

    public static function getColumnArray(){
        $colDescription = array(
            'code' => 'Code',
            'description' => 'Description',
            'color' => 'Color',
            'employee_id' => 'Employee ID',
            'remarks' => 'Remarks',
            'chops' => 'Passport Chops',
            'jobsite' => 'Jobsite',
            'office' => 'Office',
            'department' => 'Department',
            'updated_at' => 'Modified On',
            'address' => 'Address',
            'contact' => 'Contact',
            'office_head' => 'Office Head/Approver',
            'color' => 'Color',
            'email' => 'Email',
            'purpose' => 'Purpose',
            'region' => 'Region',
            'location' => 'Location',
            'expiration_date' => 'Expiration Date',
            'modified_by' => 'Modified By',
            'created_at' => 'Created On',
            'created_by' => 'Created By',
            'subject_area' => 'Subject Course',
            'catalog_no' => 'Catalog #',
            'course_code' => 'Course Code',
            'course_desc' => 'Course',
            'units' => 'Units',
            'title' => 'Title',
            'short_description' => 'Description',
            'component' => 'Component',
            'pre_code' => 'Pre Subject Code',
            'requisite' => 'Prerequisite',
            'curr' => 'Curricolum',
            'yearlevel' => 'Year Level',
            'section' => 'Section',
            'student_count' => 'Students',
            'year_level' => 'Year Level'
        );

        return $colDescription;
    }

    public static function getColumnDescription($column)
    {
        $colDescription = Tablecolumn::getColumnArray();

        return $colDescription[$column];
    }

    public static function getTableName($id)
    {
        $colDescription = DB::table('setups')->where('id', $id)->first();

        return $colDescription->table;
    }

    public static function getColumn($table){
        $column = array();
        $preselected = array('code', 'description','color','office', 'department','purpose', 'employee_id');

        $record = DB::table('tablecolumns')->where('table', $table)->get();
        foreach ($record as $key => $value) {
            $column[] = array("title" => $value->title, "column" => $value->column);
        }
       
        foreach ($preselected as $key => $value) {
            if(!array_search($value, array_column($column, 'column'))){
                if(Schema::hasColumn($table, $value)){
                    $column[] = array("title" => Tablecolumn::getColumnDescription($value), "column" => $value);
                }
            }
        }
        return $column;
    }
}
