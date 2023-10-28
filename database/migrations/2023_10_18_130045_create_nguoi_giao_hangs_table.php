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
        Schema::create('nguoi_giao_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tai_khoan_id')->nullable();
            $table->string('ngh_Ten');
            $table->string('ngh_SoDienThoai');
            $table->string('ngh_DiaChi');

            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();

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
        Schema::dropIfExists('nguoi_giao_hangs');
    }
};
