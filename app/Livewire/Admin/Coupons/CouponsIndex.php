<?php

namespace App\Livewire\Admin\Coupons;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Service;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class CouponsIndex extends Component
{
    use WithPagination;

    // Search and filtering
    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 15;
    
    // Bulk actions
    public $selectedCoupons = [];
    public $bulkAction = '';
    
    // Modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDetailModal = false;
    public $showUsageModal = false;
    
    // Selected coupon for actions
    public $selectedCoupon = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
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

    public function showCreateCoupon()
    {
        $this->showCreateModal = true;
    }

    public function showEditCoupon($couponId)
    {
        $this->selectedCoupon = Coupon::findOrFail($couponId);
        $this->showEditModal = true;
    }

    public function showCouponDetail($couponId)
    {
        $this->selectedCoupon = Coupon::with(['usages.user', 'usages.booking', 'creator'])
                                      ->findOrFail($couponId);
        $this->showDetailModal = true;
    }

    public function showCouponUsage($couponId)
    {
        $this->selectedCoupon = Coupon::with(['usages.user', 'usages.booking'])
                                      ->findOrFail($couponId);
        $this->showUsageModal = true;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDetailModal = false;
        $this->showUsageModal = false;
        $this->selectedCoupon = null;
    }

    public function toggleCouponStatus($couponId)
    {
        $coupon = Coupon::findOrFail($couponId);
        $coupon->update(['is_active' => !$coupon->is_active]);
        
        $status = $coupon->is_active ? 'activated' : 'deactivated';
        session()->flash('success', "Coupon {$coupon->code} has been {$status} successfully.");
    }

    public function deleteCoupon($couponId)
    {
        $coupon = Coupon::findOrFail($couponId);
        $code = $coupon->code;
        $coupon->delete();
        
        session()->flash('success', "Coupon {$code} deleted successfully.");
    }

    public function duplicateCoupon($couponId)
    {
        $original = Coupon::findOrFail($couponId);
        $duplicate = $original->replicate();
        $duplicate->code = null; // Will be auto-generated
        $duplicate->name = $original->name . ' (Copy)';
        $duplicate->is_active = false;
        $duplicate->used_count = 0;
        $duplicate->created_by = auth()->id();
        $duplicate->save();
        
        session()->flash('success', "Coupon duplicated successfully with code {$duplicate->code}.");
    }

    public function extendCoupon($couponId, $days = 30)
    {
        $coupon = Coupon::findOrFail($couponId);
        $coupon->update([
            'valid_until' => $coupon->valid_until->addDays($days)
        ]);
        
        session()->flash('success', "Coupon {$coupon->code} extended by {$days} days.");
    }

    public function bulkAction()
    {
        if (empty($this->selectedCoupons) || !$this->bulkAction) return;
        
        $coupons = Coupon::whereIn('id', $this->selectedCoupons)->get();
        $count = 0;
        
        foreach ($coupons as $coupon) {
            switch ($this->bulkAction) {
                case 'activate':
                    if (!$coupon->is_active) {
                        $coupon->update(['is_active' => true]);
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($coupon->is_active) {
                        $coupon->update(['is_active' => false]);
                        $count++;
                    }
                    break;
                case 'extend':
                    $coupon->update([
                        'valid_until' => $coupon->valid_until->addDays(30)
                    ]);
                    $count++;
                    break;
                case 'delete':
                    $coupon->delete();
                    $count++;
                    break;
            }
        }
        
        session()->flash('success', "Bulk action applied to {$count} coupons.");
        $this->selectedCoupons = [];
        $this->bulkAction = '';
    }

    #[On('coupon-created')]
    #[On('coupon-updated')]
    #[On('closeModals')]
    public function refreshList()
    {
        $this->closeModals();
    }

    public function render()
    {
        $coupons = Coupon::query()
            ->when($this->search, function ($query) {
                $query->where('code', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                switch ($this->statusFilter) {
                    case 'active':
                        $query->active();
                        break;
                    case 'expired':
                        $query->expired();
                        break;
                    case 'upcoming':
                        $query->upcoming();
                        break;
                    case 'inactive':
                        $query->where('is_active', false);
                        break;
                    case 'exhausted':
                        $query->whereRaw('usage_limit IS NOT NULL AND used_count >= usage_limit');
                        break;
                }
            })
            ->when($this->typeFilter, function ($query) {
                $query->byType($this->typeFilter);
            })
            ->withCount(['usages'])
            ->with(['creator'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $stats = [
            'total' => Coupon::count(),
            'active' => Coupon::active()->count(),
            'expired' => Coupon::expired()->count(),
            'upcoming' => Coupon::upcoming()->count(),
            'inactive' => Coupon::where('is_active', false)->count(),
            'total_usage' => CouponUsage::count(),
            'total_savings' => CouponUsage::sum('discount_amount'),
        ];

        $recentUsage = CouponUsage::with(['coupon', 'user', 'booking'])
                                  ->recent()
                                  ->orderBy('used_at', 'desc')
                                  ->limit(10)
                                  ->get();

        return view('livewire.admin.coupons.coupons-index', compact('coupons', 'stats', 'recentUsage'));
    }
}
