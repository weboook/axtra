<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Service;
use App\Models\EventType;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ProductsIndex extends Component
{
    use WithPagination;

    // Current management mode
    public $managementMode = 'services'; // services, products, event_types
    
    // Search and filtering
    public $search = '';
    public $categoryFilter = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 15;
    
    // Bulk actions
    public $selectedItems = [];
    public $bulkAction = '';
    
    // Modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDetailModal = false;
    
    // Selected item for actions
    public $selectedItem = null;

    public function mount()
    {
        $this->managementMode = request()->get('mode', 'services');
    }

    public function setManagementMode($mode)
    {
        $this->managementMode = $mode;
        $this->resetFilters();
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->statusFilter = '';
        $this->typeFilter = '';
        $this->selectedItems = [];
        $this->bulkAction = '';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
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

    public function showCreateItem()
    {
        $this->showCreateModal = true;
    }

    public function showEditItem($itemId)
    {
        if ($this->managementMode === 'services') {
            $this->selectedItem = Service::findOrFail($itemId);
        } elseif ($this->managementMode === 'products') {
            $this->selectedItem = Product::findOrFail($itemId);
        } else {
            $this->selectedItem = EventType::findOrFail($itemId);
        }
        $this->showEditModal = true;
    }

    public function showItemDetail($itemId)
    {
        if ($this->managementMode === 'services') {
            $this->selectedItem = Service::findOrFail($itemId);
        } elseif ($this->managementMode === 'products') {
            $this->selectedItem = Product::findOrFail($itemId);
        } else {
            $this->selectedItem = EventType::findOrFail($itemId);
        }
        $this->showDetailModal = true;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDetailModal = false;
        $this->selectedItem = null;
    }

    public function toggleItemStatus($itemId)
    {
        if ($this->managementMode === 'services') {
            $item = Service::findOrFail($itemId);
        } elseif ($this->managementMode === 'products') {
            $item = Product::findOrFail($itemId);
        } else {
            $item = EventType::findOrFail($itemId);
        }
        
        $item->update(['is_active' => !$item->is_active]);
        
        $status = $item->is_active ? 'activated' : 'deactivated';
        session()->flash('success', ucfirst($this->managementMode) . " has been {$status} successfully.");
    }

    public function deleteItem($itemId)
    {
        if ($this->managementMode === 'services') {
            $item = Service::findOrFail($itemId);
        } elseif ($this->managementMode === 'products') {
            $item = Product::findOrFail($itemId);
        } else {
            $item = EventType::findOrFail($itemId);
        }
        
        $item->delete();
        session()->flash('success', ucfirst($this->managementMode) . " deleted successfully.");
    }

    public function duplicateItem($itemId)
    {
        if ($this->managementMode === 'services') {
            $original = Service::findOrFail($itemId);
            $duplicate = $original->replicate();
            $duplicate->name = $original->name . ' (Copy)';
            $duplicate->is_active = false;
            $duplicate->save();
        } elseif ($this->managementMode === 'products') {
            $original = Product::findOrFail($itemId);
            $duplicate = $original->replicate();
            $duplicate->name = $original->name . ' (Copy)';
            $duplicate->is_active = false;
            $duplicate->save();
        } else {
            $original = EventType::findOrFail($itemId);
            $duplicate = $original->replicate();
            $duplicate->name = $original->name . ' (Copy)';
            $duplicate->slug = $original->slug . '-copy';
            $duplicate->is_active = false;
            $duplicate->save();
        }
        
        session()->flash('success', ucfirst($this->managementMode) . " duplicated successfully.");
    }

    public function bulkAction()
    {
        if (empty($this->selectedItems) || !$this->bulkAction) return;
        
        $modelClass = match($this->managementMode) {
            'services' => Service::class,
            'products' => Product::class,
            'event_types' => EventType::class
        };
        
        $items = $modelClass::whereIn('id', $this->selectedItems)->get();
        $count = 0;
        
        foreach ($items as $item) {
            switch ($this->bulkAction) {
                case 'activate':
                    if (!$item->is_active) {
                        $item->update(['is_active' => true]);
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($item->is_active) {
                        $item->update(['is_active' => false]);
                        $count++;
                    }
                    break;
                case 'delete':
                    $item->delete();
                    $count++;
                    break;
            }
        }
        
        session()->flash('success', "Bulk action applied to {$count} items.");
        $this->selectedItems = [];
        $this->bulkAction = '';
    }

    #[On('item-created')]
    #[On('item-updated')]
    #[On('closeModals')]
    public function refreshList()
    {
        $this->closeModals();
    }

    public function render()
    {
        $data = match($this->managementMode) {
            'services' => $this->getServicesData(),
            'products' => $this->getProductsData(),
            'event_types' => $this->getEventTypesData(),
            default => $this->getServicesData()
        };

        return view('livewire.admin.products.products-index', $data);
    }

    private function getServicesData()
    {
        $services = Service::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category', $this->categoryFilter);
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

        $stats = [
            'total' => Service::count(),
            'active' => Service::where('is_active', true)->count(),
            'inactive' => Service::where('is_active', false)->count(),
            'categories' => Service::select('category')->distinct()->count(),
        ];

        $categories = ['axe_throwing', 'axe_throwing_making', 'axe_making', 'private_events'];

        return compact('services', 'stats', 'categories');
    }

    private function getProductsData()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('product_type', $this->typeFilter);
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

        $stats = [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'inactive' => Product::where('is_active', false)->count(),
            'upsells' => Product::where('product_type', 'upsell')->count(),
            'addons' => Product::where('product_type', 'addon')->count(),
        ];

        $categories = ['food', 'drinks', 'equipment', 'experience'];
        $types = ['upsell', 'addon'];

        return compact('products', 'stats', 'categories', 'types');
    }

    private function getEventTypesData()
    {
        $eventTypes = EventType::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
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

        $stats = [
            'total' => EventType::count(),
            'active' => EventType::where('is_active', true)->count(),
            'inactive' => EventType::where('is_active', false)->count(),
            'custom_allowed' => EventType::where('allows_custom_input', true)->count(),
        ];

        return compact('eventTypes', 'stats');
    }
}