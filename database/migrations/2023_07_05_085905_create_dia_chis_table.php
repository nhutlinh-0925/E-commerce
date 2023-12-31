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
        Schema::create('dia_chis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('khach_hang_id');
            $table->unsignedBigInteger('tinh_thanh_pho_id');
            $table->string('dc_DiaChi');
//            $table->integer('dc_TrangThai');
            $table->foreign('khach_hang_id')
                ->references('id')
                ->on('khach_hangs')
                ->onDelete('cascade');
            $table->foreign('tinh_thanh_pho_id')
                ->references('id')
                ->on('tinh_thanh_phos')
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
        Schema::dropIfExists('dia_chis');
    }
};
