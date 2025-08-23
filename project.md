Axtra.ch - Complete Technical Specifications
Project Overview
Framework: Laravel 12 with Livewire 3.6 & Jetstream
 Frontend: Bootstrap 5.3 + Material Icons
 Authentication: Jetstream with Google & Apple OAuth
 Database: MySQL 8.0
 Server: Swiss-based hosting

1. Database Structure & Schema
Users & Authentication
-- Users table (extended Jetstream)
users
├── id (primary key)
├── name
├── email
├── email_verified_at
├── password (nullable for OAuth users)
├── phone
├── date_of_birth
├── profile_photo_path
├── role (enum: admin, employee, customer)
├── total_bookings (default: 0)
├── total_spent (decimal: 10,2, default: 0.00)
├── skill_level (enum: bronze, silver, gold, platinum)
├── skill_points (default: 0)
├── whatsapp_notifications (boolean, default: true)
├── remember_token
├── current_team_id
├── created_at
├── updated_at

-- OAuth providers
oauth_providers
├── id
├── user_id (foreign key)
├── provider (enum: google, apple)
├── provider_id
├── provider_token
├── provider_refresh_token
├── created_at
├── updated_at
Booking System
-- Products/Services
products
├── id
├── name
├── description
├── price (decimal: 8,2)
├── max_players
├── min_players
├── duration_minutes
├── is_active (boolean)
├── sort_order
├── created_at
├── updated_at

-- Time slots
time_slots
├── id
├── date
├── start_time
├── end_time
├── lane_id (foreign key)
├── max_capacity
├── current_bookings (default: 0)
├── is_available (boolean)
├── created_at
├── updated_at

-- Lanes management
lanes
├── id
├── name
├── is_active (boolean)
├── maintenance_status (enum: operational, maintenance, damaged)
├── last_maintenance
├── created_at
├── updated_at

-- Bookings
bookings
├── id
├── user_id (foreign key)
├── product_id (foreign key)
├── time_slot_id (foreign key)
├── booking_reference (unique)
├── player_count
├── total_amount (decimal: 10,2)
├── status (enum: pending, confirmed, completed, cancelled)
├── payment_status (enum: pending, paid, refunded)
├── payment_reference
├── special_requests (text)
├── created_at
├── updated_at

-- Booking participants
booking_participants
├── id
├── booking_id (foreign key)
├── participant_name
├── participant_email (nullable)
├── is_primary_booker (boolean)
├── created_at
├── updated_at
Upsells & Add-ons
-- Upsells
upsells
├── id
├── name
├── description
├── price (decimal: 8,2)
├── type (enum: per_person, per_booking, fixed)
├── auto_detect_players (boolean)
├── is_active (boolean)
├── created_at
├── updated_at

-- Booking upsells
booking_upsells
├── id
├── booking_id (foreign key)
├── upsell_id (foreign key)
├── quantity
├── unit_price (decimal: 8,2)
├── total_price (decimal: 8,2)
├── created_at
├── updated_at
Performance & Scoring
-- Game sessions
game_sessions
├── id
├── booking_id (foreign key)
├── lane_id (foreign key)
├── start_time
├── end_time
├── total_throws
├── session_status (enum: active, completed, paused)
├── created_at
├── updated_at

-- Player scores
player_scores
├── id
├── game_session_id (foreign key)
├── user_id (foreign key, nullable)
├── player_name
├── total_score
├── throws_count
├── bullseyes
├── accuracy_percentage (decimal: 5,2)
├── position_rank
├── created_at
├── updated_at

-- Individual throws
throws
├── id
├── player_score_id (foreign key)
├── throw_number
├── score_points
├── target_zone (enum: bullseye, inner, middle, outer, miss)
├── created_at
├── updated_at
Equipment Management
-- Equipment
equipment
├── id
├── type (enum: axe, block, lane_equipment)
├── name
├── lane_id (foreign key, nullable)
├── status (enum: good, damaged, replaced, maintenance)
├── last_inspection
├── replacement_date (nullable)
├── notes (text)
├── created_at
├── updated_at

-- Equipment history
equipment_history
├── id
├── equipment_id (foreign key)
├── user_id (foreign key)
├── action (enum: damaged, replaced, repaired, inspected)
├── notes (text)
├── created_at
├── updated_at
Coupons & Promotions
-- Coupons
coupons
├── id
├── code (unique)
├── name
├── description
├── discount_type (enum: percentage, fixed_amount)
├── discount_value (decimal: 8,2)
├── minimum_amount (decimal: 8,2, nullable)
├── usage_limit (nullable)
├── used_count (default: 0)
├── starts_at
├── expires_at
├── is_active (boolean)
├── created_at
├── updated_at

-- Coupon usage
coupon_usage
├── id
├── coupon_id (foreign key)
├── user_id (foreign key)
├── booking_id (foreign key)
├── discount_applied (decimal: 8,2)
├── created_at
├── updated_at
Gift Cards
-- Gift cards
gift_cards
├── id
├── code (unique)
├── initial_amount (decimal: 10,2)
├── current_balance (decimal: 10,2)
├── purchased_by (foreign key users)
├── recipient_email
├── recipient_name
├── message (text, nullable)
├── expires_at
├── is_active (boolean)
├── created_at
├── updated_at

-- Gift card transactions
gift_card_transactions
├── id
├── gift_card_id (foreign key)
├── booking_id (foreign key, nullable)
├── amount (decimal: 10,2)
├── type (enum: purchase, redemption, refund)
├── description
├── created_at
├── updated_at
Notifications
-- Notifications
notifications
├── id
├── user_id (foreign key)
├── type (enum: booking_confirmation, reminder, promotion, system)
├── title
├── message
├── data (json)
├── read_at (nullable)
├── whatsapp_sent (boolean, default: false)
├── whatsapp_sent_at (nullable)
├── created_at
├── updated_at

2. Laravel Folder Structure
app/
├── Console/
├── Exceptions/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── BookingController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── UserController.php
│   │   │   └── ChatbotController.php
│   │   ├── Auth/
│   │   │   ├── GoogleController.php
│   │   │   └── AppleController.php
│   │   ├── Customer/
│   │   │   └── LeaderboardController.php
│   │   ├── Payment/
│   │   │   └── PayRexxController.php
│   │   └── WebflowController.php (for webhook handling)
│   ├── Middleware/
│   │   ├── CheckRole.php
│   │   ├── CheckBookingOwnership.php
│   │   └── AdminOrEmployee.php
│   ├── Requests/
│   │   ├── BookingRequest.php
│   │   ├── ProductRequest.php
│   │   ├── CouponRequest.php
│   │   └── UserRequest.php
│   └── Resources/
│       ├── BookingResource.php
│       ├── UserResource.php
│       └── ProductResource.php
├── Livewire/
│   ├── Admin/
│   │   ├── Dashboard/
│   │   │   └── DashboardIndex.php
│   │   ├── Users/
│   │   │   ├── UsersList.php
│   │   │   ├── UserDetails.php
│   │   │   └── UserFilters.php
│   │   ├── Products/
│   │   │   ├── ProductsList.php
│   │   │   ├── ProductForm.php
│   │   │   └── ProductManagement.php
│   │   ├── Coupons/
│   │   │   ├── CouponsList.php
│   │   │   ├── CouponForm.php
│   │   │   └── CouponUsage.php
│   │   ├── Lanes/
│   │   │   ├── LanesList.php
│   │   │   ├── LaneHistory.php
│   │   │   └── LaneManagement.php
│   │   ├── Employees/
│   │   │   ├── EmployeesList.php
│   │   │   └── EmployeeForm.php
│   │   └── GiftCards/
│   │       ├── GiftCardsList.php
│   │       ├── GiftCardForm.php
│   │       └── GiftCardTransactions.php
│   ├── Employee/
│   │   ├── Dashboard/
│   │   │   └── DashboardIndex.php
│   │   ├── QuickActions/
│   │   │   ├── LaneStatus.php
│   │   │   └── EquipmentReport.php
│   │   └── Schedule/
│   │       ├── BookingCalendar.php
│   │       └── ScheduleOverview.php
│   ├── User/
│   │   ├── Dashboard/
│   │   │   └── DashboardIndex.php
│   │   ├── Booking/
│   │   │   ├── BookingHistory.php
│   │   │   ├── BookingForm.php
│   │   │   ├── TimeSlotSelector.php
│   │   │   ├── PlayerSelector.php
│   │   │   └── CheckoutForm.php
│   │   ├── Profile/
│   │   │   ├── ProfileSettings.php
│   │   │   ├── NotificationSettings.php
│   │   │   └── PerformanceStats.php
│   │   ├── Leaderboard/
│   │   │   ├── GlobalLeaderboard.php
│   │   │   └── PersonalStats.php
│   │   └── Notifications/
│   │       ├── NotificationsList.php
│   │       └── NotificationSettings.php
│   ├── Public/
│   │   ├── Home/
│   │   │   ├── HeroSection.php
│   │   │   ├── ReviewsSection.php
│   │   │   └── BookingWidget.php
│   │   ├── Booking/
│   │   │   ├── PublicBookingForm.php
│   │   │   └── GiftCardPurchase.php
│   │   ├── Pages/
│   │   │   ├── TeamEvents.php
│   │   │   ├── FAQ.php
│   │   │   └── About.php
│   │   └── Chatbot/
│   │       └── ChatbotWidget.php
│   └── Shared/
│       ├── Components/
│       │   ├── Modal.php
│       │   ├── DataTable.php
│       │   ├── DatePicker.php
│       │   └── SearchFilter.php
│       └── Traits/
│           ├── WithPagination.php
│           ├── WithSorting.php
│           └── WithFiltering.php
├── Models/
│   ├── User.php
│   ├── Booking.php
│   ├── Product.php
│   ├── TimeSlot.php
│   ├── Lane.php
│   ├── BookingParticipant.php
│   ├── Upsell.php
│   ├── BookingUpsell.php
│   ├── GameSession.php
│   ├── PlayerScore.php
│   ├── Throw.php
│   ├── Equipment.php
│   ├── EquipmentHistory.php
│   ├── Coupon.php
│   ├── CouponUsage.php
│   ├── GiftCard.php
│   ├── GiftCardTransaction.php
│   ├── OAuthProvider.php
│   └── Notification.php
├── Services/
│   ├── BookingService.php
│   ├── PaymentService.php
│   ├── NotificationService.php
│   ├── WhatsAppService.php
│   ├── OpenAIService.php
│   ├── PayRexxService.php
│   ├── LeaderboardService.php
│   └── WebflowService.php
├── Jobs/
│   ├── SendBookingConfirmation.php
│   ├── SendWhatsAppNotification.php
│   ├── ProcessPayment.php
│   └── UpdateWebflowData.php
├── Events/
│   ├── BookingCreated.php
│   ├── PaymentCompleted.php
│   ├── ScoreRecorded.php
│   └── EquipmentStatusChanged.php
├── Listeners/
│   ├── SendBookingNotification.php
│   ├── UpdateUserStats.php
│   ├── ProcessLevelUp.php
│   └── LogEquipmentChange.php
└── Providers/
    ├── AppServiceProvider.php
    ├── RouteServiceProvider.php
    └── EventServiceProvider.php

resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php (Dashboard layout)
│   │   ├── guest.blade.php
│   │   └── navigation-menu.blade.php
│   ├── livewire/
│   │   ├── admin/
│   │   ├── employee/
│   │   ├── user/
│   │   ├── public/
│   │   └── shared/
│   ├── auth/
│   │   ├── login.blade.php
│   │   ├── register.blade.php
│   │   └── oauth-callback.blade.php
│   ├── emails/
│   │   ├── booking-confirmation.blade.php
│   │   ├── payment-receipt.blade.php
│   │   └── gift-card-purchased.blade.php
│   └── errors/
├── js/
│   ├── app.js
│   ├── bootstrap.js
│   ├── dashboard.js
│   ├── booking.js
│   └── chatbot.js
├── css/
│   ├── app.css
│   └── dashboard.css
└── lang/

3. Models with Relationships
User Model
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;

class User extends Authenticatable
{
    use HasFactory, HasProfilePhoto, HasTeams;

    protected $fillable = [
        'name', 'email', 'phone', 'date_of_birth', 'role', 
        'total_bookings', 'total_spent', 'skill_level', 
        'skill_points', 'whatsapp_notifications'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'total_spent' => 'decimal:2',
        'whatsapp_notifications' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function playerScores()
    {
        return $this->hasMany(PlayerScore::class);
    }

    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function giftCardsPurchased()
    {
        return $this->hasMany(GiftCard::class, 'purchased_by');
    }

    // Scopes
    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    public function scopeEmployees($query)
    {
        return $query->where('role', 'employee');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // Accessors & Mutators
    public function getAverageScoreAttribute()
    {
        return $this->playerScores()->avg('total_score') ?? 0;
    }

    public function getSkillLevelProgressAttribute()
    {
        $levels = ['bronze' => 100, 'silver' => 500, 'gold' => 1500, 'platinum' => 5000];
        $currentLevel = $levels[$this->skill_level] ?? 0;
        $nextLevel = collect($levels)->where('>', $currentLevel)->first() ?? $currentLevel;
        
        return [
            'current' => $this->skill_points,
            'required' => $nextLevel,
            'percentage' => $nextLevel > 0 ? min(100, ($this->skill_points / $nextLevel) * 100) : 100
        ];
    }
}
Booking Model
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'time_slot_id', 'booking_reference',
        'player_count', 'total_amount', 'status', 'payment_status',
        'payment_reference', 'special_requests'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function participants()
    {
        return $this->hasMany(BookingParticipant::class);
    }

    public function upsells()
    {
        return $this->hasMany(BookingUpsell::class);
    }

    public function gameSession()
    {
        return $this->hasOne(GameSession::class);
    }

    // Boot method for generating booking reference
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            $booking->booking_reference = 'AXT-' . strtoupper(uniqid());
        });
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    // Accessors
    public function getTotalWithUpsellsAttribute()
    {
        return $this->total_amount + $this->upsells->sum('total_price');
    }
}

4. Livewire Component Examples
Admin Dashboard Index
<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Booking;
use App\Models\Product;
use Carbon\Carbon;

class DashboardIndex extends Component
{
    public $userStats = [];
    public $bookingStats = [];
    public $revenueStats = [];
    public $topProducts = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->userStats = [
            'total' => User::customers()->count(),
            'new_this_month' => User::customers()->whereBetween('created_at', [
                Carbon::now()->startOfMonth(), 
                Carbon::now()->endOfMonth()
            ])->count(),
            'active_this_month' => User::customers()->whereHas('bookings', function($query) {
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(), 
                    Carbon::now()->endOfMonth()
                ]);
            })->count()
        ];

        $this->bookingStats = [
            'total_today' => Booking::whereDate('created_at', Carbon::today())->count(),
            'confirmed_today' => Booking::confirmed()->whereDate('created_at', Carbon::today())->count(),
            'total_this_month' => Booking::whereBetween('created_at', [
                Carbon::now()->startOfMonth(), 
                Carbon::now()->endOfMonth()
            ])->count()
        ];

        $this->revenueStats = [
            'today' => Booking::paid()->whereDate('created_at', Carbon::today())->sum('total_amount'),
            'this_month' => Booking::paid()->whereBetween('created_at', [
                Carbon::now()->startOfMonth(), 
                Carbon::now()->endOfMonth()
            ])->sum('total_amount')
        ];

        $this->topProducts = Product::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dashboard-index')
            ->layout('layouts.app');
    }
}
User Dashboard Index
<?php

namespace App\Livewire\User\Dashboard;

use Livewire\Component;
use App\Models\Booking;
use App\Models\PlayerScore;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DashboardIndex extends Component
{
    public $upcomingBookings = [];
    public $recentScores = [];
    public $notifications = [];
    public $userStats = [];
    public $leaderboardPosition;

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $user = Auth::user();

        $this->upcomingBookings = Booking::where('user_id', $user->id)
            ->with(['product', 'timeSlot'])
            ->where('status', 'confirmed')
            ->whereHas('timeSlot', function($query) {
                $query->where('date', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $this->recentScores = PlayerScore::where('user_id', $user->id)
            ->with('gameSession')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $this->notifications = Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $this->userStats = [
            'total_bookings' => $user->total_bookings,
            'total_spent' => $user->total_spent,
            'skill_level' => $user->skill_level,
            'skill_points' => $user->skill_points,
            'average_score' => $user->average_score,
            'skill_progress' => $user->skill_level_progress
        ];

        $this->leaderboardPosition = PlayerScore::selectRaw('user_id, AVG(total_score) as avg_score')
            ->groupBy('user_id')
            ->orderBy('avg_score', 'desc')
            ->pluck('user_id')
            ->search($user->id) + 1;
    }

    public function markNotificationAsRead($notificationId)
    {
        Notification::where('id', $notificationId)
            ->where('user_id', Auth::id())
            ->update(['read_at' => now()]);
        
        $this->loadDashboardData();
    }

    public function render()
    {
        return view('livewire.user.dashboard.dashboard-index')
            ->layout('layouts.app');
    }
}

5. Routes Structure
Web Routes
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\AppleController;


// OAuth routes
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
Route::get('/auth/apple', [AppleController::class, 'redirect'])->name('auth.apple');
Route::get('/auth/apple/callback', [AppleController::class, 'callback']);


// Protected routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', App\Livewire\Admin\Dashboard\DashboardIndex::class)->name('dashboard');
        Route::get('/users', App\Livewire\Admin\Users\UsersList::class)->name('users');
        Route::get('/products', App\Livewire\Admin\Products\ProductsList::class)->name('products');
        Route::get('/coupons', App\Livewire\Admin\Coupons\CouponsList::class)->name('coupons');
        Route::get('/lanes', App\Livewire\Admin\Lanes\LanesList::class)->name('lanes');
        Route::get('/employees', App\Livewire\Admin\Employees\EmployeesList::class)->name('employees');
        Route::get('/gift-cards', App\Livewire\Admin\GiftCards\GiftCardsList::class)->name('gift-cards');
    });









    // Employee routes
  Route::middleware(['role:admin,employee'])->prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', App\Livewire\Employee\Dashboard\DashboardIndex::class)->name('dashboard');
        Route::get('/schedule', App\Livewire\Employee\Schedule\BookingCalendar::class)->name('schedule');
        Route::get('/quick-actions', App\Livewire\Employee\QuickActions\LaneStatus::class)->name('quick-actions');
    });

    // Customer routes
    Route::middleware(['role:customer'])->prefix('dashboard')->name('user.')->group(function () {
        Route::get('/', App\Livewire\User\Dashboard\DashboardIndex::class)->name('dashboard');
        Route::get('/bookings', App\Livewire\User\Booking\BookingHistory::class)->name('bookings');
        Route::get('/book', App\Livewire\User\Booking\BookingForm::class)->name('book');
        Route::get('/profile', App\Livewire\User\Profile\ProfileSettings::class)->name('profile');
        Route::get('/leaderboard', App\Livewire\User\Leaderboard\GlobalLeaderboard::class)->name('leaderboard');
        Route::get('/notifications', App\Livewire\User\Notifications\NotificationsList::class)->name('notifications');
    });
});

6. Sitemap Structure
axtra.ch/
├── / (Homepage with booking widget)
├── /book (Public booking form)
├── /team-event (Team events page)
├── /faq (FAQ page)
├── /about (About page)
├── /gift-card (Gift card purchase)
├── /login (Authentication)
├── /register (Registration)
├── /auth/google (Google OAuth)
├── /auth/apple (Apple OAuth)
│
├── /admin/ (Admin Dashboard)
│   ├── /dashboard (Admin overview)
│   ├── /users (User management)
│   ├── /products (Product management)
│   ├── /coupons (Coupon management)
│   ├── /lanes (Lane management)
│   ├── /employees (Employee management)
│   └── /gift-cards (Gift card management)
│
├── /employee/ (Employee Dashboard)
│   ├── /dashboard (Employee overview)
│   ├── /schedule (Booking calendar)
│   └── /quick-actions (Quick actions panel)
│
└── /dashboard/ (Customer Dashboard)
    ├── / (Customer overview)
    ├── /bookings (Booking history)
    ├── /book (Customer booking form)
    ├── /profile (Profile settings)
    ├── /leaderboard (Leaderboard)
    └── /notifications (Notifications)

7. Key Services
BookingService
<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\TimeSlot;
use App\Events\BookingCreated;

class BookingService
{
    public function createBooking(array $data)
    {
        // Validate time slot availability
        $timeSlot = TimeSlot::find($data['time_slot_id']);
        
        if ($timeSlot->current_bookings + $data['player_count'] > $timeSlot->max_capacity) {
            throw new \Exception('Time slot is fully booked');
        }

        // Create booking
        $booking = Booking::create($data);
        
        // Update time slot capacity
        $timeSlot->increment('current_bookings', $data['player_count']);
        
        // Fire event
        event(new BookingCreated($booking));
        
        return $booking;
    }

    public function calculateTotal(Booking $booking, array $upsells = [])
    {
        $total = $booking->product->price * $booking->player_count;
        
        foreach ($upsells as $upsell) {
            $quantity = $upsell['auto_detect_players'] ? $booking->player_count : $upsell['quantity'];
            $total += $upsell['price'] * $quantity;
        }
        
        return $total;
    }
}
PayRexxService
<?php

namespace App\Services;

use GuzzleHttp\Client;

class PayRexxService
{
    protected $client;
    protected $instanceName;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->instanceName = config('payrexx.instance_name');
        $this->apiKey = config('payrexx.api_key');
    }

    public function createPayment(array $data)
    {
        $response = $this->client->post("https://api.payrexx.com/v1.0/Gateway/", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'instance' => $this->instanceName,
                'amount' => $data['amount'] * 100, // Convert to cents
                'currency' => 'CHF',
                'successRedirectUrl' => $data['success_url'],
                'failedRedirectUrl' => $data['failed_url'],
                'purpose' => $data['purpose'],
                'referenceId' => $data['reference_id'],
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}


