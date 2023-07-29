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
        Schema::create('bai_viets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('danh_muc_bai_viet_id');
            $table->unsignedBigInteger('nhan_vien_id')->nullable();
            $table->longText('bv_TieuDeBaiViet');
            $table->longText('bv_NoiDungNgan');
            $table->longText('bv_NoiDungChiTiet');
            $table->string('bv_AnhDaiDien');
            $table->integer('bv_LuotXem')->default('0');
            $table->integer('bv_TrangThai');
            $table->string('bv_Tag')->nullable();
            $table->date('bv_NgayTao');
            $table->foreign('danh_muc_bai_viet_id')
                ->references('id')
                ->on('danh_muc_bai_viets')
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
        Schema::dropIfExists('bai_viets');
    }
};
