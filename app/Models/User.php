<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'role',
        'total_bookings',
        'total_spent',
        'skill_level',
        'skill_points',
        'whatsapp_notifications',
        'google_id',
        'apple_id',
        'avatar',
        'is_banned',
        'ban_reason',
        'banned_at',
        'banned_by',
        'hidden_from_leaderboard',
        'last_activity',
        'admin_notes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'total_spent' => 'decimal:2',
            'whatsapp_notifications' => 'boolean',
            'is_banned' => 'boolean',
            'banned_at' => 'datetime',
            'hidden_from_leaderboard' => 'boolean',
            'last_activity' => 'datetime',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function purchasedGiftCards()
    {
        return $this->hasMany(GiftCard::class, 'purchased_by');
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
        return $this->hasMany(\Illuminate\Notifications\DatabaseNotification::class);
    }

    public function userAchievements()
    {
        return $this->hasMany(UserAchievement::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
                    ->withPivot(['progress', 'completed_at', 'current_value'])
                    ->withTimestamps();
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'user_level_progress')
                    ->withPivot(['current_points', 'achieved_at', 'is_current_level', 'achievements_unlocked'])
                    ->withTimestamps();
    }

    public function levelProgress()
    {
        return $this->hasMany(UserLevelProgress::class);
    }

    public function currentLevelProgress()
    {
        return $this->hasOne(UserLevelProgress::class)->where('is_current_level', true);
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

    public function getCurrentLevelAttribute()
    {
        return $this->currentLevelProgress?->level ?? Level::getLevelForPoints($this->skill_points ?? 0);
    }

    public function getCurrentSkillLevel()
    {
        return SkillLevel::getLevelForPoints($this->skill_points ?? 0);
    }

    public function getSkillLevelProgressAttribute()
    {
        $currentLevel = $this->current_level;
        
        if (!$currentLevel) {
            return [
                'current' => $this->skill_points ?? 0,
                'required' => 100,
                'percentage' => 0,
                'level_name' => 'Beginner'
            ];
        }

        $nextLevel = $currentLevel->getNextLevel();
        
        if (!$nextLevel) {
            return [
                'current' => $this->skill_points ?? 0,
                'required' => $currentLevel->points_required,
                'percentage' => 100,
                'level_name' => $currentLevel->name,
                'max_level' => true
            ];
        }

        $progressPercentage = $currentLevel->getProgressPercentage($this->skill_points ?? 0);
        
        return [
            'current' => $this->skill_points ?? 0,
            'required' => $nextLevel->points_required,
            'current_level_required' => $currentLevel->points_required,
            'percentage' => $progressPercentage,
            'level_name' => $currentLevel->name,
            'next_level_name' => $nextLevel->name,
            'points_to_next' => $nextLevel->points_required - ($this->skill_points ?? 0)
        ];
    }

    public function addSkillPoints(int $points, string $reason = null)
    {
        $oldPoints = $this->skill_points ?? 0;
        $newPoints = $oldPoints + $points;
        
        $this->update(['skill_points' => $newPoints]);
        
        // Check for level up
        $oldLevel = Level::getLevelForPoints($oldPoints);
        $newLevel = Level::getLevelForPoints($newPoints);
        
        if ($newLevel && (!$oldLevel || $newLevel->id !== $oldLevel->id)) {
            $this->levelUp($newLevel, $reason);
        }
        
        return $this;
    }

    protected function levelUp(Level $newLevel, string $reason = null)
    {
        // Update current level progress
        $this->levelProgress()->update(['is_current_level' => false]);
        
        // Create new level progress record
        UserLevelProgress::create([
            'user_id' => $this->id,
            'level_id' => $newLevel->id,
            'current_points' => $this->skill_points,
            'achieved_at' => now(),
            'is_current_level' => true,
            'achievements_unlocked' => $newLevel->achievements ?? []
        ]);
        
        // Update legacy skill_level field for backwards compatibility
        $this->update(['skill_level' => $newLevel->slug]);
        
        // Fire level up event
        event(new \App\Events\UserLevelUp($this, $newLevel, $reason));
        
        return $this;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEmployee()
    {
        return in_array($this->role, ['admin', 'employee']);
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    public function bannedUsers()
    {
        return $this->hasMany(User::class, 'banned_by');
    }

    public function isBanned()
    {
        return $this->is_banned;
    }

    public function ban($reason = null, $adminId = null)
    {
        $this->update([
            'is_banned' => true,
            'ban_reason' => $reason,
            'banned_at' => now(),
            'banned_by' => $adminId ?? auth()->id(),
        ]);
    }

    public function unban()
    {
        $this->update([
            'is_banned' => false,
            'ban_reason' => null,
            'banned_at' => null,
            'banned_by' => null,
        ]);
    }
}
