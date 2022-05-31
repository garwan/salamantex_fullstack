<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private TransactionService $_transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->_transactionService = $transactionService;
    }

    public function createTransaction(CreateTransactionRequest $request)
    {
        $this->_transactionService->createTransaction($request);

        return redirect()->back();
    }
}
