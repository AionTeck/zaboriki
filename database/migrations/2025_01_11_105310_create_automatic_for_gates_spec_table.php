<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('automatic_for_gate_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('automatic_for_gate_id')
                ->constrained('automatic_for_gates')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('gate_type_id')
                ->constrained('gate_types')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedInteger('price');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('automatic_for_gates_spec');
    }
};
