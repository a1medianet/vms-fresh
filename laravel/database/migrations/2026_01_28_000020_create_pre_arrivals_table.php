<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pre_arrivals', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('arrival_date')->nullable();
            $table->date('departure_date')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pre_arrivals');
    }
};

