<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Artesaos\SEOTools\Facades\SEOTools;

class TeacherController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('Педагоги | ' . config('app.name'));
        SEOTools::setDescription('Наша команда опытных воспитателей и педагогов детского сада Didi.');

        $teachers = Teacher::where('is_active', true)->orderBy('order')->get();

        return view('teachers.index', compact('teachers'));
    }

    public function show(Teacher $teacher)
    {
        abort_unless($teacher->is_active, 404);

        SEOTools::setTitle($teacher->name . ' | ' . config('app.name'));
        SEOTools::setDescription($teacher->position . ' — ' . config('app.name'));

        $others = Teacher::where('is_active', true)
            ->where('id', '!=', $teacher->id)
            ->orderBy('order')
            ->limit(4)
            ->get();

        return view('teachers.show', compact('teacher', 'others'));
    }
}
