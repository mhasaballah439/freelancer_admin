<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->default(0);
            $table->integer('freelancer_id')->default(0);
            $table->integer('business_owner_id')->default(0);
            $table->integer('rate')->default(0);
            $table->text('text')->nullable();
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
        Schema::dropIfExists('project_rates');
    }
}
