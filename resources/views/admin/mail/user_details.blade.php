<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; }
        .header { background-color: #4e73df; color: white; padding: 10px; border-radius: 10px 10px 0 0; text-align: center; }
        .content { padding: 20px; }
        .footer { font-size: 0.8em; text-align: center; color: #777; margin-top: 20px; }
        .credentials { background-color: #fff; padding: 15px; border-radius: 5px; border: 1px solid #eee; margin: 10px 0; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #4e73df; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Welcome to Your New Business Setup</h2>
        </div>
        <div class="content">
            <p>Hello {{ $user_data->name }},</p>
            <p>Your business database has been successfully cloned and set up. You can now log in to the system using the credentials below:</p>
            
            <div class="credentials">
                <strong>Login Email:</strong> {{ $user_data->email }}<br>
                <strong>Password:</strong> {{ $user_data->password }}<br>
                <strong>Database Name:</strong> {{ $user_data->db_name }}
            </div>

            <p>To get started, please click the button below to visit the login page:</p>
            <center>
                <a href="{{ $user_data->login_url }}" class="btn">Login to Your Account</a>
            </center>
            
            <p>If you have any questions or need assistance, please contact our support team.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} TaxBridge POS. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
