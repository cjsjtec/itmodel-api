<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('products_product_categories', function (Blueprint $table) {
			$table->integer('id_products')->unsigned();
			$table->integer('id_product_categories')->unsigned();
			
			$table->foreign('id_products')->references('id')->on('products');
			$table->foreign('id_product_categories')->references('id')->on('product_categories');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::dropIfExists('products_product_categories');
    }
}
