<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing string values to JSON {"ru": "value"} before changing column type
        $teachers = DB::table('teachers')->get(['id', 'name', 'position']);

        foreach ($teachers as $teacher) {
            $name = is_string($teacher->name) && !$this->isJson($teacher->name)
                ? json_encode(['ru' => $teacher->name], JSON_UNESCAPED_UNICODE)
                : $teacher->name;

            $position = $teacher->position && !$this->isJson($teacher->position)
                ? json_encode(['ru' => $teacher->position], JSON_UNESCAPED_UNICODE)
                : ($teacher->position ?? json_encode([], JSON_UNESCAPED_UNICODE));

            DB::table('teachers')->where('id', $teacher->id)->update([
                'name'     => $name,
                'position' => $position,
            ]);
        }

        Schema::table('teachers', function (Blueprint $table) {
            $table->json('name')->change();
            $table->json('position')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('name')->change();
            $table->string('position')->nullable()->change();
        });
    }

    private function isJson(string $value): bool
    {
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE && str_starts_with(trim($value), '{');
    }
};
