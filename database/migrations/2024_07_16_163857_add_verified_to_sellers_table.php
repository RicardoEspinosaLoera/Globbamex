<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->text('description')->nullable()->after('email');
            $table->string('document')->nullable()->after('description');
            $table->enum('gender', [1, 2])->nullable()->after('document');
            $table->enum('years21', [0, 1])->nullable()->after('gender');
            $table->enum('verified', [0, 1])->default(0)->after('app_language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['description', 'document', 'gender', 'years21', 'verified']);
        });
    }
};
