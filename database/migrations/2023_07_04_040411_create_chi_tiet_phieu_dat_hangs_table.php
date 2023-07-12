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
        Schema::create('chi_tiet_phieu_dat_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phieu_dat_hang_id');
            $table->unsignedBigInteger('san_pham_id');
            $table->integer('ctpdh_SoLuong');
            $table->integer('ctpdh_Gia');
            $table->foreign('phieu_dat_hang_id')
                ->references('id')
                ->on('phieu_dat_hangs')
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
        Schema::dropIfExists('chi_tiet_phieu_dat_hangs');
    }
};
