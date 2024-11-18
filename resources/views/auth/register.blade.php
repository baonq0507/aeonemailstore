@extends('layouts.app')

@push('css')
<style>
    .wrapper {
        width: 100%;
        height: 100vh;
        background-image: url("{{ asset('images/bg-login.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }

    .center {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 400px;
    }

    .form-select {
        width: 150px
    }

    div.lang {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
@endpush
@section('content')
<div class="wrapper">
    <!-- //select lang -->
    <div class="lang">
        <select name="lang" id="lang" class="form-select">
            <option name="ja" value="ja" @if(session('lang')=='ja' ) selected @endif>{{ __('mess.Japanese') }}</option>
            <option name="zh" value="zh" @if(session('lang')=='zh' ) selected @endif>{{ __('mess.Chinese') }}</option>
            <option name="ko" value="ko" @if(session('lang')=='ko' ) selected @endif>{{ __('mess.Korean') }}</option>
            <option name="en" value="en" @if(session('lang')=='en' ) selected @endif>{{ __('mess.English') }}</option>
        </select>
    </div>

    <div class="center">
        <h1 class="text-center">{{ __('mess.register')}}</h1>
        <p class="text-center fw-bold" style="text-shadow: 0 0 10px #fff;">{{ __('mess.register_desc')}}</p>
        <form action="{{ route('register') }}" method="post" id="register-form">
            @csrf
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" required class="form-control @error('full_name') is-invalid @enderror" placeholder="{{ __('mess.full_name') }}" name="full_name" value="{{ old('full_name') }}">
                </div>
                @error('full_name')
                <span class="text-danger fw-bold" style="text-shadow: 0 0 10px #fff;">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" required class="form-control" placeholder="{{ __('mess.phone_number') }}" name="phone_number" value="{{ old('phone_number') }}">
                </div>
                @error('phone_number')
                <span class="text-danger fw-bold">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" required class="form-control" name="password" placeholder="{{ __('mess.password') }}">

                </div>
                @error('password')
                <span class="text-danger fw-bold">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password2" required class="form-control" name="password2" placeholder="{{ __('mess.password2') }}">
                </div>
                @error('password2')
                <span class="text-danger fw-bold">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-code"></i>
                    </span>
                    <input type="text" required class="form-control" name="invite_code" placeholder="{{ __('mess.invite_code') }}">
                </div>
                @error('invite_code')
                <span class="text-danger fw-bold">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" name="is_agree" type="checkbox" value="" id="flexCheckChecked" checked required>
                <label class="form-check-label" for="flexCheckChecked">
                    <span class="text-center fw-bold" style="text-shadow: 0 0 10px #fff;">{{ __('mess.is_agree')}}</span>
                </label>
                @error('is_agree')
                <span class="text-danger fw-bold">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <button id="register" type="submit" class="btn btn-danger w-100">{{ __('mess.register')}}</button>
                <a href="{{ route('login') }}" class="btn btn-secondary w-100 mt-3">
                    <i class="fa-solid fa-arrow-left"></i>
                    {{ __('mess.back_to_login')}}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('script')

<script>
    $('#lang').change(function() {
        window.location.href = '/change-lang?lang=' + $(this).val();
    });
    $('#register-form').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize()
        $('#register').prop('disabled', true);
        //loading
        $('#register').html('<i class="fa-solid fa-spinner fa-spin"></i>');
        post("{{ route('register') }}", formData).then(response => {
            Swal.fire({
                icon: 'success',
                title: "{{ __('mess.register_success') }}",
                text: response.message
            });
            setTimeout(() => {
                window.location.href = "{{ route('login') }}"
            }, 1500);
        }).catch(error => {
            console.log(error);
            Swal.fire({
                icon: 'error',
                title: "{{ __('mess.register_error') }}",
                text: error.responseJSON.message
            });
        });
    });
</script>
@endpush