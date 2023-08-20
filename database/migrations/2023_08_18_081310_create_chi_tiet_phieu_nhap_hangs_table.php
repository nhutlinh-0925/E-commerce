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
        Schema::create('chi_tiet_phieu_nhap_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phieu_nhap_hang_id');
            $table->unsignedBigInteger('san_pham_id');
            $table->integer('ctpnh_SoLuongNhap');
            $table->integer('ctpnh_GiaNhap');
            $table->foreign('phieu_nhap_hang_id')
                ->references('id')
                ->on('phieu_nhap_hangs')
                ->onDelete('cascade');
            $table->foreign('san_pham_id')
                ->references('id')
                ->on('san_phams')
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
        Schema::dropIfExists('chi_tiet_phieu_nhap_hangs');
    }
};
