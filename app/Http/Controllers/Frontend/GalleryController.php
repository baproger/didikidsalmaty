<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Artesaos\SEOTools\Facades\SEOTools;

class GalleryController extends Controller
{
    public function index()
    {
        SEOTools::setTitle(__('nav.gallery') . ' | ' . config('app.name'));

        $galleries = Gallery::where('is_active', true)->get();

        return view('gallery.index', compact('galleries'));
    }

    public function show(string $slug)
    {
        $gallery = Gallery::where('slug', $slug)->where('is_active', true)->firstOrFail();

        SEOTools::setTitle($gallery->title . ' | ' . config('app.name'));

        return view('gallery.show', compact('gallery'));
    }
}
