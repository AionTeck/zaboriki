<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('fences', function (Blueprint $table) {
            $table->foreignId('type_id')
                ->index()
                ->nullable()
                ->constrained('fence_types')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('color')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('fences', function (Blueprint $table) {
            //
        });
    }
};
