@extends('emails.layout', ['subject' => 'Reset Your Password'])

@section('content')
    <div class="greeting">Hello {{ $customerName }}!</div>
    
    <div class="content-text">
        You're receiving this email because we received a <strong>password reset request</strong> for your Axtra account.
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">🔐</span>
            Reset Your Password
        </div>
        <div class="content-text mb-0">
            Click the button below to reset your password. This link will expire in <strong>60 minutes</strong> for security reasons.
        </div>
    </div>

    <div class="text-center">
        <a href="{{ $resetUrl }}" class="action-button">Reset Password</a>
    </div>

    <div class="content-text">
        If you're having trouble clicking the button, copy and paste the URL below into your web browser:<br>
        <span style="color: #6c757d; font-size: 14px; word-break: break-all;">{{ $resetUrl }}</span>
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">⚠️</span>
            Security Notice
        </div>
        <div class="content-text mb-0">
            <strong>If you didn't request a password reset</strong>, no further action is required. Your password will remain unchanged and this link will expire automatically.<br><br>
            
            For security reasons, please:
            <br>• Don't share this email with anyone
            <br>• Use a strong, unique password
            <br>• Log out of all devices after changing your password
        </div>
    </div>

    <div class="content-text text-center">
        <strong>Need help?</strong><br>
        If you continue to have problems, please contact our support team.
    </div>
@endsection