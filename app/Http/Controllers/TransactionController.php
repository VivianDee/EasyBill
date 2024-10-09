<?php

namespace App\Http\Controllers;

use App\Modules\TransactionModule\TransactionModule;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public $transactionModule;

    public function __construct(TransactionModule $transactionModule)
    {
        $this->transactionModule = $transactionModule;
    }

    // Create a new transaction
    public function createTransaction(Request $request)
    {
        return $this->transactionModule->createTransaction($request);
    }

    // Get a single transaction
    public function getTransaction(Request $request, $id)
    {
        return $this->transactionModule->getTransaction($request->merge(['id' => $id]));
    }

    // Get all transactions
    public function getAllTransactions(Request $request)
    {
        return $this->transactionModule->getAllTransactions();
    }

    // Update a transaction
    public function updateTransaction(Request $request, $id)
    {
        return $this->transactionModule->updateTransaction($request->merge(['id' => $id]));
    }

    // Delete a transaction
    public function deleteTransaction(Request $request, $id)
    {
        return $this->transactionModule->deleteTransaction($request->merge(['id' => $id]));
    }
}
