<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lot_number');
            $table->integer('product_id')->unsigned();
            $table->float('qtyp',10,2)->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->index(['product_id','unit_id']);
            $table->unique(['lot_number', 'product_id']);
        });
        
        Schema::table('stocks', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
