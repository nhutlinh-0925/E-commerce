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
        Schema::create('phi_van_chuyens', function (Blueprint $table) {
            $table->id();
            $table->string('pvc_ThanhPho');
            $table->integer('pvc_PhiVanChuyen');
            $table->unsignedBigInteger('thanh_pho_id');
            $table->foreign('thanh_pho_id')
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
        Schema::dropIfExists('phi_van_chuyens');
    }
};
