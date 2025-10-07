<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;

class ApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    protected $pdfBytes;

    public function __construct(Application $application, $pdfBytes)
    {
        $this->application = $application;
        $this->pdfBytes = $pdfBytes;
    }

    public function build()
    {
        $email = $this->subject('New Application Submitted')
                      ->markdown('emails.application_notification')
                      ->with([
                          'application' => $this->application,
                          'user' => $this->application->user,
                      ]);

        
        if (!empty($this->application->files) && is_array($this->application->files)) {
            foreach ($this->application->files as $path) {
                $email->attach(storage_path("app/public/{$path}"));
            }
        }

        
        $email->attachData($this->pdfBytes, 'application.pdf', [
            'mime' => 'application/pdf',
        ]);

        return $email;
    }
}
