<?php

namespace App\Livewire\User\Leaderboard;

use App\Models\User;
use App\Models\Booking;
use App\Models\Score;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LeaderboardIndex extends Component
{
    use WithPagination;
    
    public $filter = 'skill_points'; // skill_points, accuracy, sessions
    public $period = 'all'; // all, month, week
    public $search = '';
    
    protected $queryString = [
        'filter' => ['except' => 'skill_points'],
        'period' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedFilter()
    {
        $this->resetPage();
    }
    
    public function updatedPeriod()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $currentUser = auth()->user();
        
        // Base query for customers only
        $query = User::where('role', 'customer');
        
        // Apply search filter
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        
        // Apply period filter for certain metrics
        $periodConstraint = null;
        switch ($this->period) {
            case 'week':
                $periodConstraint = now()->subWeek();
                break;
            case 'month':
                $periodConstraint = now()->subMonth();
                break;
        }
        
        // Apply ranking filter
        switch ($this->filter) {
            case 'skill_points':
                $query->orderBy('skill_points', 'desc')
                      ->orderBy('created_at', 'asc');
                break;
                
            case 'accuracy':
                // For accuracy, we need to calculate based on individual throws
                $query->select('users.*')
                      ->leftJoin('scores', 'users.id', '=', 'scores.user_id')
                      ->when($periodConstraint, function($q) use ($periodConstraint) {
                          $q->where('scores.created_at', '>=', $periodConstraint);
                      })
                      ->groupBy('users.id')
                      ->orderByRaw('CASE WHEN COUNT(scores.id) > 0 THEN ((
                          CASE WHEN SUM(CASE WHEN scores.throw_1 > 0 THEN 1 ELSE 0 END) + 
                                    SUM(CASE WHEN scores.throw_2 > 0 THEN 1 ELSE 0 END) + 
                                    SUM(CASE WHEN scores.throw_3 > 0 THEN 1 ELSE 0 END) > 0 
                          THEN (SUM(CASE WHEN scores.throw_1 > 0 THEN 1 ELSE 0 END) + 
                                SUM(CASE WHEN scores.throw_2 > 0 THEN 1 ELSE 0 END) + 
                                SUM(CASE WHEN scores.throw_3 > 0 THEN 1 ELSE 0 END)) / (COUNT(scores.id) * 3.0) * 100 
                          ELSE 0 END
                      )) ELSE 0 END DESC')
                      ->orderBy('users.created_at', 'asc');
                break;
                
            case 'sessions':
                $query->select('users.*')
                      ->leftJoin('bookings', 'users.id', '=', 'bookings.user_id')
                      ->where('bookings.status', 'completed')
                      ->when($periodConstraint, function($q) use ($periodConstraint) {
                          $q->where('bookings.created_at', '>=', $periodConstraint);
                      })
                      ->groupBy('users.id')
                      ->orderByRaw('COUNT(bookings.id) DESC')
                      ->orderBy('users.created_at', 'asc');
                break;
        }
        
        $leaderboard = $query->paginate(20);
        
        // Calculate additional stats for each user
        foreach ($leaderboard as $user) {
            $user->total_sessions = $user->bookings()->where('status', 'completed')->count();
            $user->accuracy_rate = $this->calculateAccuracyRate($user, $periodConstraint);
            
            // Calculate total throws and hits based on score records
            $userScores = Score::where('user_id', $user->id)
                ->when($periodConstraint, function($q) use ($periodConstraint) {
                    $q->where('created_at', '>=', $periodConstraint);
                })
                ->get();
                
            $user->total_throws = $userScores->count() * 3; // 3 throws per round
            $user->total_hits = 0;
            
            foreach ($userScores as $score) {
                if ($score->throw_1 > 0) $user->total_hits++;
                if ($score->throw_2 > 0) $user->total_hits++;
                if ($score->throw_3 > 0) $user->total_hits++;
            }
        }
        
        // Get current user's rank
        $currentUserRank = null;
        if ($currentUser && $currentUser->role === 'customer') {
            $currentUserRank = $this->getCurrentUserRank($currentUser);
        }
        
        // Overall statistics
        $stats = [
            'total_players' => User::where('role', 'customer')->count(),
            'active_players' => User::where('role', 'customer')
                ->where('updated_at', '>=', now()->subMonth())
                ->count(),
            'total_sessions' => Booking::where('status', 'completed')->count(),
            'total_throws' => Score::count() * 3, // Each score record represents 3 throws
        ];
        
        return view('livewire.user.leaderboard.leaderboard-index', [
            'leaderboard' => $leaderboard,
            'currentUserRank' => $currentUserRank,
            'stats' => $stats,
        ])->layout('layouts.app');
    }
    
    private function calculateAccuracyRate($user, $periodConstraint = null)
    {
        $scores = Score::where('user_id', $user->id)
            ->when($periodConstraint, function($q) use ($periodConstraint) {
                $q->where('created_at', '>=', $periodConstraint);
            })
            ->get();
        
        if ($scores->isEmpty()) {
            return 0;
        }
        
        $totalThrows = 0;
        $totalHits = 0;
        
        foreach ($scores as $score) {
            // Count each throw (3 throws per round)
            $totalThrows += 3;
            
            // Count hits (non-zero throws are hits)
            if ($score->throw_1 > 0) $totalHits++;
            if ($score->throw_2 > 0) $totalHits++;
            if ($score->throw_3 > 0) $totalHits++;
        }
        
        return $totalThrows > 0 ? round(($totalHits / $totalThrows) * 100, 1) : 0;
    }
    
    private function getCurrentUserRank($user)
    {
        switch ($this->filter) {
            case 'skill_points':
                return User::where('role', 'customer')
                    ->where('skill_points', '>', $user->skill_points ?? 0)
                    ->count() + 1;
                    
            case 'accuracy':
                $userAccuracy = $this->calculateAccuracyRate($user, 
                    $this->period === 'week' ? now()->subWeek() : 
                    ($this->period === 'month' ? now()->subMonth() : null)
                );
                
                return User::where('role', 'customer')
                    ->get()
                    ->filter(function($otherUser) use ($user, $userAccuracy) {
                        return $otherUser->id !== $user->id && 
                               $this->calculateAccuracyRate($otherUser, 
                                   $this->period === 'week' ? now()->subWeek() : 
                                   ($this->period === 'month' ? now()->subMonth() : null)
                               ) > $userAccuracy;
                    })
                    ->count() + 1;
                    
            case 'sessions':
                $userSessions = $user->bookings()
                    ->where('status', 'completed')
                    ->when($this->period === 'week', function($q) {
                        $q->where('created_at', '>=', now()->subWeek());
                    })
                    ->when($this->period === 'month', function($q) {
                        $q->where('created_at', '>=', now()->subMonth());
                    })
                    ->count();
                    
                return User::where('role', 'customer')
                    ->withCount(['bookings as sessions_count' => function($query) {
                        $query->where('status', 'completed');
                        if ($this->period === 'week') {
                            $query->where('created_at', '>=', now()->subWeek());
                        } elseif ($this->period === 'month') {
                            $query->where('created_at', '>=', now()->subMonth());
                        }
                    }])
                    ->having('sessions_count', '>', $userSessions)
                    ->count() + 1;
        }
        
        return null;
    }
}