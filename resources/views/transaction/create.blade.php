<div class="card-body">
    <form method="POST" action="{{ route('create.transaction') }}">
         @csrf

         <div class="row mb-3">
             <label for="target_id" class="col-md-4 col-form-label text-md-end">{{ __('Target') }}</label>

             <div class="col-md-6">
                 <select 
                     name="target_id" 
                     id="target_id" 
                     class="form-control @error('target_id') is-invalid @enderror"
                     name="target_id" 
                     value="{{ old('target_id') }}" 
                     required>
                     @foreach ($data->users as $user)
                         <option value="{{$user['id']}}">{{$user['name']}}</option>
                     @endforeach
                 </select>
         
                 @error('target_id')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror
             </div>
         </div>

         <div class="row mb-3">
             <label for="currency_type" class="col-md-4 col-form-label text-md-end">{{ __('Currency type') }}</label>

             <div class="col-md-6">
                 <select 
                     name="currency_type" 
                     id="currency_type" 
                     class="form-control @error('currency_type') is-invalid @enderror"
                     name="currency_type" 
                     value="{{ old('currency_type') }}" 
                     required>
                     @foreach ($data->currencies as $currency_key => $currency)
                         <option value="{{$currency_key}}">{{$currency}}</option>
                     @endforeach
                 </select>
         
                 @error('currency_type')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror
             </div>
         </div>

         <div class="row mb-3">
             <label for="amount" class="col-md-4 col-form-label text-md-end">{{ __('Currency amount') }}</label>

             <div class="col-md-6">
                 <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required>

                 @error('amount')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror
             </div>
         </div>

         <button type="submit">Submit</button>
    </form>
 </div>