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
        Schema::create('customers', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name', 50)->comment('customer name');
            $table->double('a_apply_pay', 8, 2)->comment('currency type is apply pay')->nullable(true)->default(0);
            $table->double('b_bitcoin', 8, 2)->comment('currency type is bit coin')->nullable(true)->default(0);
            $table->double('m_game_currency', 8, 2)->comment('currency type is game currency')->nullable(true)->default(0);
            $table->double('c_card', 8, 2)->comment('currency type is CAD')->nullable(true)->default(0);
            $table->double('u_usdt', 8, 2)->comment('currency type is usdt')->nullable(true)->default(0);
            $table->double('l_litecoin', 8, 2)->comment('currency type is litecoin')->nullable(true)->default(0);
            $table->tinyInteger('flag'); //1: customer, 0: hosts
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('customers');
    }
};
