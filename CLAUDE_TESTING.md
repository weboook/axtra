# Claude Testing Documentation

## Secure Authentication Bypass

For testing purposes, Claude can bypass authentication using a secure token.

### Usage with curl

```bash
# Test authentication status
curl -H "X-Claude-Token: claude_test_2024_secure_bypass_axtra" https://app.axtra.ch/test/auth-test

# Get user information
curl -H "X-Claude-Token: claude_test_2024_secure_bypass_axtra" https://app.axtra.ch/test/user-info

# Access dashboard (will redirect based on role)
curl -L -H "X-Claude-Token: claude_test_2024_secure_bypass_axtra" https://app.axtra.ch/test/dashboard

# Direct dashboard access
curl -H "X-Claude-Token: claude_test_2024_secure_bypass_axtra" https://app.axtra.ch/dashboard
```

### Alternative Headers

```bash
# Using X-Claude-Bypass header
curl -H "X-Claude-Bypass: claude_test_2024_secure_bypass_axtra" https://app.axtra.ch/test/auth-test

# Using URL parameter (less secure)
curl "https://app.axtra.ch/test/auth-test?claude_bypass=claude_test_2024_secure_bypass_axtra"
```

### Test User Details

The bypass creates/uses a test user with these credentials:
- **Email**: info@weboook.co.uk
- **Name**: Claude Test User
- **Role**: admin (for comprehensive testing)
- **Password**: testing123

### Security Notes

- Token is hardcoded in ClaudeBypass middleware
- Only works for Claude testing purposes
- Automatically creates admin user for full access testing
- Should not be used in production without proper security measures

### Available Test Routes

- `/test/auth-test` - Authentication status and bypass verification
- `/test/user-info` - Current user information
- `/test/dashboard` - Redirect to appropriate dashboard

### Response Format

```json
{
  "bypass_active": true,
  "authenticated": true,
  "session_id": "session_id_here",
  "user_id": 1,
  "timestamp": "2025-08-23T17:54:03.344547Z"
}
```