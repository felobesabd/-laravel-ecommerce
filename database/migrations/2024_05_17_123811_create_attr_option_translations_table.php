<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttrOptionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attr_option_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attr_option_id')->unsigned();
            $table->string('locale');
            $table->string('name');

            $table->unique(['option_id', 'locale']);
            $table->foreign('option_id')->references('id')->on('attr_options')->onDelete('cascade');
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
        Schema::dropIfExists('attr_option_translations');
    }
}
