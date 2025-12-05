<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    ContactRequest::create([
        'name' => $validated['full_name'],
        'email' => $validated['email'],
        'subject' => $validated['subject'],
        'message' => $validated['message'],
        'status' => 'new',
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('contact.create')->with('success', 'Message sent successfully!');
}

}
