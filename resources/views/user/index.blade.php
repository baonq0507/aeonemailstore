@extends('layouts.app')
@section('title', 'Tài khoản')
@push('css')
<style>
    .header {
        background: linear-gradient(147deg, #bbb5e9, #9991d1 74%);
    }

    body {
        background-color: #f5f5f5;
    }

    .main {
        background-color: #fff;
    }

    hr {
        margin: 10px 0;
    }
</style>
@endpush
@section('content')
<div class="">
    <div class="">
        <div class="header p-3 py-2">
            <div class="row">
                <div class="col-3 text-center position-relative">
                    <img id="preview-avatar" class="rounded-circle" src="{{ is_null(auth()->user()->avatar) ? asset('images/avat.png') : asset('storage/' . auth()->user()->avatar) }}" alt="logo" width="70" height="70">
                    <div class="position-absolute start-50 translate-middle rounded-circle py-1 px-2" id="avatar">
                        <i class="fa fa-camera text-white"></i>
                    </div>
                    <input type="file" name="avatar" id="input-avatar" hidden>
                </div>
                <div class="col-6">
                    <p class="fw-bold mb-0">{{ auth()->user()->full_name }}</p>
                    <p class="fs-12 mb-0">
                        <img src="{{ asset($level->image) }}" alt="logo" width="100" height="30">
                    </p>
                    <p class="mb-0">
                        <span class="fs-12 ">{{ __('mess.invite_code') }}: {{ auth()->user()->invite_code }}</span>
                    </p>
                </div>
                <div class="col-3">
                    <a href="{{ route('deposit.index') }}" class="btn btn-warning w-100 fs-12 mb-2">{{ __('mess.deposit') }}</a>
                    <a href="{{ route('withdraw.index') }}" class="btn btn-warning w-100 fs-12">{{ __('mess.withdraw') }}</a>
                </div>
            </div>
        </div>
        <div class="main my-3 p-2">
            <h5 class="fw-bold mb-0">{{ __('mess.order_history') }}</h5>
            <hr>
            <div class="row justify-content-between">
                <div class="col-6">
                    <a href="{{ route('order.index', ['status' => 'all']) }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/history-icon.png') }}" alt="logo" width="30" height="30">
                        <span class="fs-12 fw-bold">{{ __('mess.order_history') }}</span>
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('mission.index') }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/sandon-icon.png') }}" alt="logo" width="30" height="30">
                        <span class="fs-12 fw-bold">{{ __('mess.start_order') }}</span>
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('invite.index') }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/nhom-icon.png') }}" alt="logo" width="30" height="30">
                        <span class="fs-12 fw-bold">{{ __('mess.my_group') }}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="main container my-3 py-2">
            <h5 class="fw-bold">{{ __('mess.account_balance') }}: <span class="text-warning">$ {{ auth()->user()->balance }}</span></h5>
            <hr>
            <div class="row justify-content-between">
                <div class="col-6 text-center">
                    <a href="{{ route('giaodich.index', ['type' => 'deposit']) }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/histroy-naptien.png') }}" alt="logo" width="30" height="30">
                    </a>
                    <p class="fs-12 fw-bold text-center">{{ __('mess.deposit_history') }}</p>

                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('giaodich.index', ['type' => 'withdraw']) }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/history-ruttien.png') }}" alt="logo" width="30" height="30">
                    </a>
                    <p class="fs-12 fw-bold text-center">{{ __('mess.withdraw_history') }}</p>

                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('giaodich.index', ['type' => 'withdraw']) }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/chitietthuchi.png') }}" alt="logo" width="30" height="30">
                    </a>
                    <p class="fs-12 fw-bold text-center">{{ __('mess.financial_details') }}</p>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('password.index') }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/matkhauvon.png') }}" alt="logo" width="30" height="30">
                    </a>
                    <p class="fs-12 fw-bold text-center">{{ __('mess.capital_password') }}</p>
                </div>
            </div>
        </div>
        <div class="main container my-3 py-2">
            <h5 class="fw-bold">{{ __('mess.personal_information') }}</h5>
            <hr>
            <div class="row justify-content-between">
                <div class="col-6 text-center">
                    <a href="{{ route('bank.index') }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/thenganhang.png') }}" alt="logo" width="30" height="30">
                    </a>
                    <p class="fs-12 fw-bold text-center">{{ __('mess.bank_card') }}</p>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('level.index') }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/capbachoivien.png') }}" alt="logo" width="30" height="30">
                    </a>
                    <p class="fs-12 fw-bold text-center">{{ __('mess.member_level') }}</p>

                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('address.index') }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/diachinhanhang.png') }}" alt="logo" width="30" height="30">
                    </a>
                    <p class="fs-12 fw-bold text-center">{{ __('mess.shipping_address') }}</p>
                </div>
                <div class="col-6">
                    <p class="text-center mb-0">
                        <img src="{{ asset('images/tinnhanhethong.png') }}" alt="logo" width="30" height="30">
                    </p>
                    <p class="fs-12 fw-bold text-center">{{ __('mess.system_message') }}</p>
                </div>
            </div>
        </div>
        <div class="main container my-3 py-2">
            <h5 class="fw-bold">{{ __('mess.customer_service') }}</h5>
            <hr>
            <div class="row justify-content-between">
                <div class="col-6">
                    <p class="text-center mb-0" id="customer-service">
                        <img src="{{ asset('images/lhcskh.png') }}" alt="logo" width="30" height="30">
                    </p>
                    <p class="fs-12 fw-bold text-center">{{ __('mess.customer_service') }}</p>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('feedback.index') }}" class="text-decoration-none text-dark">
                        <img src="{{ asset('images/ykienphanhoi.png') }}" alt="logo" width="30" height="30">
                    </a>
                    <p class="fs-12 fw-bold text-center">{{ __('mess.feedback') }}</p>
                </div>
            </div>
        </div>
        <div class="main container py-3 mb-3">
            <div class="row align-items-center">
                <div class="col-6">
                    <p class="text-center mb-0 fw-bold">
                        {{ __('mess.country_region') }}
                    </p>
                </div>
                <div class="col-6">
                    <select name="lang" id="lang" class="form-select">
                        <option value="ja" @if(config('app.locale')=='ja' ) selected @endif>{{ __('mess.Japanese') }}</option>
                        <option value="zh" @if(config('app.locale')=='zh' ) selected @endif>{{ __('mess.Chinese') }}</option>
                        <option value="ko" @if(config('app.locale')=='ko' ) selected @endif>{{ __('mess.Korean') }}</option>
                        <option value="en" @if(config('app.locale')=='en' ) selected @endif>{{ __('mess.English') }}</option>
                        <option value="vi" @if(config('app.locale')=='vi' ) selected @endif>{{ __('mess.Vietnamese') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="main container py-3" style=" margin-bottom: 100px;">
            <div class="row align-items-center">
                <div class="col-6">
                    <p class="text-center mb-0 fw-bold">
                        {{ __('mess.login_password') }}
                    </p>
                </div>
                <div class="col-6 text-end">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">{{ __('mess.logout') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
@endsection
@push('script')
<script>
    $('#lang').change(function() {
        window.location.href = '/change-lang?lang=' + $(this).val();
    });
    $('#avatar').click(function() {
        $('#input-avatar').click();
    });
    $('#input-avatar').change(function(e) {

        // validate file
        if (e.target.files[0].size > 1024 * 1024) {
            alert("{{ __('mess.file_size_must_be_less_than_1mb') }}");
            return;
        }

        // validate file type
        if (!e.target.files[0].type.match('image/*')) {
            alert("{{ __('mess.file_type_must_be_image') }}");
            return;
        }
        $('#preview-avatar').attr('src', URL.createObjectURL(e.target.files[0]));

        // upload file
        const formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('avatar', e.target.files[0]);
        $.ajax({
            url: `{{ route('user.update-avatar') }}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: "{{ __('mess.avatar_save_success') }}",
                });
                setTimeout(() => {
                    window.location.reload();
                }, 2500);
            },
            error: function(error) {
                console.log(error);
                Swal.fire({
                    title: "{{ __('mess.error') }}",
                    text: error.responseJSON.message,
                });
            }
        });


    });
</script>
@endpush
