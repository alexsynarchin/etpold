<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->integer('trade_id')->unsigned;
            $table->integer('number')->unsigned;
            $table->decimal('start_price', 25, 2);
            $table->decimal('bid_step',10, 2);
            $table->text('name');
            $table->string('okved2');
            $table->string('okpd2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lots');
    }
}
