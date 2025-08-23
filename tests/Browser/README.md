# Axtra Puppeteer Testing Suite

## Overview
Comprehensive Puppeteer testing suite for the Axtra.ch booking system, featuring automated authentication bypass for testing purposes.

## Features
- **ClaudeBypass Middleware**: Automatically logs in as test user (info@weboook.co.uk) with admin privileges
- **Comprehensive Testing**: Tests login, dashboard, booking flow, checkout, and responsive design
- **Visual Screenshots**: Captures screenshots for visual verification
- **Cross-Device Testing**: Tests multiple viewport sizes

## Installation

```bash
cd tests/Browser
npm install
```

## Usage

### Run Tests with Browser Visible
```bash
npm test
```

### Run Tests in Headless Mode
```bash
npm run test:headless
```

### Using Puppeteer MCP Tools
The system also supports using MCP Puppeteer tools for interactive testing:

1. Navigate to any page:
```javascript
// Navigate to login page
mcp__puppeteer__puppeteer_navigate({ url: "http://localhost:8000/login" })
```

2. Take screenshots:
```javascript
// Screenshot of current page
mcp__puppeteer__puppeteer_screenshot({ name: "current-page" })
```

3. Test with Claude bypass:
```javascript
// Navigate to test route that auto-logs in
mcp__puppeteer__puppeteer_navigate({ url: "http://localhost:8000/test/dashboard" })
```

## ClaudeBypass Middleware

The middleware automatically:
- Creates/finds test user: info@weboook.co.uk
- Grants admin role for comprehensive testing
- Works in testing environment or with X-Claude-Bypass header

### Test Routes
- `/test/dashboard` - Auto-login and redirect to dashboard
- `/test/user-info` - Returns current user info as JSON

## Test Coverage
- ✅ Login page layout and functionality
- ✅ Dashboard access and role-based redirects  
- ✅ Booking flow navigation
- ✅ Checkout system testing
- ✅ Responsive design validation
- ✅ Navigation menu testing

## Environment Setup
Ensure your Laravel app is running on localhost:8000 or set APP_URL environment variable.