<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\User;
use App\Models\Booking;
use App\Models\GiftCard;
use App\Models\Coupon;
use App\Models\Lane;
use App\Models\Achievement;
use App\Models\Level;
use App\Models\UserAchievement;
use App\Models\GiftCardTransaction;
use Livewire\Component;
use Carbon\Carbon;

class DashboardIndex extends Component
{
    public function render()
    {
        // Basic Stats
        $totalUsers = User::count();
        $totalBookings = Booking::count();
        $totalGiftCards = GiftCard::count();
        $giftCardRevenue = GiftCard::sum('original_amount');
        $totalCoupons = Coupon::count();
        $activeLanes = Lane::where('maintenance_status', 'operational')->count();
        $totalAchievements = Achievement::count();
        $totalLevels = Level::count();
        
        // Time-based stats
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        $todayBookings = Booking::whereDate('created_at', $today)->count();
        $weekBookings = Booking::where('created_at', '>=', $thisWeek)->count();
        $monthBookings = Booking::where('created_at', '>=', $thisMonth)->count();
        $lastMonthBookings = Booking::whereBetween('created_at', [$lastMonth, $thisMonth])->count();
        
        $todayRevenue = Booking::whereDate('created_at', $today)->sum('total_price');
        $weekRevenue = Booking::where('created_at', '>=', $thisWeek)->sum('total_price');
        $monthRevenue = Booking::where('created_at', '>=', $thisMonth)->sum('total_price');
        $lastMonthRevenue = Booking::whereBetween('created_at', [$lastMonth, $thisMonth])->sum('total_price');
        
        $newUsersToday = User::whereDate('created_at', $today)->count();
        $newUsersWeek = User::where('created_at', '>=', $thisWeek)->count();
        $newUsersMonth = User::where('created_at', '>=', $thisMonth)->count();
        
        // Gift card stats
        $giftCardsUsedToday = GiftCardTransaction::whereDate('created_at', $today)
            ->where('transaction_type', 'used')->sum('amount');
        $giftCardsSoldToday = GiftCard::whereDate('created_at', $today)->sum('original_amount');
        
        // Achievement stats
        $achievementsEarnedToday = UserAchievement::whereDate('created_at', $today)->count();
        $achievementsEarnedWeek = UserAchievement::where('created_at', '>=', $thisWeek)->count();
        $topAchievement = Achievement::withCount('userAchievements')
            ->orderBy('user_achievements_count', 'desc')->first();
        
        // Popular services/products
        $popularBookings = Booking::selectRaw('service_id, COUNT(*) as booking_count')
            ->with('service')
            ->groupBy('service_id')
            ->orderBy('booking_count', 'desc')
            ->limit(5)
            ->get();
        
        // Lane utilization
        $laneStats = Lane::withCount(['bookings' => function($query) use ($thisMonth) {
            $query->where('created_at', '>=', $thisMonth);
        }])->get();
        
        // Recent bookings for calendar
        $upcomingBookings = Booking::with(['user', 'lane', 'service'])
            ->where('booking_date', '>=', $today)
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->limit(20)
            ->get();
        
        // Recent activity
        $recentBookings = Booking::with(['user', 'lane', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();
        $recentAchievements = UserAchievement::with(['user', 'achievement'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Calculate growth percentages
        $bookingGrowth = $lastMonthBookings > 0 ? 
            round((($monthBookings - $lastMonthBookings) / $lastMonthBookings) * 100, 1) : 100;
        $revenueGrowth = $lastMonthRevenue > 0 ? 
            round((($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 100;
        
        return view('livewire.admin.dashboard.dashboard-index', compact(
            'totalUsers', 'totalBookings', 'totalGiftCards', 'giftCardRevenue',
            'totalCoupons', 'activeLanes', 'totalAchievements', 'totalLevels',
            'todayBookings', 'weekBookings', 'monthBookings', 'todayRevenue',
            'weekRevenue', 'monthRevenue', 'newUsersToday', 'newUsersWeek',
            'newUsersMonth', 'giftCardsUsedToday', 'giftCardsSoldToday',
            'achievementsEarnedToday', 'achievementsEarnedWeek', 'topAchievement',
            'popularBookings', 'laneStats', 'upcomingBookings', 'recentBookings',
            'recentUsers', 'recentAchievements', 'bookingGrowth', 'revenueGrowth'
        ));
    }
}
