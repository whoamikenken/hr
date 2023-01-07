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
        Schema::dropIfExists('region');

        Schema::create('region', function (Blueprint $table) {
            $table->id();
            $table->string('country', 20)->nullable()->default('NULL');
            $table->string('psg_code', 20)->nullable()->default('NULL');
            $table->string('description', 50)->nullable()->default('NULL');
            $table->string('region_code', 20)->nullable()->default('NULL');
            $table->timestamps();
        });

        DB::unprepared("INSERT INTO `region` (`country`,`psg_code`, `description`, `region_code`) VALUES ('ph','010000000','REGION I (ILOCOS REGION)','01'),('ph','020000000','REGION II (CAGAYAN VALLEY)','02'),('ph','030000000','REGION III (CENTRAL LUZON)','03'),('ph','040000000','REGION IV-A (CALABARZON)','04'),('ph','170000000','REGION IV-B (MIMAROPA)','17'),('ph','050000000','REGION V (BICOL REGION)','05'),('ph','060000000','REGION VI (WESTERN VISAYAS)','06'),('ph','070000000','REGION VII (CENTRAL VISAYAS)','07'),('ph','080000000','REGION VIII (EASTERN VISAYAS)','08'),('ph','090000000','REGION IX (ZAMBOANGA PENINSULA)','09'),('ph','100000000','REGION X (NORTHERN MINDANAO)','10'),('ph','110000000','REGION XI (DAVAO REGION)','11'),('ph','120000000','REGION XII (SOCCSKSARGEN)','12'),('ph','130000000','NATIONAL CAPITAL REGION (NCR)','13'),('ph','140000000','CORDILLERA ADMINISTRATIVE REGION (CAR)','14'),('ph','150000000','AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)','15'),('ph','160000000','REGION XIII (Caraga)','16')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region');
    }
};
