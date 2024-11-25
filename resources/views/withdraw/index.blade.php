@extends('layouts.app')
@section('title', __('mess.withdraw'))
@push('css')
<style>
    body {
        background-color: rgb(242 242 242/1)
    }

    #amount,
    #password2 {
        border: none;
        outline: none;
        background-color: rgb(242 242 242 / 1);
        padding: 5px;
        border-radius: 5px;
    }
</style>
@endpush
@section('content')
<div class="container">
    <div class="card my-3">
        <div class="card-body">
            <h5>{{ __('mess.account_balance') }}: <span class="fw-bold text-warning"> ${{ auth()->user()->balance}}</span></h5>
            <p>{{ __('mess.account_balance_locked') }}: <span class="fw-bold text-warning"> ${{ auth()->user()->balance_lock}}</span></p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-6">
                    <p>{{ __('mess.phone_number') }}:</p>
                </div>
                <div class="col-6 text-end">
                    <p>{{ substr(auth()->user()->phone_number, 0, 3) . '****' . substr(auth()->user()->phone_number, -4) }}</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-6">
                    <p>{{ __('mess.bank_account') }}:</p>
                </div>
                <div class="col-6 text-end">
                    <p>{{ substr(auth()->user()->bank_number, 0, 4) . '****' . substr(auth()->user()->bank_number, -4) }}</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-6">
                    <p>{{ __('mess.bank_name') }}:</p>
                </div>
                <div class="col-6 text-end">
                    <p>{{ auth()->user()->bank_name }}</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-6">
                    <p>{{ __('mess.full_name') }}:</p>
                </div>
                <div class="col-6 text-end">
                    <p>{{ auth()->user()->full_name }}</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-6">
                    <p>{{ __('mess.enter_amount') }}:</p>
                </div>
                <div class="col-6 text-end">
                    <p contenteditable="true" id="amount"></p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-6">
                    <p>{{ __('mess.password2') }}:</p>
                </div>
                <div class="col-6 text-end">
                    <p contenteditable="true" id="password2"></p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-secondary w-100" id="withdraw_btn">{{ __('mess.withdraw') }}</button>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
@push('script')
<script>
    $(document).ready(function() {

        $('#withdraw_btn').click(function() {
            console.log('click');
            $('#withdraw_btn').prop('disabled', true);
            //loading
            $('#withdraw_btn').html('<i class="fa fa-spinner fa-spin"></i>');
            let amount = $('#amount').text();
            let password2 = $('#password2').text();
            let csrf = "{{ csrf_token() }}";
            post("{{ route('withdraw.store') }}", {
                amount,
                password2,
                _token: csrf
            }).then(function(response) {
                Swal.fire({
                    title: 'Thông báo',
                    text: response.message,
                    icon: 'success',
                });
                setTimeout(function() {
                    window.location.href = "{{ route('giaodich.index', ['type' => 'withdraw']) }}";
                }, 1500);
            }).catch(function(error) {
                Swal.fire({
                    title: 'Thông báo',
                    text: error.responseJSON.message,
                    icon: 'error',
                });
            }).finally(function() {
                $('#withdraw_btn').prop('disabled', false);
                $('#withdraw_btn').html("{{ __('mess.withdraw') }}");
            });
        });
    });
</script>
@endpush
