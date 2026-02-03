<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

class ContactController extends Controller
{
    /**
     * Display the contact form.
     */
    public function index()
    {
        // Get contact settings if available
        $email = Setting::getValue('contact_email', 'contact@bookty.com');
        $phone = Setting::getValue('contact_phone', '+60 123 456 789');
        $address = Setting::getValue('contact_address', '123 Book Street, Reading Town, 54321');
        
        return view('contact.index', compact('email', 'phone', 'address'));
    }

    /**
     * Handle contact form submission.
     */
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Logic to send email would go here
        // Mail::to(config('mail.from.address'))->send(new ContactFormMail($request->all()));

        return back()->with('success', 'Thank you for contacting us! We will get back to you shortly.');
    }
}

