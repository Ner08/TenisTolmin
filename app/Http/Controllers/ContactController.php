<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactMailRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function sendEmail(ContactMailRequest $request)
    {
        $formFields = $request->validated();

        $email = $formFields['email'];
        $content = $formFields['content'];

        Mail::to('info@tenis-tolmin.si')->send(new ContactMail($email, $content));
        return back()->with(['message' => 'Sporočilo uspešno poslano.']);
    }
}
