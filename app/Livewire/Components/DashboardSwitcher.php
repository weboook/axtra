<?php

namespace App\Livewire\Components;

use Livewire\Component;

class DashboardSwitcher extends Component
{
    public $currentDashboard;
    
    public function mount()
    {
        $this->currentDashboard = $this->getCurrentDashboard();
    }

    public function switchDashboard($dashboard)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admin users can switch dashboards.');
        }

        switch ($dashboard) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'employee':
                return redirect()->route('employee.dashboard');
            case 'customer':
                return redirect()->route('dashboard');
            default:
                return redirect()->route('dashboard');
        }
    }

    private function getCurrentDashboard()
    {
        $routeName = request()->route()->getName();
        
        if (str_starts_with($routeName, 'admin.')) {
            return 'admin';
        } elseif (str_starts_with($routeName, 'employee.')) {
            return 'employee';
        } else {
            return 'customer';
        }
    }

    public function render()
    {
        if (!auth()->user()->isAdmin()) {
            return '';
        }

        $dashboards = [
            'admin' => [
                'name' => 'Admin Dashboard',
                'icon' => 'fas fa-crown',
                'description' => 'Full system control',
                'color' => '#dc3545',
            ],
            'employee' => [
                'name' => 'Employee Dashboard',
                'icon' => 'fas fa-user-tie',
                'description' => 'Staff operations',
                'color' => '#17a2b8',
            ],
            'customer' => [
                'name' => 'Customer Dashboard',
                'icon' => 'fas fa-user',
                'description' => 'Customer experience',
                'color' => '#28a745',
            ],
        ];

        return view('livewire.components.dashboard-switcher', [
            'dashboards' => $dashboards,
        ]);
    }
}
