<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_clients', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('user')->nullable();
            $table->string('ip_client')->nullable();
            $table->string('caller_id')->nullable();
            $table->string('uptime')->nullable();
            $table->string('total_active')->nullable();
            $table->string('service')->nullable();
            $table->string('last_disconnect_reason')->nullable();
            $table->string('last_logout')->nullable();
            $table->string('last_caller_id')->nullable();
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
        Schema::dropIfExists('monitoring_clients');
    }
};
