<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->jsonb('name');
            $table->float('long');
            $table->boolean('limited')->default(true);
            $table->integer('shipment_count')->default(0);
            $table->float('price')->default(0.0);
            $table->float('weight_default')->default(3.0);
            $table->float('weight_fee')->default(0.0);
            $table->boolean('road')->default(true);
            $table->float('road_sale')->default(0.0);
            $table->boolean('pickup')->default(true);
            $table->float('pickup_fee')->default(0.0);
            $table->boolean('todoor')->default(true);
            $table->float('todoor_fee')->default(0.0);
            $table->boolean('express')->default(true);
            $table->float('express_fee')->default(0.0);
            $table->boolean('breakable')->default(true);
            $table->float('breakable_fee')->default(0.0);
            $table->boolean('is_published')->default(true);
            $table->boolean('for_stuff')->default(false);
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
        Schema::dropIfExists('packages');
    }
}
