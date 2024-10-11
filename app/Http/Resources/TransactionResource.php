<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'bill_type' => $this->bill_type,
            'amount_due' => (float) $this->amount_due,
            'amount_paid' => (float) $this->amount_paid,
            'description' => $this->description,
            'payment_method' => $this->payment_method,
            'transaction_reference' => $this->transaction_reference,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
