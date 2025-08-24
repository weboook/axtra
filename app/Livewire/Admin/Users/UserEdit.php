<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserEdit extends Component
{
    public User $user;
    
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $phone = '';
    public $date_of_birth = '';
    public $role = '';
    public $skill_level = '';
    public $skill_points = 0;
    public $total_bookings = 0;
    public $total_spent = 0;
    public $whatsapp_notifications = true;
    public $hidden_from_leaderboard = false;
    public $admin_notes = '';
    public $is_banned = false;
    public $ban_reason = '';

    public function mount($userId)
    {
        $this->user = User::findOrFail($userId);
        $this->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'date_of_birth' => $this->user->date_of_birth?->format('Y-m-d'),
            'role' => $this->user->role,
            'skill_level' => $this->user->skill_level,
            'skill_points' => $this->user->skill_points,
            'total_bookings' => $this->user->total_bookings,
            'total_spent' => $this->user->total_spent,
            'whatsapp_notifications' => $this->user->whatsapp_notifications,
            'hidden_from_leaderboard' => $this->user->hidden_from_leaderboard,
            'admin_notes' => $this->user->admin_notes,
            'is_banned' => $this->user->is_banned,
            'ban_reason' => $this->user->ban_reason,
        ]);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'phone' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'role' => 'required|in:admin,employee,customer',
            'skill_level' => 'required|in:beginner,intermediate,advanced,expert,master',
            'skill_points' => 'required|integer|min:0',
            'total_bookings' => 'required|integer|min:0',
            'total_spent' => 'required|numeric|min:0',
            'whatsapp_notifications' => 'boolean',
            'hidden_from_leaderboard' => 'boolean',
            'admin_notes' => 'nullable|string|max:1000',
            'is_banned' => 'boolean',
            'ban_reason' => 'nullable|string|max:500',
        ];
    }

    public function updateUser()
    {
        // Prevent self-demotion
        if ($this->user->id === auth()->id() && $this->role !== 'admin') {
            session()->flash('error', 'You cannot remove your own admin privileges.');
            return;
        }

        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'date_of_birth' => $this->date_of_birth,
                'role' => $this->role,
                'skill_level' => $this->skill_level,
                'skill_points' => $this->skill_points,
                'total_bookings' => $this->total_bookings,
                'total_spent' => $this->total_spent,
                'whatsapp_notifications' => $this->whatsapp_notifications,
                'hidden_from_leaderboard' => $this->hidden_from_leaderboard,
                'admin_notes' => $this->admin_notes,
            ];

            // Handle password update
            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            // Handle ban status
            if ($this->is_banned && !$this->user->is_banned) {
                // Banning user
                $data['is_banned'] = true;
                $data['ban_reason'] = $this->ban_reason;
                $data['banned_at'] = now();
                $data['banned_by'] = auth()->id();
            } elseif (!$this->is_banned && $this->user->is_banned) {
                // Unbanning user
                $data['is_banned'] = false;
                $data['ban_reason'] = null;
                $data['banned_at'] = null;
                $data['banned_by'] = null;
            }

            $this->user->update($data);

            session()->flash('success', 'User updated successfully!');
            $this->dispatch('user-updated');
            $this->dispatch('closeModals');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function generatePassword()
    {
        $this->password = \Str::random(12);
        $this->password_confirmation = $this->password;
    }

    public function render()
    {
        return view('livewire.admin.users.user-edit');
    }
}
