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
        Schema::create('it_employee', function (Blueprint $table) {
            $table->string('it_emp_id',10)->primary();
            $table->string('it_emp_name',100);
            $table->string('it_emp_surname',100);
            $table->string('it_emp_nickname',100)->nullable();
            $table->string('it_emp_tel',20)->nullable();
            $table->string('it_emp_email',100)->nullable();
            $table->enum('it_emp_active',['active','inactive'])->default('active');
            $table->integer('it_dept_id');
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
        Schema::dropIfExists('it_employee');
    }
};
