<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code_id')->unsigned();
            $table->integer('order_id')->unsigned()->nullable()->unique();
            $table->integer('created_by')->unsigned();
            $table->string('lot_number');
            $table->float('qtys',10,2)->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->text('detail')->nullable();
            $table->float('price_per_unit',10,2)->unsigned()->nullable();
            $table->float('total_price',15,2)->unsigned()->nullable();
            $table->enum('complete',['yes','no'])->default('no');
            $table->enum('makebill',['yes','no'])->default('no');
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')->onDelete('cascade');;
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');
            $table->foreign('unit_id')
                  ->references('id')
                  ->on('units');
            $table->foreign('code_id')
                  ->references('id')
                  ->on('codes')
                  ->onDelete('cascade');
            $table->index(['order_id','unit_id']);
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('NULL on update CURRENT_TIMESTAMP'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exports');
    }
}
