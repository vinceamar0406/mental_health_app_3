<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('depression_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('responses');
            $table->string('impact');
            $table->integer('total_score');
            $table->string('severity');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('depression_assessments');
    }
};
