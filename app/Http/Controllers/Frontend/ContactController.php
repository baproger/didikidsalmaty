<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Application;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        SEOTools::setTitle(__('nav.contact') . ' | ' . config('app.name'));
        return view('contact.index');
    }

    public function store(ContactRequest $request)
    {
        Application::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'child_age' => $request->child_age,
            'message'   => $request->message,
            'status'    => 'new',
        ]);

        $to = Setting::get('contact_email', config('mail.from.address'));

        if ($to) {
            $childAgeText = $request->child_age ? "\nВозраст ребёнка: {$request->child_age}" : '';
            Mail::raw(
                "Имя: {$request->name}\nEmail: {$request->email}\nТелефон: {$request->phone}{$childAgeText}\n\n{$request->message}",
                fn ($m) => $m->to($to)->subject("Новая заявка: {$request->name}")
            );
        }

        return back()->with('success', __('contact.sent'));
    }
}
