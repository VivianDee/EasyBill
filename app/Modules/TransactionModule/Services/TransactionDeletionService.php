<?php

namespace App\Modules\TransactionModule\Services;

use App\Helpers\ResponseHelper;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionDeletionService
{
    public function deleteTransaction(Request $request)
    {
        $transaction_id = $request->route('id');

        $transaction = Transaction::findOrFail($transaction_id);


        if (!$transaction) {
            return ResponseHelper::notFound(
                message: "Transaction not found"
            );
        }


        $transaction->delete();

        return ResponseHelper::success(
            message: "Transaction deleted successfully"
        );
    }
}
