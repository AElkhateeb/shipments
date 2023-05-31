<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminActivationsTable extends Migration
{
    /**
     * Run the migrations.2017_08_24_000000_create_seo_admins_table
     * 2017_08_24_000000_create_seo_password_resets_table
     * 2017_08_24_000000_create_seo_activations_table
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('admin_activations', static function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->boolean('used')->default(false);
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('admin_activations');
    }
}
