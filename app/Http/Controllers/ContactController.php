<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactRequest;

class ContactController extends Controller
{
    //
public function create()
{
    return view('contact');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    ContactRequest::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'subject' => $validated['subject'],
        'message' => $validated['message'],
        'status' => 'new',
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('contact')->with('success', 'Message sent successfully we will reach you shortly');
}

}
