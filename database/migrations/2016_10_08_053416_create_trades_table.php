<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned;
            $table->string('name');
            $table->enum('form',[
                'auction_in_electronic_form',
                'competition_in_the_electronic_form',
                'RFQ_electronically',
                'request_for_quotations_electronically',
                'purchase_from_a_single_vendor'
            ]);
            $table -> tinyInteger('closed')->unsigned();
            $table -> tinyInteger('published')->unsigned();
            $table -> timestamp('published_at')->nullable();
            $table -> tinyInteger('cancelled')->unsigned();
            $table -> timestamp('cancelled_at')->nullable();
            $table -> dateTime('applications_start_date');
            $table -> dateTime('applications_end_date');
            $table -> dateTime('applications_date');
            $table -> dateTime('trades_date');
            $table -> dateTime('total_date');
            $table->string('total_location');
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
        Schema::dropIfExists('trades');
    }
}
