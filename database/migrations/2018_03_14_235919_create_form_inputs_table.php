<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_inputs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id');
            $table->string('label')->nullable()->default(null);
            $table->string('class')->nullable()->default(null);
            $table->enum('type', ['text', 'number', 'email', 'text_area', 'checkbox', 'select', 'radio']);
            $table->mediumText('options')->nullable()->default(null);
            $table->boolean('required')->nullable()->default(false);
            $table->integer('order')->default(10000);
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
        Schema::dropIfExists('form_inputs');
    }
}
