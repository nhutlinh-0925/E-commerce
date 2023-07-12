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
        Schema::create('phieu_dat_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('khach_hang_id');
            $table->unsignedBigInteger('nhan_vien_id');
            $table->string('pdh_DiaChiGiao');
            $table->string('pdh_GhiChu')->nullable();
            $table->string('pdh_GiamGia')->nullable();
            $table->integer('pdh_TrangThai');
            $table->integer('pdh_PhuongThucThanhToan');
            $table->date('pdh_NgayDat');
            $table->integer('pdh_TongTien');
            $table->foreign('khach_hang_id')
                ->references('id')
                ->on('khach_hangs')
                ->onDelete('cascade');
            $table->foreign('nhan_vien_id')
                ->references('id')
                ->on('nhan_viens')
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
        Schema::dropIfExists('phieu_dat_hangs');
    }
};
