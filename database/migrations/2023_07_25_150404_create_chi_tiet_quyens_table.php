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
        Schema::create('chi_tiet_quyens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quyen_id');
            $table->unsignedBigInteger('nhan_vien_id');
            $table->integer('ctq_CoQuyen');
            $table->foreign('quyen_id')
                ->references('id')
                ->on('quyens')
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
        Schema::dropIfExists('chi_tiet_quyens');
    }
};
