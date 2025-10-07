@component('mail::message')
# New Application Submitted

A new application has been submitted by **{{ $user->name }} ({{ $user->email }})**.

**Contact Email:** {{ $application->contact_email }}
**Contact Phone:** {{ $application->contact_phone }}
**DOB:** {{ $application->date_of_birth?->format('Y-m-d') }}
**Gender:** {{ $application->gender }}
**Country:** {{ $application->country }}

Comments:
{{ $application->comments }}

The submitted data is attached as a PDF, and uploaded files are attached as well.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
