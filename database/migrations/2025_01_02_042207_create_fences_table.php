<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fences', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('measurement_id')
                ->nullable()
                ->index()
                ->constrained('measurements')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fences');
    }
};
