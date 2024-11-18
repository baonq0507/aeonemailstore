@extends('layouts.app')
@section('title', __('mess.transaction_history'))
@section('content')
<div class="container mt-3">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ $type == 'deposit' ? 'active text-white' : 'text-dark' }}" href="{{ route('transaction.index', ['type' => 'deposit']) }}">{{ __('mess.deposit_history') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $type == 'withdraw' ? 'active text-white' : 'text-dark' }}" href="{{ route('transaction.index', ['type' => 'withdraw']) }}">{{ __('mess.withdraw_history') }}</a>
        </li>
    </ul>
    <hr>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center fs-13">{{ __('mess.time') }}</th>
                <th class="text-center fs-13">{{ __('mess.fluctuation') }}</th>
                <th class="text-center fs-13">{{ __('mess.status') }}</th>
            </tr>
        </thead>
        <tbody>
            @if ($transactions->isEmpty())
                <tr>
                    <td colspan="3" class="text-center fs-13">{{ __('mess.no_data') }}</td>
                </tr>
            @endif
            @foreach ($transactions as $transaction)
            <tr>
                <td class="text-center fs-13">{{ $transaction->created_at }}</td>
                <td class="text-center fs-13">
                    <span class="badge {{ $transaction->amount > 0 ? 'bg-success' : 'bg-danger' }}">{{ $type == 'deposit' ? '+' : '-' }}{{ number_format($transaction->amount) }}</span>
                </td>
                <td class="text-center fs-13">
                    <span class="badge {{ $transaction->status == 'success' ? 'bg-success' : ($transaction->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">{{ $transaction->status == 'success' ? __('mess.success') : ($transaction->status == 'pending' ? __('mess.pending') : __('mess.failed')) }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('includes.footer')
@endsection
