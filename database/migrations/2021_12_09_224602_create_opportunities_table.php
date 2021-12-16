<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->integer('oppCategoryid');
            $table->integer('oppUserid');
            $table->string('companyName');
            $table->string('jobTitle');
            $table->timestamp('dueDate');
            $table->string('companyImage')->nullable();
            $table->string('companyLink');
            $table->string('description')->nullable();
            $table->timestamp('postTime')->useCurrent();
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
        Schema::dropIfExists('opportunities');
    }
}
