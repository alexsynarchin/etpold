<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('inn')->unsigned();
            $table->enum('type', [
                'legal_entity',
                'individual_entrepreneur',
                'individual'
            ]);
            $table->enum('role',[
                'customer_223',
                'customer_bankrupt',
                'contractor'
            ]);
            $table->enum('residence',[
                'russia',
                'other'
            ]);
            $table->tinyInteger('status')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
