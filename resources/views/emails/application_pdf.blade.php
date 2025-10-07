<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application #{{ $application->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .label { font-weight: bold; }
        .row { margin-bottom: 8px; }
    </style>
</head>
<body>
    <h2>New Application #{{ $application->id }}</h2>
    <div class="row"><span class="label">Submitted by:</span> {{ $user->name }} ({{ $user->email }})</div>
    <div class="row"><span class="label">Contact Email:</span> {{ $application->contact_email }}</div>
    <div class="row"><span class="label">Contact Phone:</span> {{ $application->contact_phone }}</div>
    <div class="row"><span class="label">Date of Birth:</span> {{ $application->date_of_birth?->format('Y-m-d') }}</div>
    <div class="row"><span class="label">Gender:</span> {{ $application->gender }}</div>
    <div class="row"><span class="label">Country:</span> {{ $application->country }}</div>
    <div class="row"><span class="label">Comments:</span> {!! nl2br(e($application->comments)) !!}</div>

    @if(!empty($application->files))
    <h3>Files</h3>
    <ul>
        @foreach($application->files as $file)
            <li>{{ basename($file) }}</li>
        @endforeach
    </ul>
    @endif
</body>
</html>
