<?php

namespace App\Modules\TransactionModule\Services;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Http\Resources\TransactionResource;

class TransactionUpdateService
{
    public function updateTransaction(Request $request)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'transaction_id' => 'required|exists:transactions,id',
                'bill_type' => 'sometimes|required|string|max:255',
                'amount_due' => 'sometimes|required|numeric',
                'amount_paid' => 'nullable|numeric',
                'description' => 'nullable|string',
                'payment_method' => 'sometimes|required|string|max:255',
                'transaction_reference' => 'sometimes|required|string|max:255',
                'status' => 'sometimes|required|string|in:pending,completed,cancelled',
                'due_date' => 'sometimes|required|date',
            ]);

            // If validation fails, return an error response
            if ($validator->fails()) {
                return ResponseHelper::error(
                    message: "Validation failed",
                    error: $validator->errors()->toArray()
                );
            }

            $transaction = Transaction::find($request->transaction_id);

            if (!$transaction) {
                return ResponseHelper::notFound(message: "Transaction not found");
            }

            // Update the transaction
            $transaction->update($request->only([
                'bill_type',
                'amount_due',
                'amount_paid',
                'description',
                'payment_method',
                'transaction_reference',
                'status',
                'due_date',
            ]));

            return ResponseHelper::success(
                message: "Transaction updated successfully"
            );
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }
}
