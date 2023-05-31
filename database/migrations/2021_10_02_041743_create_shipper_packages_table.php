<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipperPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipper_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shipper_id');
            $table->foreign('shipper_id')->references('id')->on('shipper_admins')->onDelete('cascade');
            $table->unsignedInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->integer('shipment_count')->default(0);
            $table->timestamp('end_at');
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
        Schema::dropIfExists('shipper_packages');
    }
}
