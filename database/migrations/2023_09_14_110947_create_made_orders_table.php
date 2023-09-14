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
        Schema::create('made_orders', function (Blueprint $table) {
            $table->id();
            $table->string('id_order')->nullable();
            $table->string('id_image_type')->nullable();
            $table->string('size')->nullable();
            $table->string('number_peo')->nullable();
            $table->string('color')->nullable();
            $table->text('description')->nullable();
            $table->string('status_e_d')->default('0')->comment('0 เเก้ไข/ยกเลิกได้, 1 เเก้ไขไม่ได้ เเต่ยกเลิก, 2 เเก้ไข/เลิกเลิกไม่ได้');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('made_orders');
    }
};