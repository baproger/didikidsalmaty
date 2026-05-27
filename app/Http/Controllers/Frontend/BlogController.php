<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Artesaos\SEOTools\Facades\SEOTools;

class BlogController extends Controller
{
    public function index()
    {
        SEOTools::setTitle(__('nav.blog') . ' | ' . config('app.name'));

        $posts = Post::published()
            ->with('category')
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::withCount('posts')->orderBy('order')->get();

        return view('blog.index', compact('posts', 'categories'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        SEOTools::setTitle($category->name . ' | ' . config('app.name'));

        $posts = Post::published()
            ->where('category_id', $category->id)
            ->with('category')
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::withCount('posts')->orderBy('order')->get();

        return view('blog.index', compact('posts', 'categories', 'category'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->published()->with('category', 'author')->firstOrFail();
        $locale = app()->getLocale();

        SEOTools::setTitle(($post->getTranslation('meta_title', $locale) ?: $post->getTranslation('title', $locale)) . ' | ' . config('app.name'));
        SEOTools::setDescription($post->getTranslation('meta_description', $locale));

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'related'));
    }
}
