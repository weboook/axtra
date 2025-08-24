<?php

namespace App\Livewire\Admin\GiftCards;

use App\Models\GiftCard;
use App\Models\GiftCardTransaction;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class GiftCardsIndex extends Component
{
    use WithPagination;

    // Search and filtering
    public $search = '';
    public $statusFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 15;
    
    // Bulk actions
    public $selectedGiftCards = [];
    public $bulkAction = '';
    
    // Modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDetailModal = false;
    public $showTransactionsModal = false;
    
    // Selected gift card for actions
    public $selectedGiftCard = null;
    
    // Create/Edit form fields
    public $form = [
        'code' => '',
        'recipient_name' => '',
        'recipient_email' => '',
        'original_amount' => '',
        'message' => '',
        'valid_until' => '',
        'is_active' => true,
    ];

    public function updatingSearch()
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

    public function showCreateGiftCard()
    {
        $this->resetForm();
        $this->form['valid_until'] = now()->addYear()->format('Y-m-d');
        $this->showCreateModal = true;
    }

    public function showEditGiftCard($giftCardId)
    {
        $this->selectedGiftCard = GiftCard::findOrFail($giftCardId);
        $this->form = [
            'code' => $this->selectedGiftCard->code,
            'recipient_name' => $this->selectedGiftCard->recipient_name,
            'recipient_email' => $this->selectedGiftCard->recipient_email,
            'original_amount' => $this->selectedGiftCard->original_amount,
            'message' => $this->selectedGiftCard->message,
            'valid_until' => $this->selectedGiftCard->valid_until->format('Y-m-d'),
            'is_active' => $this->selectedGiftCard->is_active,
        ];
        $this->showEditModal = true;
    }

    public function showGiftCardDetail($giftCardId)
    {
        $this->selectedGiftCard = GiftCard::with(['purchaser', 'transactions.user', 'transactions.booking'])
                                          ->findOrFail($giftCardId);
        $this->showDetailModal = true;
    }

    public function showGiftCardTransactions($giftCardId)
    {
        $this->selectedGiftCard = GiftCard::with(['transactions.user', 'transactions.booking'])
                                          ->findOrFail($giftCardId);
        $this->showTransactionsModal = true;
    }

    public function createGiftCard()
    {
        $this->validate([
            'form.recipient_name' => 'required|string|max:255',
            'form.recipient_email' => 'required|email|max:255',
            'form.original_amount' => 'required|numeric|min:0.01|max:9999.99',
            'form.message' => 'nullable|string|max:1000',
            'form.valid_until' => 'required|date|after:today',
        ]);

        $giftCard = GiftCard::create([
            'code' => $this->generateUniqueCode(),
            'purchased_by' => auth()->id(),
            'recipient_name' => $this->form['recipient_name'],
            'recipient_email' => $this->form['recipient_email'],
            'original_amount' => $this->form['original_amount'],
            'remaining_amount' => $this->form['original_amount'],
            'message' => $this->form['message'],
            'valid_until' => $this->form['valid_until'],
            'is_active' => $this->form['is_active'],
        ]);

        // Create purchase transaction
        GiftCardTransaction::create([
            'gift_card_id' => $giftCard->id,
            'user_id' => auth()->id(),
            'transaction_type' => 'purchase',
            'amount' => $this->form['original_amount'],
            'description' => 'Gift card created',
            'transaction_date' => now(),
        ]);

        session()->flash('success', "Gift card {$giftCard->code} created successfully.");
        $this->closeModals();
    }

    public function updateGiftCard()
    {
        $this->validate([
            'form.recipient_name' => 'required|string|max:255',
            'form.recipient_email' => 'required|email|max:255',
            'form.original_amount' => 'required|numeric|min:0.01|max:9999.99',
            'form.message' => 'nullable|string|max:1000',
            'form.valid_until' => 'required|date',
        ]);

        $this->selectedGiftCard->update([
            'recipient_name' => $this->form['recipient_name'],
            'recipient_email' => $this->form['recipient_email'],
            'original_amount' => $this->form['original_amount'],
            'message' => $this->form['message'],
            'valid_until' => $this->form['valid_until'],
            'is_active' => $this->form['is_active'],
        ]);

        session()->flash('success', "Gift card {$this->selectedGiftCard->code} updated successfully.");
        $this->closeModals();
    }

    public function toggleGiftCardStatus($giftCardId)
    {
        $giftCard = GiftCard::findOrFail($giftCardId);
        $giftCard->update(['is_active' => !$giftCard->is_active]);
        
        $status = $giftCard->is_active ? 'activated' : 'deactivated';
        session()->flash('success', "Gift card {$giftCard->code} has been {$status} successfully.");
    }

    public function refundGiftCard($giftCardId)
    {
        $giftCard = GiftCard::findOrFail($giftCardId);
        
        if ($giftCard->remaining_amount > 0) {
            // Create refund transaction
            GiftCardTransaction::create([
                'gift_card_id' => $giftCard->id,
                'user_id' => auth()->id(),
                'transaction_type' => 'refund',
                'amount' => $giftCard->remaining_amount,
                'description' => 'Gift card refunded',
                'transaction_date' => now(),
            ]);

            $giftCard->update([
                'remaining_amount' => 0,
                'is_active' => false,
            ]);

            session()->flash('success', "Gift card {$giftCard->code} has been refunded successfully.");
        } else {
            session()->flash('error', "Gift card {$giftCard->code} has no remaining balance to refund.");
        }
    }

    public function extendGiftCard($giftCardId, $days = 365)
    {
        $giftCard = GiftCard::findOrFail($giftCardId);
        $giftCard->update([
            'valid_until' => $giftCard->valid_until->addDays($days)
        ]);
        
        session()->flash('success', "Gift card {$giftCard->code} extended by {$days} days.");
    }

    public function bulkAction()
    {
        if (empty($this->selectedGiftCards) || !$this->bulkAction) return;
        
        $giftCards = GiftCard::whereIn('id', $this->selectedGiftCards)->get();
        $count = 0;
        
        foreach ($giftCards as $giftCard) {
            switch ($this->bulkAction) {
                case 'activate':
                    if (!$giftCard->is_active) {
                        $giftCard->update(['is_active' => true]);
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($giftCard->is_active) {
                        $giftCard->update(['is_active' => false]);
                        $count++;
                    }
                    break;
                case 'extend':
                    $giftCard->update([
                        'valid_until' => $giftCard->valid_until->addDays(365)
                    ]);
                    $count++;
                    break;
            }
        }
        
        session()->flash('success', "Bulk action applied to {$count} gift cards.");
        $this->selectedGiftCards = [];
        $this->bulkAction = '';
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDetailModal = false;
        $this->showTransactionsModal = false;
        $this->selectedGiftCard = null;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->form = [
            'code' => '',
            'recipient_name' => '',
            'recipient_email' => '',
            'original_amount' => '',
            'message' => '',
            'valid_until' => '',
            'is_active' => true,
        ];
    }

    private function generateUniqueCode()
    {
        do {
            $code = 'GC' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8));
        } while (GiftCard::where('code', $code)->exists());
        
        return $code;
    }

    #[On('gift-card-created')]
    #[On('gift-card-updated')]
    #[On('closeModals')]
    public function refreshList()
    {
        $this->closeModals();
    }

    public function render()
    {
        $giftCards = GiftCard::query()
            ->when($this->search, function ($query) {
                $query->where('code', 'like', '%' . $this->search . '%')
                      ->orWhere('recipient_name', 'like', '%' . $this->search . '%')
                      ->orWhere('recipient_email', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                switch ($this->statusFilter) {
                    case 'active':
                        $query->active();
                        break;
                    case 'expired':
                        $query->expired();
                        break;
                    case 'fully_redeemed':
                        $query->fullyRedeemed();
                        break;
                    case 'inactive':
                        $query->where('is_active', false);
                        break;
                }
            })
            ->withCount(['transactions'])
            ->with(['purchaser'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $stats = [
            'total' => GiftCard::count(),
            'active' => GiftCard::active()->count(),
            'expired' => GiftCard::expired()->count(),
            'fully_redeemed' => GiftCard::fullyRedeemed()->count(),
            'total_value' => GiftCard::sum('original_amount'),
            'remaining_value' => GiftCard::sum('remaining_amount'),
            'total_transactions' => GiftCardTransaction::count(),
        ];

        $recentTransactions = GiftCardTransaction::with(['giftCard', 'user', 'booking'])
                                                ->recent()
                                                ->orderBy('transaction_date', 'desc')
                                                ->limit(10)
                                                ->get();

        return view('livewire.admin.gift-cards.gift-cards-index', compact('giftCards', 'stats', 'recentTransactions'));
    }
}
