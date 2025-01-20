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
        Schema::create('new_bets', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('customer_id');  
            $table->tinyText('slip')->comment('bet description');
            $table->double('odds', 8, 2)->comment('bet odds');
            $table->tinyInteger('live')->comment('game is live or not')->default(0);
            $table->double('amount', 8, 2)->comment('betting amount');
            $table->tinyInteger('currency')->comment('currency type');
            $table->json('splitters')->comment('splitter user group')->nullable(true);
            $table->tinyInteger('status')->comment('status 1:win, 0:lose, 2:void')->nullable(true);
            $table->tinyInteger('bsplitter')->comment('user is splitter or not')->nullable(true)->default(1);
            $table->multiLineString('notes')->comment('note')->nullable(true); 
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
        Schema::dropIfExists('new_bets');
    }
};
