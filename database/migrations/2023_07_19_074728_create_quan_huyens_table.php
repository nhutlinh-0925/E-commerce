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
        Schema::create('quan_huyens', function (Blueprint $table) {
            $table->id();
            $table->string('qh_Ten',100);
            $table->string('qh_Loai',30);
            $table->unsignedBigInteger('thanh_pho_id');
            $table->foreign('thanh_pho_id')
                ->references('id')
                ->on('tinh_thanh_phos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quan_huyens');
    }
};
