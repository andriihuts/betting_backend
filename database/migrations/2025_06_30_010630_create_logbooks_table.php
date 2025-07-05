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
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('procedure_type_id');
            $table->unsignedBigInteger('hospital_id');
            $table->string('patient_name');
            $table->string('mrn')->nullable();
            $table->string('dob')->nullable();
            $table->date('procedure_date')->nullable();
            $table->enum('role', ['Operator', 'First Assistant'])->default('Operator');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('logbooks');
    }
};
