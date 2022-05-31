@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                @if (session('new_transaction_id'))
                    <div class="alert alert-success" role="alert">
                        Transaction #{{ session('new_transaction_id') }} was created.
                    </div>
                @endif

                @include('user.wallets', ['data' => $data])

                <hr>
               
                @include('transaction.create', ['data' => $data])

                <hr>

                @include('user.transaction.history', ['transactions' => $data->transactions])
            </div>
        </div>
    </div>
</div>
@endsection
