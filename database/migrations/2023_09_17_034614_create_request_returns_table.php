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
        Schema::create('request_returns', function (Blueprint $table) {
            $table->id();
            $table->string('idOrder')->nullable();
            $table->string('bank')->nullable();
            $table->string('bankName')->nullable();
            $table->string('account_number')->nullable();
            $table->string('branch')->nullable();
            $table->text('reason')->nullable();
            $table->string('statusRequest')->nullable()->comment('0 = คำร้องไม่ผ่าน, 1 = คำร้องผ่าน');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('request_returns');
    }
};