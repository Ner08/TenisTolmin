<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipMailRequest;
use App\Mail\MembershipMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MembershipController extends Controller
{
    public function index()
    {
        return view('membership.index');
    }

    public function sendEmail(MembershipMailRequest $request)
    {
        $formFields = $request->validated();

        $name = $formFields['name'];
        $email = $formFields['email'];
        $telephone = $formFields['telephone'] ?? null;
        $membershipType = $formFields['type'];

        Mail::to('info@tenis-tolmin.si')->send(new MembershipMail($name, $email, $telephone, $membershipType));
        return back()->with(['message' => 'Prošnja za včlanitev uspešno poslana.']);
    }
}
