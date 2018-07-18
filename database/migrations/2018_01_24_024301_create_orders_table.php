<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('product_id')->unsigned()->nullable();
            $table->string('product_color')->nullable();
            $table->float('qtyp',10,2)->unsigned();
            $table->enum('status',['prepare','success','cancel'])->default('prepare');
            $table->integer('created_by')->unsigned();
            $table->enum('created_for',['ext_minor','ext_major']);
            $table->index(['product_id','customer_id']);
            $table->unique(['product_id', 'product_color','code_id']);
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('NULL on update CURRENT_TIMESTAMP'))->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
           $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
           $table->foreign('created_by')->references('id')->on('users');
           $table->foreign('code_id')->references('id')->on('codes');
       });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
