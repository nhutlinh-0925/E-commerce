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
        Schema::create('thong_kes', function (Blueprint $table) {
            $table->id();
            $table->date('tk_Ngay');
            $table->integer('tk_SoLuong');
            $table->decimal('tk_DoanhSo',10,0);
            $table->decimal('tk_DoanhThu',10,0);
            $table->decimal('tk_LoiNhuan',10,0);
            $table->integer('tk_TongDonHang');
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
        Schema::dropIfExists('thong_kes');
    }
};
