<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdPlacementAdvertisementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_placement_advertisement', function (Blueprint $table) {
            $table->foreignId('advertisement_id')
                ->constrained('advertisements')
                ->onDelete('cascade');
            $table->foreignId('ad_placement_id')
                ->constrained('ad_placements')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_placement_advertisement');
    }
}
