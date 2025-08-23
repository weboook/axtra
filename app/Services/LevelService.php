<?php

namespace App\Services;

use App\Models\User;
use App\Models\Level;
use App\Models\UserLevelProgress;
use App\Events\UserLevelUp;

class LevelService
{
    /**
     * Award points to a user for various actions
     */
    public function awardPoints(User $user, int $points, string $reason = null): bool
    {
        if ($points <= 0) {
            return false;
        }

        $oldPoints = $user->skill_points ?? 0;
        $newPoints = $oldPoints + $points;
        
        $user->update(['skill_points' => $newPoints]);
        
        // Check for level up
        $oldLevel = Level::getLevelForPoints($oldPoints);
        $newLevel = Level::getLevelForPoints($newPoints);
        
        if ($newLevel && (!$oldLevel || $newLevel->id !== $oldLevel->id)) {
            $this->processLevelUp($user, $newLevel, $reason);
        }
        
        return true;
    }

    /**
     * Process level up for a user
     */
    protected function processLevelUp(User $user, Level $newLevel, string $reason = null): void
    {
        // Update current level progress
        UserLevelProgress::where('user_id', $user->id)
                         ->update(['is_current_level' => false]);
        
        // Create new level progress record
        UserLevelProgress::create([
            'user_id' => $user->id,
            'level_id' => $newLevel->id,
            'current_points' => $user->skill_points,
            'achieved_at' => now(),
            'is_current_level' => true,
            'achievements_unlocked' => $newLevel->achievements ?? []
        ]);
        
        // Update legacy skill_level field for backwards compatibility
        $user->update(['skill_level' => $newLevel->slug]);
        
        // Fire level up event
        event(new UserLevelUp($user, $newLevel, $reason));
    }

    /**
     * Award points for specific game activities
     */
    public function awardGamePoints(User $user, array $gameData): int
    {
        $totalPoints = 0;
        
        // Points for booking completion
        if (isset($gameData['booking_completed']) && $gameData['booking_completed']) {
            $basePoints = 10;
            $totalPoints += $basePoints;
        }
        
        // Points for score achievements
        if (isset($gameData['score'])) {
            $score = $gameData['score'];
            
            // Bullseye bonus
            if (isset($gameData['bullseyes'])) {
                $totalPoints += $gameData['bullseyes'] * 5;
            }
            
            // High score bonus
            if ($score >= 80) {
                $totalPoints += 20; // Excellent score
            } elseif ($score >= 60) {
                $totalPoints += 10; // Good score
            } elseif ($score >= 40) {
                $totalPoints += 5; // Average score
            }
        }
        
        // Consistency bonus (for multiple games)
        if (isset($gameData['games_played']) && $gameData['games_played'] > 1) {
            $consistencyBonus = min($gameData['games_played'] * 2, 20);
            $totalPoints += $consistencyBonus;
        }
        
        // Perfect game bonus
        if (isset($gameData['perfect_game']) && $gameData['perfect_game']) {
            $totalPoints += 50;
        }
        
        if ($totalPoints > 0) {
            $this->awardPoints($user, $totalPoints, 'Game completion');
        }
        
        return $totalPoints;
    }

    /**
     * Get user's current level information
     */
    public function getUserLevelInfo(User $user): array
    {
        $currentLevel = $user->current_level;
        
        if (!$currentLevel) {
            // User has no level, assign them to the first level
            $firstLevel = Level::active()->ordered()->first();
            if ($firstLevel && $user->skill_points >= $firstLevel->points_required) {
                $this->processLevelUp($user, $firstLevel, 'Initial level assignment');
                $currentLevel = $firstLevel;
            }
        }
        
        if (!$currentLevel) {
            return [
                'current_level' => null,
                'current_points' => $user->skill_points ?? 0,
                'next_level' => Level::active()->ordered()->first(),
                'progress_percentage' => 0,
                'points_to_next' => Level::active()->ordered()->first()?->points_required ?? 100
            ];
        }
        
        $nextLevel = $currentLevel->getNextLevel();
        $progressPercentage = $currentLevel->getProgressPercentage($user->skill_points ?? 0);
        
        return [
            'current_level' => $currentLevel,
            'current_points' => $user->skill_points ?? 0,
            'next_level' => $nextLevel,
            'progress_percentage' => $progressPercentage,
            'points_to_next' => $nextLevel ? $nextLevel->points_required - ($user->skill_points ?? 0) : 0,
            'benefits' => $currentLevel->benefits ?? [],
            'achievements' => $currentLevel->achievements ?? [],
            'is_max_level' => !$nextLevel
        ];
    }

    /**
     * Get all available levels
     */
    public function getAllLevels(): \Illuminate\Database\Eloquent\Collection
    {
        return Level::active()->ordered()->get();
    }

    /**
     * Get leaderboard based on levels
     */
    public function getLevelLeaderboard(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return User::customers()
                   ->with(['currentLevelProgress.level'])
                   ->whereHas('currentLevelProgress')
                   ->orderByDesc('skill_points')
                   ->limit($limit)
                   ->get();
    }

    /**
     * Check if user qualifies for level benefits
     */
    public function checkLevelBenefits(User $user, string $benefitType): bool
    {
        $currentLevel = $user->current_level;
        
        if (!$currentLevel) {
            return false;
        }
        
        $benefits = $currentLevel->benefits ?? [];
        
        return collect($benefits)->contains(function ($benefit) use ($benefitType) {
            return stripos($benefit, $benefitType) !== false;
        });
    }

    /**
     * Calculate discount percentage for user based on level
     */
    public function getLevelDiscount(User $user): float
    {
        $currentLevel = $user->current_level;
        
        if (!$currentLevel) {
            return 0.0;
        }
        
        // Extract discount percentage from benefits
        $benefits = $currentLevel->benefits ?? [];
        
        foreach ($benefits as $benefit) {
            if (preg_match('/(\d+)%\s+discount/', $benefit, $matches)) {
                return (float) $matches[1];
            }
        }
        
        return 0.0;
    }

    /**
     * Get user's level history
     */
    public function getUserLevelHistory(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return $user->levelProgress()
                   ->with('level')
                   ->orderBy('achieved_at', 'desc')
                   ->get();
    }
}