<?php

namespace App\Livewire\Admin\Employees;

use App\Models\Employee;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class EmployeesIndex extends Component
{
    use WithPagination;

    // Search and filtering
    public $search = '';
    public $positionFilter = '';
    public $statusFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 15;
    
    // Quick actions
    public $selectedEmployees = [];
    public $bulkAction = '';
    
    // Modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDetailModal = false;
    
    // Selected employee for actions
    public $selectedEmployee = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPositionFilter()
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

    public function showCreateEmployee()
    {
        $this->showCreateModal = true;
    }

    public function showEditEmployee($employeeId)
    {
        $this->selectedEmployee = Employee::with('user')->findOrFail($employeeId);
        $this->showEditModal = true;
    }

    public function showEmployeeDetail($employeeId)
    {
        $this->selectedEmployee = Employee::with(['user'])->findOrFail($employeeId);
        $this->showDetailModal = true;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDetailModal = false;
        $this->selectedEmployee = null;
    }

    public function toggleEmployeeStatus($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        $employee->update(['is_active' => !$employee->is_active]);
        
        $status = $employee->is_active ? 'activated' : 'deactivated';
        session()->flash('success', "Employee has been {$status} successfully.");
    }

    public function deleteEmployee($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        
        // Set user role back to customer
        $employee->user->update(['role' => 'customer']);
        
        $employee->delete();
        session()->flash('success', 'Employee deleted successfully.');
    }

    public function bulkAction()
    {
        if (empty($this->selectedEmployees) || !$this->bulkAction) return;
        
        $employees = Employee::whereIn('id', $this->selectedEmployees)->get();
        $count = 0;
        
        foreach ($employees as $employee) {
            switch ($this->bulkAction) {
                case 'activate':
                    if (!$employee->is_active) {
                        $employee->update(['is_active' => true]);
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($employee->is_active) {
                        $employee->update(['is_active' => false]);
                        $count++;
                    }
                    break;
                case 'delete':
                    // Set user role back to customer
                    $employee->user->update(['role' => 'customer']);
                    $employee->delete();
                    $count++;
                    break;
            }
        }
        
        session()->flash('success', "Bulk action applied to {$count} employees.");
        $this->selectedEmployees = [];
        $this->bulkAction = '';
    }

    #[On('employee-created')]
    #[On('employee-updated')]
    #[On('closeModals')]
    public function refreshList()
    {
        // Component will re-render automatically and handle modal closing
        $this->closeModals();
    }

    public function render()
    {
        // Get all employees and admins
        $employees = Employee::query()
            ->with(['user'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })->orWhere('employee_id', 'like', '%' . $this->search . '%')
                  ->orWhere('position', 'like', '%' . $this->search . '%');
            })
            ->when($this->positionFilter, function ($query) {
                if ($this->positionFilter === 'admin') {
                    // Special case for admin filter
                    $query->whereHas('user', function ($q) {
                        $q->where('role', 'admin');
                    });
                } else {
                    $query->where('position', $this->positionFilter);
                }
            })
            ->when($this->statusFilter, function ($query) {
                switch ($this->statusFilter) {
                    case 'active':
                        $query->where('is_active', true);
                        break;
                    case 'inactive':
                        $query->where('is_active', false);
                        break;
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        // Also get admin users who don't have employee records
        $adminUsers = User::where('role', 'admin')
            ->whereNotIn('id', function($query) {
                $query->select('user_id')->from('employees');
            })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->positionFilter && $this->positionFilter !== 'admin', function ($query) {
                // Hide admin users if filtering by non-admin position
                $query->whereRaw('1 = 0');
            })
            ->get();

        $stats = [
            'total' => Employee::count() + User::where('role', 'admin')->count(),
            'active' => Employee::where('is_active', true)->count() + User::where('role', 'admin')->count(),
            'inactive' => Employee::where('is_active', false)->count(),
            'positions' => Employee::select('position')->distinct()->count() + 1, // +1 for admin
        ];

        // Get distinct positions for filter, including admin
        $positions = Employee::select('position')->distinct()->pluck('position')->filter()->sort();
        $positions = $positions->prepend('admin', 'admin');

        return view('livewire.admin.employees.employees-index', compact('employees', 'stats', 'positions', 'adminUsers'));
    }
}