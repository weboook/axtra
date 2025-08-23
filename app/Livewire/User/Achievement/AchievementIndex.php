<?php

namespace App\Livewire\User\Achievement;

use App\Models\Achievement;
use App\Models\SkillLevel;
use App\Models\UserAchievement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AchievementIndex extends Component
{
    public $filterType = 'all';
    
    public function render()
    {
        $user = Auth::user();
        $currentSkillLevel = $user->getCurrentSkillLevel();
        $userPoints = $user->skill_points ?? 0;
        
        // Get level progress
        $levelProgress = null;
        if ($currentSkillLevel) {
            $levelProgress = $currentSkillLevel->getProgressToNextLevel($userPoints);
        }
        
        // Get achievements based on filter
        $achievementsQuery = Achievement::active()->with('userAchievements');
        
        if ($this->filterType === 'completed') {
            $achievementsQuery->whereHas('userAchievements', function($query) use ($user) {
                $query->where('user_id', $user->id)->whereNotNull('completed_at');
            });
        } elseif ($this->filterType === 'in_progress') {
            $achievementsQuery->whereHas('userAchievements', function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->whereNull('completed_at')
                      ->where('current_value', '>', 0);
            });
        } elseif ($this->filterType === 'locked') {
            $achievementsQuery->whereDoesntHave('userAchievements', function($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }
        
        if ($this->filterType !== 'all') {
            $achievementsQuery->visible();
        }
        
        $achievements = $achievementsQuery->orderBy('order')->orderBy('name')->get();
        
        // Get user's achievement progress
        $userAchievements = UserAchievement::where('user_id', $user->id)
            ->with('achievement')
            ->get()
            ->keyBy('achievement_id');
            
        // Get all skill levels
        $skillLevels = SkillLevel::active()->ordered()->get();
        
        // Calculate achievement statistics
        $totalAchievements = Achievement::active()->visible()->count();
        $completedAchievements = $userAchievements->where('completed_at', '!=', null)->count();
        $inProgressAchievements = $userAchievements->where('completed_at', null)->where('current_value', '>', 0)->count();
        
        return view('livewire.user.achievement.achievement-index', [
            'achievements' => $achievements,
            'userAchievements' => $userAchievements,
            'currentSkillLevel' => $currentSkillLevel,
            'levelProgress' => $levelProgress,
            'skillLevels' => $skillLevels,
            'userPoints' => $userPoints,
            'totalAchievements' => $totalAchievements,
            'completedAchievements' => $completedAchievements,
            'inProgressAchievements' => $inProgressAchievements
        ]);
    }
    
    public function setFilter($type)
    {
        $this->filterType = $type;
    }
}
