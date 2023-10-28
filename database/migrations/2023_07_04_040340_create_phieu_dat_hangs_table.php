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
            $table->unsignedBigInteger('nhan_vien_id')->nullable();
            $table->unsignedBigInteger('nguoi_giao_hang_id')->nullable();
            $table->unsignedBigInteger('ma_giam_gia_id')->nullable();
            $table->unsignedBigInteger('phuong_thuc_thanh_toan_id')->nullable();
            $table->string('pdh_DiaChiGiao')->nullable();
            $table->string('pdh_GhiChu')->nullable();
            $table->integer('pdh_TrangThai');
            $table->date('pdh_NgayDat')->nullable();
            $table->integer('pdh_TongTien');
            $table->foreign('khach_hang_id')
                ->references('id')
                ->on('khach_hangs')
                ->onDelete('cascade');
            $table->foreign('nhan_vien_id')
                ->references('id')
                ->on('nhan_viens')
                ->onDelete('cascade');
            $table->foreign('nguoi_giao_hang_id')
                ->references('id')
                ->on('nguoi_giao_hangs')
                ->onDelete('cascade');
            $table->foreign('ma_giam_gia_id')
                ->references('id')
                ->on('ma_giam_gias')
                ->onDelete('cascade');
            $table->foreign('phuong_thuc_thanh_toan_id')
                ->references('id')
                ->on('phuong_thuc_thanh_toans')
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
