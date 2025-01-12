<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accessoryables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accessory_id')
                ->constrained('accessories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->nullableMorphs('accessoryable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accessoryables');
    }
};
