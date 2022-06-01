@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body row">
                    @isset($transaction_status)
                        <div class="alert alert-info" role="alert">
                            Transaction status: {{$transaction_status}}
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Transaction not found
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
