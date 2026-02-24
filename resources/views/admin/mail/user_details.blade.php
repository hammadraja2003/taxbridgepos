<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #334155; margin: 0; padding: 0; background-color: #f8fafc; }
        .wrapper { background-color: #f8fafc; padding: 40px 20px; }
        .container { max-width: 600px; margin: 0 auto; border-radius: 12px; background-color: #ffffff; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .header { background-color: #5579a4; color: white; padding: 30px; text-align: center; }
        .header h2 { margin: 0; font-size: 24px; font-weight: 600; }
        .content { padding: 40px; }
        .welcome-text { font-size: 18px; font-weight: 500; color: #1e293b; margin-bottom: 16px; }
        .description { margin-bottom: 24px; color: #64748b; }
        .credentials { background-color: #f0f7ff; padding: 24px; border-radius: 8px; border-left: 4px solid #5579a4; margin: 24px 0; }
        .credential-item { margin-bottom: 12px; display: flex; }
        .credential-item:last-child { margin-bottom: 0; }
        .label { font-weight: 600; color: #475569; width: 130px; display: inline-block; }
        .value { color: #1e293b; font-family: 'Courier New', Courier, monospace; background: #fff; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0; }
        .btn-container { text-align: center; margin-top: 32px; }
        .btn { display: inline-block; padding: 14px 28px; background-color: #5579a4; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px; transition: background-color 0.2s; box-shadow: 0 4px 6px -1px rgba(85, 121, 164, 0.2); }
        .footer { padding: 24px; font-size: 13px; text-align: center; color: #94a3b8; border-top: 1px solid #f1f5f9; }
        .footer p { margin: 4px 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h2>Welcome to SalesBridge POS</h2>
            </div>
            <div class="content">
                <p class="welcome-text">Hello {{ $user_data->name }},</p>
                <p class="description">Your business database has been successfully set up. You can now access your account using the credentials provided below:</p>
                
                <div class="credentials">
                    <div class="credential-item">
                        <span class="label">Login Email:</span>
                        <span class="value">{{ $user_data->email }}</span>
                    </div>
                   
                    <div class="credential-item">
                        <span class="label">Database:</span>
                        <span class="value">{{ $user_data->db_name }}</span>
                    </div>
                    <div class="credential-item">
                        <span class="label">Database User:</span>
                        <span class="value">{{ $user_data->db_username ?? 'N/A' }}</span>
                    </div>
                    <div class="credential-item">
                        <span class="label">Database Pass:</span>
                        <span class="value">{{ $user_data->db_password ?? 'N/A' }}</span>
                    </div>
                </div>

                <p class="description">To get started, please click the button below to visit your dashboard:</p>
                
                <div class="btn-container">
                    <a href="{{ $user_data->login_url }}" class="btn">Login to Your Account</a>
                </div>
                
                <p class="description" style="margin-top: 32px; font-size: 14px;">If you didn't expect this email or need help, please reach out to our support team.</p>
            </div>
            <div class="footer">
                <p>&copy; {{ date('Y') }} SalesBridge POS. All rights reserved.</p>
                <p>Advanced Inventory & POS Management System</p>
            </div>
        </div>
    </div>
</body>
</html>
