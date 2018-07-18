<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name')->nullable()->default('');
            $table->string('alias_name')->nullable()->default('ไม่ระบุ');
            $table->string('email')->nullable()->default('ไม่ระบุ');
            $table->string('phone_no',20);
            $table->string('address')->nullable()->default('ไม่ระบุ');
            $table->timestamps();
        });
        \DB::table('customers')->insert([
            ['first_name' =>'วทัญญู','last_name'=>'พรมมา','phone_no'=>'0123456789']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
