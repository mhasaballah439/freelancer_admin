<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('freelancer_id')->default(0);
            $table->integer('business_owner_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->integer('status_id')->default(0);
            $table->integer('work_period_days')->default(0);
            $table->string('title')->nullable();
            $table->text('desc')->nullable();
            $table->decimal('from_price',8,2)->default(0);
            $table->decimal('to_price',8,2)->default(0);
            $table->text('skills')->nullable();
            $table->text('questions')->nullable();
            $table->string('delete_cause')->nullable();
            $table->date('st_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
