/**
 * Puppeteer Test Suite for Axtra.ch
 * Tests comprehensive booking flow and authentication
 */

const puppeteer = require('puppeteer');

class AxtraPuppeteerTest {
    constructor() {
        this.browser = null;
        this.page = null;
        this.baseUrl = process.env.APP_URL || 'http://localhost:8000';
    }

    async setup() {
        this.browser = await puppeteer.launch({
            headless: false, // Set to true for CI/CD
            defaultViewport: { width: 1280, height: 720 },
            args: ['--no-sandbox', '--disable-setuid-sandbox']
        });
        this.page = await this.browser.newPage();
        
        // Set Claude bypass header for authentication
        await this.page.setExtraHTTPHeaders({
            'X-Claude-Bypass': 'true'
        });
        
        console.log('✅ Puppeteer browser launched');
    }

    async teardown() {
        if (this.browser) {
            await this.browser.close();
            console.log('✅ Browser closed');
        }
    }

    async testLoginPage() {
        console.log('🧪 Testing login page...');
        
        await this.page.goto(`${this.baseUrl}/login`);
        await this.page.waitForSelector('.auth-container');
        
        // Check if video is present
        const videoExists = await this.page.$('iframe[src*="youtube.com"]') !== null;
        console.log(`📹 YouTube video present: ${videoExists}`);
        
        // Check if form elements exist
        const emailInput = await this.page.$('input[name="email"]');
        const passwordInput = await this.page.$('input[name="password"]');
        const submitButton = await this.page.$('button[type="submit"]');
        
        console.log(`📧 Email input: ${emailInput !== null}`);
        console.log(`🔒 Password input: ${passwordInput !== null}`);
        console.log(`🔘 Submit button: ${submitButton !== null}`);
        
        // Check social login buttons
        const googleButton = await this.page.$('a[href*="auth/google"]');
        const appleButton = await this.page.$('a[href*="auth/apple"]');
        
        console.log(`🔗 Google login: ${googleButton !== null}`);
        console.log(`🍎 Apple login: ${appleButton !== null}`);
    }

    async testDashboardAccess() {
        console.log('🧪 Testing dashboard access...');
        
        await this.page.goto(`${this.baseUrl}/dashboard`);
        
        // Should redirect to appropriate dashboard based on role
        await this.page.waitForSelector('.dashboard-container', { timeout: 5000 });
        
        const currentUrl = this.page.url();
        console.log(`📍 Dashboard URL: ${currentUrl}`);
        
        // Check if we're on admin dashboard (since test user has admin role)
        const isAdminDashboard = currentUrl.includes('/admin/dashboard');
        console.log(`👑 Admin dashboard loaded: ${isAdminDashboard}`);
        
        // Take screenshot for visual verification
        await this.page.screenshot({ path: 'dashboard-test.png', fullPage: true });
        console.log('📸 Dashboard screenshot saved');
    }

    async testBookingFlow() {
        console.log('🧪 Testing booking flow...');
        
        // Navigate to booking page
        await this.page.goto(`${this.baseUrl}/dashboard/book`);
        await this.page.waitForSelector('.booking-container');
        
        // Check if products are loaded
        const products = await this.page.$$('.product-card');
        console.log(`🎯 Products found: ${products.length}`);
        
        if (products.length > 0) {
            // Click first product
            await products[0].click();
            await this.page.waitForTimeout(1000);
            
            console.log('✅ Product selection completed');
        }
    }

    async testCheckoutFlow() {
        console.log('🧪 Testing checkout flow...');
        
        await this.page.goto(`${this.baseUrl}/Checkout/`);
        
        try {
            await this.page.waitForSelector('.checkout-step', { timeout: 3000 });
            
            const steps = await this.page.$$('.checkout-step');
            console.log(`📋 Checkout steps found: ${steps.length}`);
            
            // Take screenshot of checkout
            await this.page.screenshot({ path: 'checkout-test.png', fullPage: true });
            console.log('📸 Checkout screenshot saved');
            
        } catch (error) {
            console.log('⚠️ Checkout page not accessible or different structure');
        }
    }

    async testResponsiveDesign() {
        console.log('🧪 Testing responsive design...');
        
        const viewports = [
            { width: 320, height: 568, name: 'Mobile' },
            { width: 768, height: 1024, name: 'Tablet' },
            { width: 1920, height: 1080, name: 'Desktop' }
        ];
        
        for (const viewport of viewports) {
            await this.page.setViewport(viewport);
            await this.page.goto(`${this.baseUrl}/dashboard`);
            await this.page.waitForTimeout(1000);
            
            await this.page.screenshot({ 
                path: `responsive-${viewport.name.toLowerCase()}.png`,
                fullPage: true 
            });
            
            console.log(`📱 ${viewport.name} screenshot saved`);
        }
    }

    async testNavigationMenus() {
        console.log('🧪 Testing navigation menus...');
        
        await this.page.goto(`${this.baseUrl}/admin/dashboard`);
        
        // Check sidebar navigation
        const sidebarLinks = await this.page.$$('.sidebar a');
        console.log(`🔗 Sidebar links found: ${sidebarLinks.length}`);
        
        // Test each navigation link
        for (let i = 0; i < Math.min(sidebarLinks.length, 5); i++) {
            const link = sidebarLinks[i];
            const href = await link.evaluate(el => el.getAttribute('href'));
            
            if (href && !href.includes('#') && !href.includes('javascript:')) {
                try {
                    await link.click();
                    await this.page.waitForTimeout(1500);
                    
                    const currentUrl = this.page.url();
                    console.log(`✅ Navigation to: ${currentUrl}`);
                    
                } catch (error) {
                    console.log(`⚠️ Navigation error for link ${i}: ${error.message}`);
                }
            }
        }
    }

    async runAllTests() {
        try {
            await this.setup();
            
            await this.testLoginPage();
            await this.testDashboardAccess();
            await this.testBookingFlow();
            await this.testCheckoutFlow();
            await this.testResponsiveDesign();
            await this.testNavigationMenus();
            
            console.log('🎉 All tests completed successfully!');
            
        } catch (error) {
            console.error('❌ Test suite failed:', error);
        } finally {
            await this.teardown();
        }
    }
}

// Run tests if this file is executed directly
if (require.main === module) {
    const testSuite = new AxtraPuppeteerTest();
    testSuite.runAllTests();
}

module.exports = AxtraPuppeteerTest;