<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gate_specs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('width');
            $table->unsignedBigInteger('height');
            $table->string('price');
            $table->foreignId('gate_id')
                ->constrained('gates')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gate_specs');
    }
};
