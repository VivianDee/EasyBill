<?php

namespace App\Modules\TransactionModule;

use App\Modules\TransactionModule\Services\TransactionCreationService;
use App\Modules\TransactionModule\Services\TransactionRetrievalService;
use App\Modules\TransactionModule\Services\TransactionUpdateService;
use App\Modules\TransactionModule\Services\TransactionDeletionService;
use Illuminate\Http\Request;

class TransactionModule
{
    public $transactionRetrievalService;
    public $transactionUpdateService;
    public $transactionDeletionService;
    public $transactionCreationService;

    // Constructor to initialize services
    public function __construct(
        TransactionCreationService $transactionCreationService, 
        TransactionRetrievalService $transactionRetrievalService, 
        TransactionUpdateService $transactionUpdateService, 
        TransactionDeletionService $transactionDeletionService
    ) {
        $this->transactionCreationService = $transactionCreationService;
        $this->transactionRetrievalService = $transactionRetrievalService;
        $this->transactionUpdateService = $transactionUpdateService;
        $this->transactionDeletionService = $transactionDeletionService;
    }

    // Handles creating a transaction
    public function createTransaction(Request $request) {
        return $this->transactionCreationService->createTransaction($request);
    }

    // Handles retrieving a single transaction
    public function getTransaction(Request $request) {
        return $this->transactionRetrievalService->getTransaction($request);
    }

    // Handles retrieving all transactions
    public function getAllTransactions() {
        return $this->transactionRetrievalService->getAllTransactions();
    }

    // Handles updating a transaction
    public function updateTransaction(Request $request) {
        return $this->transactionUpdateService->updateTransaction($request);
    }

    // Handles deleting a transaction
    public function deleteTransaction(Request $request) {
        return $this->transactionDeletionService->deleteTransaction($request);
    }
}
