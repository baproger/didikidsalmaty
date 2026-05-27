<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('teachers', function (Blueprint $table) {
            $table->json('education')->nullable()->after('bio');
            $table->json('experience')->nullable()->after('education');
            $table->json('subjects')->nullable()->after('experience');
        });
    }
    public function down(): void {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['education','experience','subjects']);
        });
    }
};
