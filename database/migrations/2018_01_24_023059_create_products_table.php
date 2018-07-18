<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',20)->unique();
            $table->string('name');
            $table->timestamps();
        });

        \DB::table('products')->insert([
            ['code' => '688M 230 GM', 'name' => 'RAYORN P/D 58/60"'],
            ['code' => '688TN 190 GM', 'name' => 'RAYORN P/D 58/60"'],
            ['code' => '6688 230 GM', 'name' => 'RAYORN P/D 58/60"'],
            ['code' => '6688 TN 190 GM', 'name' => 'RAYORN P/D 58/60"']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
