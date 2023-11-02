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
        Schema::create('san_pham_kich_thuocs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('san_pham_id');
            $table->unsignedBigInteger('kich_thuoc_id');
            $table->integer('spkt_soLuongHang');
            $table->foreign('san_pham_id')
                ->references('id')
                ->on('san_phams')
                ->onDelete('cascade');
            $table->foreign('kich_thuoc_id')
                ->references('id')
                ->on('kich_thuocs')
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
        Schema::dropIfExists('san_pham_kich_thuocs');
    }
};
