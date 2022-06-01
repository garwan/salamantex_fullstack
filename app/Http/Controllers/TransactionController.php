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
        $msgs = $this->_transactionService->createTransaction($request);

        if (isset($msgs['error'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $msgs['error']
                );
        }

        return redirect()->back();
    }
}
