<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')->where('key', 'priorities')->delete();
        Cache::forget('setting.priorities');
    }

    public function down(): void {}
};
