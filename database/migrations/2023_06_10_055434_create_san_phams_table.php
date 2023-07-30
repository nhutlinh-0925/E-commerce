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
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('danh_muc_san_pham_id');
            $table->unsignedBigInteger('thuong_hieu_id');
            $table->string('sp_TenSanPham');
            $table->longText('sp_MoTa');
            $table->longText('sp_NoiDung');
            $table->longText('sp_VatLieu');
            $table->integer('sp_Gia');
            $table->integer('sp_TrangThai')->default('1');
            $table->integer('sp_SoLuongHang')->default('1');
            $table->integer('sp_SoLuongBan')->default('0');
            $table->string('sp_AnhDaiDien');
            $table->integer('sp_LuotXem')->nullable();
            $table->string('sp_MauSac')->nullable();
            $table->string('sp_KichCo')->nullable();
            $table->string('sp_Tag')->nullable();
            $table->foreign('danh_muc_san_pham_id')
            ->references('id')
            ->on('danh_muc_san_phams')
            ->onDelete('cascade');
            $table->foreign('thuong_hieu_id')
            ->references('id')
            ->on('thuong_hieus')
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
        Schema::dropIfExists('san_phams');
    }
};
