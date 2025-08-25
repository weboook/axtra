<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $subject ?? 'Axtra Urban Axe Throwing' }}</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Base */
        body {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #1b1b1b;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        /* Container */
        .email-wrapper {
            width: 100%;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 0;
            min-height: 100vh;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        /* Header */
        .email-header {
            background: #1b1b1b;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .logo {
            max-width: 180px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 15px;
        }
        
        .email-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        /* Content */
        .email-body {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #c02425;
            margin-bottom: 20px;
        }
        
        .content-text {
            font-size: 16px;
            color: #495057;
            margin-bottom: 20px;
            line-height: 1.7;
        }
        
        .content-text strong {
            color: #1b1b1b;
            font-weight: 600;
        }
        
        /* Action Button */
        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, #c02425 0%, #a01f20 100%);
            color: white !important;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: transform 0.2s ease;
            box-shadow: 0 4px 12px rgba(192, 36, 37, 0.3);
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(192, 36, 37, 0.4);
        }
        
        /* Info Box */
        .info-box {
            background: rgba(192, 36, 37, 0.05);
            border: 1px solid rgba(192, 36, 37, 0.2);
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .info-box-title {
            font-weight: 600;
            color: #c02425;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .info-box-title .icon {
            margin-right: 8px;
            font-size: 16px;
        }
        
        /* Details Table */
        .details-table {
            width: 100%;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .details-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .details-row:last-child {
            border-bottom: none;
            font-weight: 600;
            color: #c02425;
            font-size: 18px;
        }
        
        .details-label {
            font-weight: 600;
            color: #495057;
        }
        
        .details-value {
            color: #1b1b1b;
        }
        
        /* Footer */
        .email-footer {
            background: #1b1b1b;
            color: #adb5bd;
            padding: 30px;
            text-align: center;
        }
        
        .footer-logo {
            max-width: 120px;
            height: 50px;
            object-fit: contain;
            margin-bottom: 15px;
            opacity: 0.8;
        }
        
        .footer-text {
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .footer-links {
            margin-top: 20px;
        }
        
        .footer-links a {
            color: #c02425;
            text-decoration: none;
            margin: 0 15px;
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            .email-wrapper {
                padding: 10px;
            }
            
            .email-header,
            .email-body,
            .email-footer {
                padding: 20px;
            }
            
            .email-title {
                font-size: 20px;
            }
            
            .greeting {
                font-size: 18px;
            }
            
            .content-text {
                font-size: 15px;
            }
            
            .details-table {
                padding: 15px;
            }
        }
        
        /* Utility Classes */
        .text-center { text-align: center; }
        .mb-0 { margin-bottom: 0 !important; }
        .mt-20 { margin-top: 20px; }
        .text-success { color: #28a745; }
        .text-warning { color: #ffc107; }
        .text-danger { color: #dc3545; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <img src="{{ asset('images/brand/axtra-full.png') }}" alt="Axtra Urban Axe Throwing" class="logo" style="max-height:80px;margin:auto;">
                <h1 class="email-title">{{ $subject ?? 'Axtra Urban Axe Throwing' }}</h1>
            </div>
            
            <!-- Body -->
            <div class="email-body">
                @yield('content')
            </div>
            
            <!-- Footer -->
            <div class="email-footer">
                <img src="{{ asset('images/brand/axtra-icon.png') }}" alt="Axtra" class="footer-logo" style="max-height:50px;margin:auto;">
                <div class="footer-text">
                    <strong>Axtra Urban Axe Throwing</strong><br>
                    Bahnhofstrasse 123, 8001 Zürich, Switzerland<br>
                    Phone: +41 44 123 45 67 | Email: info@axtra.ch
                </div>
                <div class="footer-links">
                    <a href="{{ config('app.url') }}">Visit Website</a>
                    <a href="{{ config('app.url') }}/contact">Contact Us</a>
                    <a href="{{ config('app.url') }}/terms">Terms</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>