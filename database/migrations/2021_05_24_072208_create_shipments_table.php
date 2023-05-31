<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('pkg_num')->nullable();
                $table->integer('road_id');
                $table->integer('place_from_id');
                $table->integer('branch_from_id');
                $table->integer('place_to_id');
                $table->integer('branch_to_id');
                $table->float('weight');
                $table->boolean('pickup');
                $table->boolean('todoor');
                $table->boolean('express');
                $table->boolean('breakable');
                $table->morphs('shipper');
                $table->morphs('receiver');
                $table->integer('status');
                $table->timestamp('published_at')->nullable();
                $table->timestamp('end_at')->nullable();
                $table->float('shipp_price');
                $table->float('shipp_cost');
                $table->float('shipp_sale');
                $table->float('shipp_total');
                $table->integer('payment_method_id')->nullable();
                $table->foreign('road_id')->references('id')->on('roads')->onUpdate('cascade');
                $table->foreign('place_from_id')->references('id')->on('places')->onUpdate('cascade');
                $table->foreign('branch_from_id')->references('id')->on('branches')->onUpdate('cascade');
                $table->foreign('place_to_id')->references('id')->on('places')->onUpdate('cascade');
                $table->foreign('branch_to_id')->references('id')->on('branches')->onUpdate('cascade');
                $table->foreign('shipper_id')->references('id')->on('account_admins')->onUpdate('cascade');
                $table->foreign('shipper_id')->references('id')->on('shipper_admins')->onUpdate('cascade');
                $table->foreign('shipper_id')->references('id')->on('employee_admins')->onUpdate('cascade');
                $table->foreign('shipper_id')->references('id')->on('manger_admins')->onUpdate('cascade');
                $table->foreign('shipper_id')->references('id')->on('agent_admins')->onUpdate('cascade');
                $table->foreign('shipper_id')->references('id')->on('ceo_admins')->onUpdate('cascade');
                $table->foreign('receiver_id')->references('id')->on('receivers')->onUpdate('cascade');
                $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onUpdate('cascade');
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
        Schema::dropIfExists('shipments');
    }
}
