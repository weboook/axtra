<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserCreate extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $phone = '';
    public $date_of_birth = '';
    public $role = 'customer';
    public $skill_level = 'beginner';
    public $skill_points = 0;
    public $whatsapp_notifications = true;
    public $hidden_from_leaderboard = false;
    public $admin_notes = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'role' => 'required|in:admin,employee,customer',
            'skill_level' => 'required|in:beginner,intermediate,advanced,expert,master',
            'skill_points' => 'required|integer|min:0',
            'whatsapp_notifications' => 'boolean',
            'hidden_from_leaderboard' => 'boolean',
            'admin_notes' => 'nullable|string|max:1000',
        ];
    }

    protected $messages = [
        'email.unique' => 'This email address is already registered.',
        'password.confirmed' => 'The password confirmation does not match.',
        'date_of_birth.before' => 'Date of birth must be in the past.',
    ];

    public function createUser()
    {
        $this->validate();

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'phone' => $this->phone,
                'date_of_birth' => $this->date_of_birth,
                'role' => $this->role,
                'skill_level' => $this->skill_level,
                'skill_points' => $this->skill_points,
                'whatsapp_notifications' => $this->whatsapp_notifications,
                'hidden_from_leaderboard' => $this->hidden_from_leaderboard,
                'admin_notes' => $this->admin_notes,
                'email_verified_at' => now(), // Auto-verify admin created users
            ]);

            session()->flash('success', 'User created successfully!');
            $this->dispatch('user-created');
            $this->dispatch('closeModals');
            $this->reset();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    public function generatePassword()
    {
        $this->password = \Str::random(12);
        $this->password_confirmation = $this->password;
    }

    public function render()
    {
        return view('livewire.admin.users.user-create');
    }
}
