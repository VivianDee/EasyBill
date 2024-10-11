<?php

namespace App\Modules\TransactionModule\Services;

use App\Helpers\ResponseHelper;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionCreationService
{
    public function createTransaction(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'bill_type' => 'required|string|max:255',
                'amount_due' => 'required|numeric',
                'amount_paid' => 'nullable|numeric',
                'description' => 'nullable|string',
                'payment_method' => 'required|string|max:255',
                'transaction_reference' => 'required|string|max:255|unique:transactions',
                'status' => 'required|string|in:pending,completed,cancelled',
                'due_date' => 'required|date',
            ]);

            // If validation fails, return an error response
            if ($validator->fails()) {
                return ResponseHelper::error(
                    message: "Validation failed",
                    error: $validator->errors()->toArray()
                );
            }

            $user = $request->user();


            if (!$user) {
                return ResponseHelper::notFound(
                    message: "User not found"
                );
            }

            // Create the transaction
            $transaction = $user->transactions()->create($request->only([
                'bill_type',
                'amount_due',
                'amount_paid',
                'description',
                'payment_method',
                'transaction_reference',
                'status',
                'due_date',
            ]));
            
            if (!$transaction) {
                return ResponseHelper::error(
                    message: "Transaction creation failed"
                );
            }

            return ResponseHelper::created(
                message: "Transaction created successfully",
                data: new TransactionResource($transaction)
            );
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }
}
