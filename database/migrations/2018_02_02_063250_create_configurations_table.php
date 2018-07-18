<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->string('value');
            $table->string('description');
        });

        DB::table('configurations')->insert([
         ['key' => 'cripoint','value' => '5','description' => 'จำนวนปริมาณสินค้าสำหรับสินค้าใกล้หมด'],
         ['key' => 'outdatedr', 'value' => '7', 'description' => 'จำนวนวันสำหรับสินค้าค้างสต็อก'],
         ['key' => 'ex_minor_prefix', 'value' => 'ST16','description' => 'รหัสบิลส่งของ(โกดัง)'],
         ['key' => 'ex_minor_length', 'value' => '4', 'description' => 'จำนวนหลักตัวเลขบิลส่งของ(โกดัง)'],
         ['key' => 'ex_major_prefix', 'value' => 'ST18', 'description' => 'รหัสบิลส่งของ(หน้าร้าน)'],
         ['key' => 'ex_major_length', 'value' => '4', 'description' => 'จำนวนหลักตัวเลขบิลส่งของ(หน้าร้าน)'],
         ['key' => 'pv_prefix', 'value' => 'PV18', 'description' => 'รหัสสั่งซื้อ'],
         ['key' => 'pv_length', 'value' => '4', 'description' => 'จำนวนหลักตัวเลขรหัสสั่งซื้อ'],
         ['key' => 'iv_prefix', 'value' => 'IV2018', 'description' => 'รหัสใบวางบิล'],
         ['key' => 'iv_length', 'value' => '4', 'description' => 'จำนวนหลักตัวเลขรหัสใบวางบิล']
     ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
