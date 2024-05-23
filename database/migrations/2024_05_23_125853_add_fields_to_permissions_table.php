<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('operation')->after('name');
            $table->string('model')->after('operation');
            $table->boolean('is_crud')->default(true)->after('model');
            $table->boolean('is_active')->default(true)->after('is_crud');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('operation');
            $table->dropColumn('model');
            $table->dropColumn('is_crud');
            $table->dropColumn('is_active');
        });
    }
};
