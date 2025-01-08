<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fence_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fence_id')
                ->index()
                ->constrained('fences')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('spec_type')
                ->nullable()
                ->index();

            $table->string('value')
                ->nullable();

            $table->decimal('price')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fence_combinations');
    }
};
