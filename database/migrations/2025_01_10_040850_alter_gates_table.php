<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gates', function (Blueprint $table) {
            $table->foreignId('type_id')
                ->constrained('gate_types')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('gates', function (Blueprint $table) {
            $table->dropForeign('gates_type_id_foreign');
            $table->dropColumn('type_id');
        });
    }
};
