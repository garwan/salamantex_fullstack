<div class="card-body">
    <h2>Transaction history</h2>
    <div class="row justify-content-center">
        <div class="col-md-3 fs-4"><b>#</b></div>
        <div class="col-md-3 fs-4"><b>Amount</b></div>
        <div class="col-md-3 fs-4"><b>Currency</b></div>
        <div class="col-md-3 fs-4"><b>State</b></div>
    </div>
    <hr class="border-2 py-1">
    @foreach ($transactions as $transaction)
        <div class="row justify-content-center py-1"
            data-bs-toggle="tooltip" 
            data-bs-placement="top"
            title="Transaction User#{{$transaction['source_id']}} sent {{ $transaction['amount'] }} {{ $transaction['currency_type'] }} to User#{{$transaction['target_id']}}"
        >
            <div class="col-md-3">{{ $transaction['id'] }}</div>
            <div class="col-md-3">{{ $transaction['amount'] }}</div>
            <div class="col-md-3">{{ $transaction['currency_type'] }}</div>
            <div class="col-md-3">{{ $transaction['state'] }}</div>
        </div>
        <hr>
    @endforeach
</div>