<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_asset', function (Blueprint $table) {
            $table->id('it_asst_id');
            $table->string('it_asst_number',25)->unique();
            $table->string('it_asst_name');
            $table->integer('it_asstty_id');
            $table->string('it_asst_serial',50)->nullable();            
            $table->enum('it_asst_status',['ไม่ใช้งาน','ใช้งาน','สำรอง','ส่งซ่อม','ออกจำหน่าย','ยืมใช้งาน'])->default('สำรอง');
            $table->enum('it_asst_group',['ทรัพย์สินบุคคลถือครอง','ทรัพย์สินส่วนกลางฝ่าย'])->default('ทรัพย์สินส่วนกลางฝ่าย');
            $table->string('it_asst_remark')->nullable();
            $table->decimal('it_asst_price',12,2)->default(0.00);
            $table->date('it_asst_expired')->nullable();
            $table->string('it_asst_warrantry',25)->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('it_asset');
    }
};
