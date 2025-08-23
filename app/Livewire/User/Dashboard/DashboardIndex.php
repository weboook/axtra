<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Booking;
use App\Models\Score;
use Carbon\Carbon;
use Livewire\Component;

class DashboardIndex extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        // Dashboard Statistics
        $stats = [
            'total_sessions' => $user->bookings()->confirmed()->count(),
            'upcoming_sessions' => $user->bookings()
                ->confirmed()
                ->where(function($query) {
                    $query->where('booking_date', '>', now()->toDateString())
                          ->orWhere(function($subQuery) {
                              $subQuery->where('booking_date', '=', now()->toDateString())
                                       ->where('start_time', '>', now()->toTimeString());
                          });
                })
                ->count(),
            'accuracy_rate' => $this->calculateAccuracyRate($user),
            'leaderboard_rank' => $this->getLeaderboardRank($user),
            'skill_points' => $user->skill_points ?? 0,
        ];
        
        // Recent Bookings
        $recentBookings = $user->bookings()
            ->with(['product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Upcoming Sessions
        $upcomingSessions = $user->bookings()
            ->confirmed()
            ->with(['product'])
            ->where(function($query) {
                $query->where('booking_date', '>', now()->toDateString())
                      ->orWhere(function($subQuery) {
                          $subQuery->where('booking_date', '=', now()->toDateString())
                                   ->where('start_time', '>', now()->toTimeString());
                      });
            })
            ->orderBy('booking_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->limit(3)
            ->get();
            
        // Recent Activity (scores, achievements, etc.)
        $recentActivity = $this->getRecentActivity($user);
        
        return view('livewire.user.dashboard.dashboard-index', [
            'stats' => $stats,
            'recentBookings' => $recentBookings,
            'upcomingSessions' => $upcomingSessions,
            'recentActivity' => $recentActivity,
        ])->layout('layouts.app');
    }
    
    private function calculateAccuracyRate($user)
    {
        $scores = Score::where('user_id', $user->id)->get();
        
        if ($scores->isEmpty()) {
            return 0;
        }
        
        $totalThrows = $scores->sum('throws');
        $totalHits = $scores->sum('hits');
        
        return $totalThrows > 0 ? round(($totalHits / $totalThrows) * 100, 1) : 0;
    }
    
    private function getLeaderboardRank($user)
    {
        // Get user's rank based on skill points
        $rank = \App\Models\User::where('skill_points', '>', $user->skill_points ?? 0)
            ->where('role', 'customer')
            ->count() + 1;
            
        return $rank;
    }
    
    private function getRecentActivity($user)
    {
        $activities = collect();
        
        // Recent scores
        $recentScores = Score::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
            
        foreach ($recentScores as $score) {
            if ($score->hits == $score->throws && $score->throws > 0) {
                $activities->push([
                    'type' => 'perfect_score',
                    'title' => 'Perfect Score!',
                    'description' => "Hit {$score->hits}/{$score->throws} targets",
                    'icon' => 'fa-bullseye',
                    'color' => 'var(--axtra-red)',
                    'time' => $score->created_at,
                ]);
            } elseif ($score->hits > ($score->throws * 0.8)) {
                $activities->push([
                    'type' => 'great_score',
                    'title' => 'Great Session!',
                    'description' => "Hit {$score->hits}/{$score->throws} targets",
                    'icon' => 'fa-star',
                    'color' => 'var(--success)',
                    'time' => $score->created_at,
                ]);
            }
        }
        
        // Recent bookings
        $recentBooking = $user->bookings()->orderBy('created_at', 'desc')->first();
        if ($recentBooking && $recentBooking->created_at->isAfter(now()->subDays(7))) {
            $activities->push([
                'type' => 'new_booking',
                'title' => 'New Booking Made',
                'description' => "Booked session for {$recentBooking->participants} player(s)",
                'icon' => 'fa-calendar-plus',
                'color' => 'var(--info)',
                'time' => $recentBooking->created_at,
            ]);
        }
        
        // Skill level progress
        if ($user->skill_points && $user->skill_points > 0) {
            $skillLevel = $this->getSkillLevel($user->skill_points);
            if ($skillLevel !== 'Beginner') {
                $activities->push([
                    'type' => 'skill_progress',
                    'title' => 'Skill Progress!',
                    'description' => "Reached {$skillLevel} level",
                    'icon' => 'fa-trophy',
                    'color' => 'var(--warning)',
                    'time' => $user->updated_at,
                ]);
            }
        }
        
        return $activities->sortByDesc('time')->take(4)->values();
    }
    
    private function getSkillLevel($points)
    {
        if ($points >= 1000) return 'Expert';
        if ($points >= 500) return 'Advanced';
        if ($points >= 200) return 'Intermediate';
        return 'Beginner';
    }
}
