<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tablecolumns');
        
        Schema::create('tablecolumns', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("column");
            $table->string("status");
            $table->string("table_id");
            $table->string("table");
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->string('created_by', 50)->nullable()->default(1);
        });

        DB::unprepared("INSERT INTO tablecolumns(`id`,`title`,`column`,`status`,`table_id`,`table`,`created_at`,`created_by`) VALUES
        (2,'Description','description','Show',1,'campuses','2022-11-21 06:45:01',1)
        ,(3,'Created By','created_by','Show',1,'campuses','2022-11-21 06:45:01',1)
        ,(4,'Code','code','Show',2,'courses','2022-11-21 06:45:05',1)
        ,(5,'Description','description','Show',2,'courses','2022-11-21 06:45:05',1)
        ,(6,'Created By','created_by','Show',2,'courses','2022-11-21 06:45:05',1)
        ,(7,'Code','code','Show',3,'sections','2022-11-21 06:45:09',1)
        ,(8,'Description','description','Show',3,'sections','2022-11-21 06:45:09',1)
        ,(9,'Created By','created_by','Show',3,'sections','2022-11-21 06:45:09',1)
        ,(10,'Code','code','Show',4,'yearlevels','2022-11-21 06:45:12',1)
        ,(11,'Description','description','Show',4,'yearlevels','2022-11-21 06:45:12',1)
        ,(12,'Created By','created_by','Show',4,'yearlevels','2022-11-21 06:45:12',1)
        ,(13,'Year Level','year_level','Show',5,'subjects','2022-11-21 06:45:24',1)
        ,(14,'Subject Course','subject_area','Show',5,'subjects','2022-11-21 06:45:24',1)
        ,(15,'Catalog #','catalog_no','Show',5,'subjects','2022-11-21 06:45:24',1)
        ,(16,'Course Code','course_code','Show',5,'subjects','2022-11-21 06:45:24',1)
        ,(17,'Pre Subject Code','pre_code','Show',5,'subjects','2022-11-21 06:45:24',1);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tablecolumns');
    }
};
