<?php

namespace App\Http\Controllers;

use App\Enums\CurrencyWalletModelType;
use App\Models\User;
use App\Services\CurrencyService;
use App\Services\UserService;
use App\Services\WalletService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private CurrencyService $_currencyService;
    private UserService $_userService;
    private WalletService $_walletService;

    public function __construct(
        CurrencyService $currencyService,
        UserService $userService,
        WalletService $walletService
    ) {
        $this->_currencyService = $currencyService;
        $this->_userService = $userService;
        $this->_walletService = $walletService;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addWalletToUser(Request $request)
    {
        $model = $this->_walletService->getWalletModelByType($request->wallet_type);

        if (!in_array(\get_class($model), CurrencyWalletModelType::cases())) {
            $model->address = $request->address;
            $model->balance = $request->balance;
            $model->user_id = auth()->id();
            $model->save();
        }

        return redirect()->back();
    }

    /**
     * Show the user transaction history.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getUserTransactionHistory(Request $request, User $user)
    {
        $data = collect(
            [
                'success' => true,
                'transactions' => [],
                'users' => [],
                'currencies' => [],
                'user' => new User(),
            ]
        );

        try {
            if (!$user->id) {
                $user = auth()->user();
            }
            if (!$user->id) {
                throw new \Throwable('User is not logged in');
            }

            $user->load('transactions', 'bitcoinWallet', 'ethereumWallet');

            $data->users = User::where('id', '!=', auth()->id())->get();
            $data->transactions = $user->transactions->toArray();
            $data->currencies = $this->_currencyService->getListOfCurrencies();
            $user->wallets = $this->_userService->getUserWallets($user);

            $data->user = $user;
        } catch (\Throwable $th) {
            $data->message = "Transactions for user {$user->id} were unable to load.";
            $data->success = false;
        }

        return view('user.detail')->with(['data' => $data]);
    }
}
