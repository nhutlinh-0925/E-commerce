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
        Schema::create('ma_giam_gias', function (Blueprint $table) {
            $table->id();
            $table->string('mgg_TenGiamGia');
            $table->string('mgg_MaGiamGia');
            $table->integer('mgg_SoLuongMa');
            $table->string('mgg_LoaiGiamGia');
            $table->integer('mgg_GiaTri');
            $table->date('mgg_NgayBatDau');
            $table->date('mgg_NgayKetThuc');
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
        Schema::dropIfExists('ma_giam_gias');
    }
};
