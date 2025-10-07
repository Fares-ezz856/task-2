<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationSubmitted;
use Barryvdh\DomPDF\Facade\Pdf;


class ApplicationController extends Controller
{
    public function create()
    {
        return view('application.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact_email' => 'required|email',
            // if using propaganistas phone package: 'contact_phone' => 'required|phone:AUTO,US' or generic:
            'contact_phone' => ['required','string','max:32'],
            'date_of_birth' => 'required|date',
            'gender' => 'nullable|in:male,female,other',
            'country' => 'nullable|string|max:100',
            'files.*' => 'file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
            'comments' => 'nullable|string|max:2000',
        ]);

        $user = $request->user();

       
        $stored = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('uploads', 'public'); // storage/app/public/uploads
                $stored[] = $path;
            }
        }

        $application = Application::create([
            'user_id' => $user->id,
            'contact_email' => $request->input('contact_email'),
            'contact_phone' => $request->input('contact_phone'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'country' => $request->input('country'),
            'comments' => $request->input('comments'),
            'files' => $stored,
        ]);

       
        $pdf = PDF::loadView('emails.application_pdf', [
            'application' => $application,
            'user' => $user,
        ]);

       
        $adminEmail = config('mail.admin') ?? env('ADMIN_EMAIL');

      
        Mail::to($adminEmail)->send(new ApplicationSubmitted($application, $pdf->output()));

        return response()->json([
            'status' => 'success',
            'message' => 'Application submitted successfully.'
        ]);
    }
}

