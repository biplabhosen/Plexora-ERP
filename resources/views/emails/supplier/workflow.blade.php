<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f9fafb; padding:20px;">

<div style="max-width:600px;margin:auto;background:#ffffff;padding:20px;border-radius:10px;border:1px solid #eee;">

    <h2 style="color:#2563eb;">
        {{ $title }}
    </h2>

    <p style="font-size:14px;color:#333;line-height:1.6;">
        {!! nl2br(e($body)) !!}
    </p>

    @if(!empty($meta))
        <hr>
        <h4 style="margin-bottom:10px;">Details</h4>

        <table style="width:100%;font-size:13px;">
            @foreach($meta as $key => $value)
                <tr>
                    <td style="padding:5px 0;"><strong>{{ ucfirst($key) }}</strong></td>
                    <td style="padding:5px 0;">{{ $value }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <p style="margin-top:20px;font-size:12px;color:#888;">
        This is an automated supplier notification from the Workflow Automation System.
    </p>

</div>

</body>
</html>