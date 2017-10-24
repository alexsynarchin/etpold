<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned();
            $table->timestamps();
            $table->string('full_name');
            $table->string('short_name');
            $table->integer('kpp')->unsigned();
            $table->integer('okpo')->unsigned();
            $table->integer('okvd')->unsigned();
            $table->integer('ogrn')->unsigned();
            $table -> string('phone');
            $table -> string('email');
            $table -> string('fax');
            $table -> string('website');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legals');
    }
}
