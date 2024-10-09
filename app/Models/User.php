<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'first_name',
        'last_name',
        'password',
        'ip_address',
        'account_type',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'ip_address',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship to transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Method to get total amount due across all transactions
    public function getTotalAmountDueAttribute()
    {
        return $this->transactions()->where('status', 'pending')->sum('amount_due');
    }

    // Method to get total amount paid across all transactions
    public function getTotalAmountPaidAttribute()
    {
        return $this->transactions()->sum('amount_paid');
    }

    // Method to get the count of pending transactions
    public function getPendingTransactionsCountAttribute()
    {
        return $this->transactions()->where('status', 'pending')->count();
    }

    // Optional: Method to check if user has pending transactions
    public function hasPendingTransactions()
    {
        return $this->transactions()->where('status', 'pending')->exists();
    }
}
