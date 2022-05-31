
<div class="card-body row">

    @foreach ($data->currencies as $currency_key => $currency)

        @if ($data->user->wallets[$currency_key])

            <div class="col-6">
                <div class="row mb-3">
                    <label for="address-{{$currency_key}}" class="col-md-4 col-form-label text-md-end">{{ __("$currency_key wallet") }}</label>

                    <div class="col-md-6">
                        <input disabled id="address-{{$currency_key}}" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{$data->user->wallets[$currency_key]->address}}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="balance-{{$currency_key}}" class="col-md-4 col-form-label text-md-end">{{ __("$currency_key balance") }}</label>

                    <div class="col-md-6">
                        <input disabled id="balance-{{$currency_key}}" type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{$data->user->wallets[$currency_key]->balance}}" required>
                    </div>
                </div>
            </div>

        @else

            <form class="col-6" method="POST" action="{{ route('assign.wallet.to.user') }}">
                @csrf

                <input type="hidden" name="wallet_type" value="{{ $currency_key }}">

                <div class="row mb-3">
                    <label for="address" class="col-md-4 col-form-label text-md-end">{{ __("$currency_key wallet") }}</label>

                    <div class="col-md-6">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('amount') }}" required>

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="balance" class="col-md-4 col-form-label text-md-end">{{ __("$currency_key balance") }}</label>

                    <div class="col-md-6">
                        <input id="balance" type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance') }}" required>

                        @error('balance')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <button type="submit">Submit</button>
            </form>
            
        @endif

    @endforeach

</div>
