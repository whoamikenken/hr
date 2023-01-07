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
        Schema::create('province', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::dropIfExists('province');

        Schema::create('province', function (Blueprint $table) {
            $table->id();
            $table->string('country', 20)->nullable()->default('NULL');
            $table->string('psg_code', 20)->nullable()->default('NULL');
            $table->string('description', 50)->nullable()->default('NULL');
            $table->string('region_code', 20)->nullable()->default('NULL');
            $table->string('province_code', 20)->nullable()->default('NULL');
            $table->timestamps();
        });

        DB::unprepared("INSERT INTO `province` (`country`,`psg_code`, `description`, `region_code`, `province_code`) VALUES ('PH','012800000','ILOCOS NORTE','01','128'),('PH','012900000','ILOCOS SUR','01','129'),('PH','013300000','LA UNION','01','133'),('PH','015500000','PANGASINAN','01','155'),('PH','020900000','BATANES','02','209'),('PH','021500000','CAGAYAN','02','215'),('PH','023100000','ISABELA','02','231'),('PH','025000000','NUEVA VIZCAYA','02','250'),('PH','025700000','QUIRINO','02','257'),('PH','030800000','BATAAN','03','308'),('PH','031400000','BULACAN','03','314'),('PH','034900000','NUEVA ECIJA','03','349'),('PH','035400000','PAMPANGA','03','354'),('PH','036900000','TARLAC','03','369'),('PH','037100000','ZAMBALES','03','371'),('PH','037700000','AURORA','03','377'),('PH','041000000','BATANGAS','04','410'),('PH','042100000','CAVITE','04','421'),('PH','043400000','LAGUNA','04','434'),('PH','045600000','QUEZON','04','456'),('PH','045800000','RIZAL','04','458'),('PH','174000000','MARINDUQUE','17','1740'),('PH','175100000','OCCIDENTAL MINDORO','17','1751'),('PH','175200000','ORIENTAL MINDORO','17','1752'),('PH','175300000','PALAWAN','17','1753'),('PH','175900000','ROMBLON','17','1759'),('PH','050500000','ALBAY','05','505'),('PH','051600000','CAMARINES NORTE','05','516'),('PH','051700000','CAMARINES SUR','05','517'),('PH','052000000','CATANDUANES','05','520'),('PH','054100000','MASBATE','05','541'),('PH','056200000','SORSOGON','05','562'),('PH','060400000','AKLAN','06','604'),('PH','060600000','ANTIQUE','06','606'),('PH','061900000','CAPIZ','06','619'),('PH','063000000','ILOILO','06','630'),('PH','064500000','NEGROS OCCIDENTAL','06','645'),('PH','067900000','GUIMARAS','06','679'),('PH','071200000','BOHOL','07','712'),('PH','072200000','CEBU','07','722'),('PH','074600000','NEGROS ORIENTAL','07','746'),('PH','076100000','SIQUIJOR','07','761'),('PH','082600000','EASTERN SAMAR','08','826'),('PH','083700000','LEYTE','08','837'),('PH','084800000','NORTHERN SAMAR','08','848'),('PH','086000000','SAMAR (WESTERN SAMAR)','08','860'),('PH','086400000','SOUTHERN LEYTE','08','864'),('PH','087800000','BILIRAN','08','878'),('PH','097200000','ZAMBOANGA DEL NORTE','09','972'),('PH','097300000','ZAMBOANGA DEL SUR','09','973'),('PH','098300000','ZAMBOANGA SIBUGAY','09','983'),('PH','099700000','CITY OF ISABELA','09','997'),('PH','101300000','BUKIDNON','10','1013'),('PH','101800000','CAMIGUIN','10','1018'),('PH','103500000','LANAO DEL NORTE','10','1035'),('PH','104200000','MISAMIS OCCIDENTAL','10','1042'),('PH','104300000','MISAMIS ORIENTAL','10','1043'),('PH','112300000','DAVAO DEL NORTE','11','1123'),('PH','112400000','DAVAO DEL SUR','11','1124'),('PH','112500000','DAVAO ORIENTAL','11','1125'),('PH','118200000','COMPOSTELA VALLEY','11','1182'),('PH','118600000','DAVAO OCCIDENTAL','11','1186'),('PH','124700000','COTABATO (NORTH COTABATO)','12','1247'),('PH','126300000','SOUTH COTABATO','12','1263'),('PH','126500000','SULTAN KUDARAT','12','1265'),('PH','128000000','SARANGANI','12','1280'),('PH','129800000','COTABATO CITY','12','1298'),('PH','133900000','MANILA','13','1339'),('PH','140100000','ABRA','14','1401'),('PH','141100000','BENGUET','14','1411'),('PH','142700000','IFUGAO','14','1427'),('PH','143200000','KALINGA','14','1432'),('PH','144400000','MOUNTAIN PROVINCE','14','1444'),('PH','148100000','APAYAO','14','1481'),('PH','150700000','BASILAN','15','1507'),('PH','153600000','LANAO DEL SUR','15','1536'),('PH','153800000','MAGUINDANAO','15','1538'),('PH','156600000','SULU','15','1566'),('PH','157000000','TAWI-TAWI','15','1570'),('PH','160200000','AGUSAN DEL NORTE','16','1602'),('PH','160300000','AGUSAN DEL SUR','16','1603'),('PH','166700000','SURIGAO DEL NORTE','16','1667'),('PH','166800000','SURIGAO DEL SUR','16','1668'),('PH','168500000','DINAGAT ISLANDS','16','1685')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('province');
    }
};
