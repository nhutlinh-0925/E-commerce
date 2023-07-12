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
        Schema::create('tai_khoans', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verified_code')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->integer('loai');
            $table->integer('trangthai');
            $table->integer('vip');
            $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('tai_khoans');
    }
};
