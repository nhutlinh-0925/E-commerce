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
        Schema::create('khach_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tai_khoan_id');
            $table->string('kh_Ten');
            $table->string('kh_SoDienThoai')->nullable();
            $table->decimal('kh_TongTienDaMua',10,0)->default('0');

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken()->nullable();

            $table->foreign('tai_khoan_id')
            ->references('id')
            ->on('tai_khoans')
            ->onDelete('cascade');
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
        Schema::dropIfExists('khach_hangs');
    }
};
