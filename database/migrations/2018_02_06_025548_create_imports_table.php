<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->string('product_color')->nullable();
            $table->integer('lot_number')->unsigned();
            $table->float('qtyp',10,2)->unsigned();
            $table->float('qtys',10,2)->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->float('cost_per_unit',10,2)->unsigned();
            $table->float('total_cost',12,2)->unsgined();
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');;
            $table->index(['product_id']);
            $table->unique(['lot_number', 'product_color','product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imports');
    }
}
