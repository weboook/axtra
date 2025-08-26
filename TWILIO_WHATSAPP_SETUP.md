# Twilio WhatsApp Integration Setup

This document explains how to set up and use the Twilio WhatsApp integration for Axtra.

## Setup Steps

### 1. Twilio Account Setup
1. Create a Twilio account at https://www.twilio.com
2. Get your Account SID and Auth Token from the Twilio Console
3. Set up WhatsApp Business API through Twilio
4. Get your WhatsApp-enabled phone number

### 2. Environment Configuration
Add these variables to your `.env` file:

```env
# Twilio Configuration
TWILIO_SID=your_twilio_account_sid_here
TWILIO_AUTH_TOKEN=your_twilio_auth_token_here
TWILIO_PHONE_NUMBER=your_twilio_phone_number_here
TWILIO_WHATSAPP_NUMBER=whatsapp:+your_twilio_whatsapp_number_here
TWILIO_VERIFY_SERVICE_SID=your_twilio_verify_service_sid_here
```

### 3. Webhook Configuration
Configure these webhook URLs in your Twilio Console:

**Status Callback URL:** `https://app.axtra.ch/api/v1/twilio/webhook`
**Incoming Message URL:** `https://app.axtra.ch/api/v1/twilio/incoming`

## Testing

### Test WhatsApp Message
```bash
php artisan whatsapp:test +41791234567 --message="Hello from Axtra!"
```

### Test Template Message
```bash
php artisan whatsapp:test +41791234567 --template=welcome
```

## API Endpoints

### Send WhatsApp Message
```http
POST /api/v1/notifications/whatsapp
Authorization: Bearer {token}
Content-Type: application/json

{
  "user_id": 1,
  "message": "Hello! Your booking is confirmed.",
  "template": null,
  "parameters": []
}
```

### Send Booking Confirmation
```http
POST /api/v1/notifications/booking-confirmation
Authorization: Bearer {token}
Content-Type: application/json

{
  "booking_id": 123
}
```

### Send Reminder
```http
POST /api/v1/notifications/reminder
Authorization: Bearer {token}
Content-Type: application/json

{
  "booking_id": 123,
  "hours_before": 50
}
```

### Bulk Send Messages
```http
POST /api/v1/admin/notifications/bulk-send
Authorization: Bearer {token}
Content-Type: application/json

{
  "user_ids": [1, 2, 3],
  "message": "Important update from Axtra!",
  "template": null,
  "parameters": []
}
```

### Get Message Status
```http
GET /api/v1/notifications/status?message_sid=SM1234567890abcdef
Authorization: Bearer {token}
```

## Available Templates

### 1. Booking Confirmation
- **Name:** `booking_confirmation`
- **Parameters:** `customer_name`, `service_name`, `booking_date`
- **Usage:** Sent when a booking is confirmed

### 2. 50-Hour Reminder
- **Name:** `reminder_50_hours`
- **Parameters:** `customer_name`, `service_name`, `booking_date`
- **Usage:** Sent 50 hours before the event

### 3. 2-Hour Reminder
- **Name:** `reminder_2_hours`
- **Parameters:** `customer_name`, `service_name`, `booking_date`
- **Usage:** Sent 2 hours before the event

### 4. Welcome Message
- **Name:** `welcome`
- **Parameters:** `customer_name`
- **Usage:** Sent to new users

## Webhook Handling

The system handles several webhook events:

### Message Status Updates
- `delivered` - Message successfully delivered
- `failed` - Message failed to deliver
- `read` - Message was read by recipient
- `sent` - Message sent to WhatsApp

### Incoming Messages
The system automatically handles:
- **STOP/UNSUBSCRIBE** - Unsubscribes user from notifications
- **START/SUBSCRIBE** - Resubscribes user to notifications
- **HELP/INFO** - Sends help information

## Rate Limiting

Default rate limits:
- **Per minute:** 60 messages
- **Per hour:** 1,000 messages
- **Per day:** 10,000 messages

Configure in `config/twilio.php`.

## Logging

All WhatsApp activities are logged to Laravel's logging system:
- Message sending attempts
- Webhook events
- Errors and failures
- User subscription changes

## Integration with Booking System

The WhatsApp service integrates automatically with the booking system:

1. **Booking Confirmation** - Sent when a booking is paid/confirmed
2. **Event Reminders** - Automated reminders via cron jobs
3. **Review Requests** - Sent after event completion

## Commands

### Send Test Message
```bash
php artisan whatsapp:test {phone} {--message=} {--template=}
```

### Send Booking Reminders (Cron Job)
```bash
php artisan booking:send-reminders
```

### Send Test Emails (includes WhatsApp)
```bash
php artisan email:send-tests
```

## Troubleshooting

### Common Issues

1. **"Twilio credentials not configured"**
   - Check your `.env` file has correct Twilio variables
   - Ensure no spaces in the credentials

2. **"Rate limit exceeded"**
   - Check rate limiting configuration
   - Wait before sending more messages

3. **"No phone number available"**
   - Ensure users have phone numbers in their profiles
   - Check guest booking phone number fields

4. **Messages not delivered**
   - Check Twilio console for detailed error messages
   - Verify WhatsApp number format (+country code)
   - Ensure WhatsApp is enabled for your Twilio number

### Debug Mode
Enable detailed logging by setting in `.env`:
```env
TWILIO_LOGGING_ENABLED=true
TWILIO_LOG_LEVEL=debug
```

## Security

- All webhook signatures are validated
- Phone numbers are formatted and sanitized
- Rate limiting prevents abuse
- User preferences are respected (opt-out support)

## Support

For issues with the WhatsApp integration:
1. Check Laravel logs (`storage/logs/laravel.log`)
2. Check Twilio console for delivery status
3. Test with the provided commands
4. Verify webhook configuration in Twilio