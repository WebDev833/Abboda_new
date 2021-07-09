<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('companytype_id')->unsigned();
            $table->integer('area_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->string('email');
            $table->string('phone');
            $table->integer('rating');
            $table->string('slug');
            $table->string('latitude');
            $table->string('longitude');
            $table->text('address');
            $table->boolean('active');
            $table->boolean('catalog_enabled');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('companies');
    }
}
