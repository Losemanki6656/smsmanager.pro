<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadries', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->nullable();
            $table->integer('number_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->string('fullname')->nullable();
            $table->date('last_date')->nullable();
            $table->date('next_date')->nullable();
            $table->string('passport')->nullable();
            $table->string('stativ')->nullable();
            $table->string('rad')->nullable();
            $table->string('mesto')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('cadries');
    }
}
