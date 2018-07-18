<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_eng');
            $table->string('prefix')->unique();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('units')->insert([
            ['name' => 'หลา', 'name_eng' => 'Yard', 'prefix' => 'y'],
            ['name' => 'เมตร', 'name_eng' => 'Meter', 'prefix' => 'm'],
            ['name' => 'กิโลกรัม', 'name_eng' => 'Kilogram', 'prefix' => 'kg'],
            ['name' => 'ชิ้น', 'name_eng' => 'Piece', 'prefix' => 'pe']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
