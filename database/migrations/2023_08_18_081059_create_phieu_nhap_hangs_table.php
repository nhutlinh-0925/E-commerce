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
        Schema::create('phieu_nhap_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nhan_vien_id');
            $table->unsignedBigInteger('nha_cung_cap_id');
            $table->timestamp('pnh_NgayLapPhieu');
            $table->timestamp('pnh_NgayXacNhan')->nullable();
            $table->decimal('pnh_TongTien',10,0);
            $table->longText('pnh_GhiChu');
            $table->integer('pnh_TrangThai');
            $table->foreign('nhan_vien_id')
                ->references('id')
                ->on('nhan_viens')
                ->onDelete('cascade');
            $table->foreign('nha_cung_cap_id')
                ->references('id')
                ->on('nha_cung_caps')
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
        Schema::dropIfExists('phieu_nhap_hangs');
    }
};
