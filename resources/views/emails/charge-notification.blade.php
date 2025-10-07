<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Charge Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f9fc; color: #333; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 30px;">
        <h2 style="color: #0d6efd; border-bottom: 1px solid #e3e3e3; padding-bottom: 10px;">🧾 New Charge Transaction</h2>

        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">👤 Member:</td>
                <td>{{ $charge->member->name }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">🏢 Department:</td>
                <td>{{ $charge->department->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">📝 Description:</td>
                <td>{{ $charge->description }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">💰 Amount:</td>
                <td>₱{{ number_format($charge->price, 2) }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">📅 Date:</td>
                <td>{{ \Carbon\Carbon::parse($charge->charge_datetime)->format('F d, Y') }}</td>
            </tr>
        </table>

        <p style="margin-top: 30px; font-size: 14px; color: #777;">This message was sent by the <strong>CREDiT System</strong> of Central Philippine Adventist College.</p>
    </div>
</body>
</html>
