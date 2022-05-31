<?php

namespace App\Services;

use App\Enums\CurrencyType;
use App\Enums\TransactionStateType;
use App\Jobs\ProcessTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
                throw new \Exception('Insufficient funds');
            }

            DB::beginTransaction();

            $transaction->save();

            $transaction->users()->attach($transaction->target_id);
            $transaction->users()->attach($transaction->source_id);

            DB::commit();

            $this->dispatchTransaction($transaction);

            return redirect()->back()->with(
                'new_transaction_id',
                $transaction->id
            );
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return null;
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
        $transaction->load('sourceUser', 'targetUser');
        try {
            if (!$this->canTransactionBeExecuted($transaction)) {
                throw new \Exception('xx');
            }
            $transaction->setStateInProgress();

            if (!$this->_userService->userHasSufficientBalance($transaction)) {
                throw new \Exception('xx');
            }

            DB::beginTransaction();
            if (!$this->executeTransaction($transaction)) {
                throw new \Exception('xx');
            }
            DB::commit();

            $transaction->setStateComplete();
        } catch (\Throwable $th) {
            DB::rollBack();
            $transaction->setStateAborted();
        }

        return $transaction;
    }

    public function executeTransaction(Transaction $transaction)
    {
        try {
            $this->_userService->subtractAmountFromUserWallet($transaction);
            $this->_userService->addAmountToUserWallet($transaction);
            return true;
        } catch (\Throwable $th) {
        }

        return false;
    }
}
