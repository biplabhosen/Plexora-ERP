<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f6f6f6; padding:20px;">

    <div style="max-width:600px;margin:auto;background:#fff;padding:20px;border-radius:10px;">

        <h2 style="color:#333;">{{ $title }}</h2>

        <p style="font-size:14px;color:#555;">
            {!! nl2br(e($body)) !!}
        </p>

        @if(!empty($meta))
            <hr>
            <h4>Details</h4>
            <ul>
                @foreach($meta as $key => $value)
                    <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                @endforeach
            </ul>
        @endif

        <p style="margin-top:20px;font-size:12px;color:#999;">
            This is an automated message from the system.
        </p>

    </div>

</body>
</html>