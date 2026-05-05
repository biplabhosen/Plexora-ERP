<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">

<div style="max-width:600px;margin:auto;background:#fff;padding:20px;border-radius:8px;">

    <h2 style="color:#e11d48;">
        {{ $title }}
    </h2>

    <p style="font-size:14px;color:#333;">
        {!! nl2br(e($body)) !!}
    </p>

    @if(!empty($meta))
        <hr>
        <h4>Details</h4>
        <ul>
            @foreach($meta as $key => $value)
                <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
            @endforeach
        </ul>
    @endif

    <p style="margin-top:20px;font-size:12px;color:#888;">
        This is an automated system notification from Workflow Engine.
    </p>

</div>

</body>
</html>