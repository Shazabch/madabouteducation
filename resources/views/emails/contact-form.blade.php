<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New enquiry recieved</title>
</head>
<body>
    <table style="width: 100%; max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; background-color: #f4f4f4;">
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #3498db; color: #fff;">
                <h2>New Enquiry</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p><strong>Name:</strong> {{ $name }}</p>
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Phone:</strong> {{ $phone }}</p>
                <p><strong>Subject:</strong> {{ $subject }}</p>
                <p><strong>Comments:</strong></p>
                <p>{{ $comments }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #93c845; color: #fff;">
                <p>&copy; {{ date('Y') }} Mad About Education</p>
            </td>
        </tr>
    </table>
</body>
</html>
