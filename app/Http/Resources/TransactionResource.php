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
            'user_id',
            'bill_type',
            'amount_due',
            'amount_paid',
            'description',
            'payment_method',
            'transaction_reference',
            'status',
            'due_date',
        ];
    }
}
