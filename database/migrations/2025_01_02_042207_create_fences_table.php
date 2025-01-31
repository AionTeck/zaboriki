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
            $table->string('measurement_type')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fences');
    }
};
