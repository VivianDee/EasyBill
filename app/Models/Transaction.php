<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
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

    protected $casts = [
        'amount_due' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'due_date' => 'date',
    ];

    // Relationship to the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
