@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Transacciones</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $transaction->reference }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">@lang('transactions.' . $transaction->transaction_status)</h6>
                    <p class="card-text">{{ $transaction->payer['name'] }}</p>
                    <p class="card-text">{{ $transaction->payer['email'] }}</p>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $transaction->total }}</h6>
                    @if ($transaction->couldPay())
                        <a href="{{ route('payments.retry', ['reference' => $transaction->reference]) }}" class="btn btn-primary">Reintentar</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection