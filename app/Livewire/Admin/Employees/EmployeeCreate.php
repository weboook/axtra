<?php

namespace App\Livewire\Admin\Employees;

use App\Models\Employee;
use App\Models\User;
use Livewire\Component;

class EmployeeCreate extends Component
{
    public $user_id = '';
    public $employee_id = '';
    public $position = '';
    public $hire_date = '';
    public $hourly_rate = '';
    public $permissions = [];
    public $is_active = true;
    public $notes = '';

    // Available permissions
    public $availablePermissions = [
        'manage_bookings' => 'Manage Bookings',
        'view_reports' => 'View Reports',
        'manage_equipment' => 'Manage Equipment',
        'customer_support' => 'Customer Support',
        'handle_payments' => 'Handle Payments',
        'manage_schedule' => 'Manage Schedule',
        'access_pos' => 'Access POS System',
        'manage_inventory' => 'Manage Inventory',
    ];

    protected function rules()
    {
        return [
            'user_id' => 'required|exists:users,id|unique:employees,user_id',
            'employee_id' => 'required|string|unique:employees,employee_id|max:255',
            'position' => 'required|string|max:255',
            'hire_date' => 'required|date|before_or_equal:today',
            'hourly_rate' => 'nullable|numeric|min:0|max:999.99',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', array_keys($this->availablePermissions)),
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    protected $messages = [
        'user_id.unique' => 'This user is already an employee.',
        'employee_id.unique' => 'This employee ID is already in use.',
        'hire_date.before_or_equal' => 'Hire date cannot be in the future.',
    ];

    public function mount()
    {
        $this->hire_date = now()->format('Y-m-d');
        $this->employee_id = $this->generateEmployeeId();
    }

    protected function generateEmployeeId()
    {
        $year = date('Y');
        $lastEmployee = Employee::whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($lastEmployee) {
            // Extract number from last employee ID (e.g., EMP2024001 -> 001)
            $lastNumber = (int) substr($lastEmployee->employee_id, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        return 'EMP' . $year . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function updatedUserId()
    {
        if ($this->user_id) {
            $user = User::find($this->user_id);
            if ($user && !$this->position) {
                // Set default position based on user data or leave empty
                $this->position = '';
            }
        }
    }

    public function createEmployee()
    {
        $this->validate();

        try {
            $employee = Employee::create([
                'user_id' => $this->user_id,
                'employee_id' => $this->employee_id,
                'position' => $this->position,
                'hire_date' => $this->hire_date,
                'hourly_rate' => $this->hourly_rate ?: null,
                'permissions' => $this->permissions,
                'is_active' => $this->is_active,
                'notes' => $this->notes,
            ]);

            // Update user role to employee
            $user = User::find($this->user_id);
            if ($user->role === 'customer') {
                $user->update(['role' => 'employee']);
            }

            session()->flash('success', 'Employee created successfully!');
            $this->dispatch('employee-created');
            $this->dispatch('closeModals');
            $this->reset();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create employee: ' . $e->getMessage());
        }
    }

    public function regenerateEmployeeId()
    {
        $this->employee_id = $this->generateEmployeeId();
    }

    public function render()
    {
        // Get users who are not already employees (except admins)
        $availableUsers = User::whereNotIn('id', function($query) {
            $query->select('user_id')->from('employees');
        })->where('role', '!=', 'admin')
          ->orderBy('name')
          ->get();

        return view('livewire.admin.employees.employee-create', compact('availableUsers'));
    }
}