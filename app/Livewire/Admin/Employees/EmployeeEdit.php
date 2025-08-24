<?php

namespace App\Livewire\Admin\Employees;

use App\Models\Employee;
use App\Models\User;
use Livewire\Component;

class EmployeeEdit extends Component
{
    public Employee $employee;
    
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

    public function mount($employeeId)
    {
        $this->employee = Employee::with('user')->findOrFail($employeeId);
        $this->fill([
            'employee_id' => $this->employee->employee_id,
            'position' => $this->employee->position,
            'hire_date' => $this->employee->hire_date?->format('Y-m-d'),
            'hourly_rate' => $this->employee->hourly_rate,
            'permissions' => $this->employee->permissions ?? [],
            'is_active' => $this->employee->is_active,
            'notes' => $this->employee->notes,
        ]);
    }

    protected function rules()
    {
        return [
            'employee_id' => 'required|string|unique:employees,employee_id,' . $this->employee->id . '|max:255',
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
        'employee_id.unique' => 'This employee ID is already in use.',
        'hire_date.before_or_equal' => 'Hire date cannot be in the future.',
    ];

    public function updateEmployee()
    {
        $this->validate();

        try {
            $this->employee->update([
                'employee_id' => $this->employee_id,
                'position' => $this->position,
                'hire_date' => $this->hire_date,
                'hourly_rate' => $this->hourly_rate ?: null,
                'permissions' => $this->permissions,
                'is_active' => $this->is_active,
                'notes' => $this->notes,
            ]);

            session()->flash('success', 'Employee updated successfully!');
            $this->dispatch('employee-updated');
            $this->dispatch('closeModals');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update employee: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.employees.employee-edit');
    }
}