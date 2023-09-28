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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('order_code');
            $table->string('fname');
            $table->string('lname');
            $table->string('email');
            $table->string('phone');
            $table->string('address1');
            $table->string('road');
            $table->string('subdistrict');
            $table->string('district');
            $table->string('province');
            $table->string('zipcode');
            $table->string('total_price')->nullable();
            $table->tinyInteger('status');
            $table->string('message')->nullable();
            $table->string('full_amount')->nullable();
            $table->string('tracking_no')->nullable();
            $table->string('cancel_order')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
