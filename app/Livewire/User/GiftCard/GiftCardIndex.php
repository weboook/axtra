<?php

namespace App\Livewire\User\GiftCard;

use App\Models\GiftCard;
use Livewire\Component;
use Livewire\WithPagination;

class GiftCardIndex extends Component
{
    use WithPagination;

    public $showPurchaseForm = false;
    public $recipientName = '';
    public $recipientEmail = '';
    public $amount = 50;
    public $message = '';
    public $giftCardCode = '';

    protected $rules = [
        'recipientName' => 'required|string|max:255',
        'recipientEmail' => 'required|email|max:255',
        'amount' => 'required|numeric|min:10|max:1000',
        'message' => 'nullable|string|max:500',
    ];

    public function purchaseGiftCard()
    {
        $this->validate();

        $giftCard = GiftCard::create([
            'code' => $this->generateCode(),
            'purchased_by' => auth()->id(),
            'recipient_name' => $this->recipientName,
            'recipient_email' => $this->recipientEmail,
            'original_amount' => $this->amount,
            'remaining_amount' => $this->amount,
            'message' => $this->message,
            'valid_until' => now()->addYear(),
            'is_active' => true,
        ]);

        $this->giftCardCode = $giftCard->code;
        $this->reset(['recipientName', 'recipientEmail', 'amount', 'message', 'showPurchaseForm']);
        
        session()->flash('giftCardPurchased', 'Gift card purchased successfully!');
    }

    public function showPurchaseModal()
    {
        $this->showPurchaseForm = true;
        $this->reset(['recipientName', 'recipientEmail', 'amount', 'message']);
        $this->amount = 50;
    }

    public function closePurchaseModal()
    {
        $this->showPurchaseForm = false;
        $this->resetValidation();
    }

    private function generateCode()
    {
        do {
            $code = 'GC-' . strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 8));
        } while (GiftCard::where('code', $code)->exists());

        return $code;
    }

    public function render()
    {
        $purchasedGiftCards = GiftCard::where('purchased_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user.gift-card.gift-card-index', [
            'purchasedGiftCards' => $purchasedGiftCards,
        ]);
    }
}
