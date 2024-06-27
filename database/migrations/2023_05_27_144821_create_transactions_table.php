<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->default(0);
            $table->integer('freelancer_id')->default(0);
            $table->integer('business_owner_id')->default(0);
            $table->integer('type_id')->default(0);
            $table->decimal('price',8,2)->default(0);
            $table->boolean('is_payment')->default(0);
            $table->string('payment')->nullable();
            $table->text('payment_info')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
