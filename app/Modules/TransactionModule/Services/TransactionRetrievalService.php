<?php

namespace App\Modules\TransactionModule\Services;

use App\Helpers\ResponseHelper;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionRetrievalService
{
    public function getTransaction(Request $request)
    {
        try {
            $transaction_id = $request->route('id');

            $transaction = Transaction::find($transaction_id);


            if (!$transaction) {
                return ResponseHelper::notFound(
                    message: "Transaction not found"
                );
            }


            return ResponseHelper::success(
                message: "Transaction details retrieved successfully",
                data: new TransactionResource($transaction)
            );
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }

    public function getAllTransactions()
    {
        try {

            $transactions = Transaction::all();

            if (empty($transactions)) {
                return ResponseHelper::notFound(
                    message: "No Transactions found"
                );
            }

            return ResponseHelper::success(
                message: "Transaction retrieved successfully",
                data: TransactionResource::collection($transactions)
            );
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }
}
