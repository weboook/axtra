<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class UsersIndex extends Component
{
    use WithPagination;

    // Search and filtering
    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 15;
    
    // Quick actions
    public $selectedUsers = [];
    public $bulkAction = '';
    
    // Modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDetailModal = false;
    public $showBanModal = false;
    public $showPointsModal = false;
    
    // Selected user for actions
    public $selectedUser = null;
    
    // Ban modal fields
    public $banReason = '';
    
    // Points modal fields
    public $pointsToAdd = 0;
    public $pointsReason = '';
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }
    
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function showCreateUser()
    {
        $this->showCreateModal = true;
    }

    public function showEditUser($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->showEditModal = true;
    }

    public function showUserDetail($userId)
    {
        $this->selectedUser = User::with(['bannedBy', 'bookings'])->findOrFail($userId);
        $this->showDetailModal = true;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDetailModal = false;
        $this->showBanModal = false;
        $this->showPointsModal = false;
        $this->selectedUser = null;
        $this->reset(['banReason', 'pointsToAdd', 'pointsReason']);
    }

    public function updateUserRole($userId, $role)
    {
        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id() && $role !== 'admin') {
            session()->flash('error', 'You cannot remove your own admin privileges.');
            return;
        }

        $user->update(['role' => $role]);
        
        session()->flash('success', "User role updated to {$role} successfully.");
    }

    public function toggleUserBan($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot ban your own account.');
            return;
        }

        if ($user->isBanned()) {
            $user->unban();
            session()->flash('success', 'User has been unbanned successfully.');
        } else {
            $this->selectedUser = $user;
            $this->showBanModal = true;
        }
    }

    public function banUser()
    {
        if (!$this->selectedUser) return;
        
        $this->selectedUser->ban($this->banReason, auth()->id());
        
        session()->flash('success', 'User has been banned successfully.');
        $this->closeModals();
    }

    public function toggleLeaderboardVisibility($userId)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'hidden_from_leaderboard' => !$user->hidden_from_leaderboard
        ]);
        
        $status = $user->hidden_from_leaderboard ? 'hidden from' : 'visible on';
        session()->flash('success', "User is now {$status} the leaderboard.");
    }

    public function showPointsModal($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->showPointsModal = true;
    }

    public function addPoints()
    {
        if (!$this->selectedUser || $this->pointsToAdd == 0) return;
        
        $this->selectedUser->addSkillPoints($this->pointsToAdd, $this->pointsReason ?: 'Admin adjustment');
        
        $action = $this->pointsToAdd > 0 ? 'added' : 'removed';
        session()->flash('success', "Successfully {$action} " . abs($this->pointsToAdd) . " points.");
        $this->closeModals();
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $user->delete();
        session()->flash('success', 'User deleted successfully.');
    }

    public function bulkAction()
    {
        if (empty($this->selectedUsers) || !$this->bulkAction) return;
        
        $users = User::whereIn('id', $this->selectedUsers)
            ->where('id', '!=', auth()->id()) // Prevent self-actions
            ->get();
            
        $count = 0;
        
        foreach ($users as $user) {
            switch ($this->bulkAction) {
                case 'ban':
                    if (!$user->isBanned()) {
                        $user->ban('Bulk ban action', auth()->id());
                        $count++;
                    }
                    break;
                case 'unban':
                    if ($user->isBanned()) {
                        $user->unban();
                        $count++;
                    }
                    break;
                case 'hide_leaderboard':
                    if (!$user->hidden_from_leaderboard) {
                        $user->update(['hidden_from_leaderboard' => true]);
                        $count++;
                    }
                    break;
                case 'show_leaderboard':
                    if ($user->hidden_from_leaderboard) {
                        $user->update(['hidden_from_leaderboard' => false]);
                        $count++;
                    }
                    break;
                case 'delete':
                    $user->delete();
                    $count++;
                    break;
            }
        }
        
        session()->flash('success', "Bulk action applied to {$count} users.");
        $this->selectedUsers = [];
        $this->bulkAction = '';
    }

    #[On('user-created')]
    #[On('user-updated')]
    public function refreshList()
    {
        // Component will re-render automatically
    }

    public function render()
    {
        $users = User::query()
            ->with(['bannedBy'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter, function ($query) {
                switch ($this->statusFilter) {
                    case 'banned':
                        $query->where('is_banned', true);
                        break;
                    case 'active':
                        $query->where('is_banned', false);
                        break;
                    case 'hidden_leaderboard':
                        $query->where('hidden_from_leaderboard', true);
                        break;
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'employees' => User::where('role', 'employee')->count(),
            'customers' => User::where('role', 'customer')->count(),
            'banned' => User::where('is_banned', true)->count(),
            'hidden_from_leaderboard' => User::where('hidden_from_leaderboard', true)->count(),
        ];

        return view('livewire.admin.users.users-index', compact('users', 'stats'));
    }
}
