<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleAdsenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_adsense', function (Blueprint $table) {
            $table->id();
            $table->string('ad_slot');
            $table->string('ad_client');
            $table->string('ad_size');
            $table->string('ad_width')->nullable();
            $table->string('ad_height')->nullable();
            $table->string('ad_format')->nullable();
            $table->enum('full_width_responsive', ['true', 'false'])->default('false')->nullable();
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
        Schema::dropIfExists('google_adsense');
    }
}
