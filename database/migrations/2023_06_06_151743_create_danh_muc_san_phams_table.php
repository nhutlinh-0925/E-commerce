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
        Schema::create('danh_muc_san_phams', function (Blueprint $table) {
            $table->id();
            $table->string('dmsp_TenDanhMuc');
            $table->string('dmsp_MoTa');
            $table->integer('dmsp_TrangThai');
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
        Schema::dropIfExists('danh_muc_san_phams');
    }
};
