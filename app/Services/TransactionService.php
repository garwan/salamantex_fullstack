<?php

namespace App\Services;

use App\Enums\CurrencyType;
use App\Enums\TransactionError;
use App\Enums\TransactionStateType;
use App\Jobs\ProcessTransaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    private UserService $_userService;

    public function __construct(UserService $userService)
    {
        $this->_userService = $userService;
    }

    public function createTransaction($data)
    {
        try {
            $user = auth()->user();

            $transaction = new Transaction(
                [
                    ...$data->toArray(),
                    'target_id' => (int)$data->target_id,
                    'source_id' => $user->id,
                    'state' => TransactionStateType::IN_QUEUE
                ]
            );

            if (!$this->_userService->userHasSufficientBalance($transaction, $user)) {
                throw new \Exception(TransactionError::INSUFFICIENT_BALANCE->value);
            }

            DB::beginTransaction();

            $transaction->save();

            $transaction->users()->attach($transaction->target_id);
            $transaction->users()->attach($transaction->source_id);

            DB::commit();

            $this->dispatchTransaction($transaction);

            return [
                'new_transaction_id' => $transaction->id
            ];
        } catch (\Throwable $th) {
            DB::rollBack();

            return [
                'error' => $th->getMessage(),
            ];
        }
    }

    public function dispatchTransaction(Transaction $transaction)
    {
        return ProcessTransaction::dispatch($transaction);
    }

    public function canTransactionBeExecuted(Transaction $transaction)
    {
        $source = $transaction->sourceUser;
        $target = $transaction->targetUser;

        switch ($transaction->currency_type) {
            case CurrencyType::Bitcoin:
                return $source->bitcoinWallet()->exists() &&
                    $target->bitcoinWallet()->exists();

            case CurrencyType::Ethereum:
                return $source->ethereumWallet()->exists() &&
                    $target->ethereumWallet()->exists();

            default:
                return false;
        }

        return false;
    }

    public function proccessTransaction(Transaction $transaction)
    {
        $log_error_msg = null;
        $transaction->load('sourceUser', 'targetUser');

        try {
            if (!$this->canTransactionBeExecuted($transaction)) {
                throw new \Exception(TransactionError::WALLET_NOT_FOUND->name);
            }
            $transaction->setStateInProgress();

            if (!$this->_userService->userHasSufficientBalance($transaction)) {
                throw new \Exception(TransactionError::INSUFFICIENT_BALANCE->name);
            }

            DB::beginTransaction();
            if (!$this->executeTransaction($transaction)) {
                throw new \Exception(TransactionError::EXECUTE_ERROR->name);
            }
            DB::commit();

            $transaction->setStateComplete();
        } catch (\Throwable $th) {
            DB::rollBack();
            $transaction->setStateAborted();
            $log_error_msg = $th->getMessage();
        }

        $this->logTransaction($transaction, $log_error_msg);

        return $transaction;
    }

    public function logTransaction(Transaction $transaction, $log_error_msg = null)
    {
        $log_msg = "Transaction #$transaction->id ( User#{$transaction->source_id} -> {$transaction->amount} {$transaction->currency_type->value} -> User#{$transaction->target_id} ) was {$transaction->state->value}!";

        if (!is_null($log_error_msg) && is_string($log_error_msg)) {
            $log_msg .= " | {$log_error_msg}";
        }

        Log::channel('transaction')
            ->info(
                $log_msg
            );
    }

    public function executeTransaction(Transaction $transaction)
    {
        try {
            $this->_userService->subtractAmountFromUserWallet($transaction);
            $this->_userService->addAmountToUserWallet($transaction);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
