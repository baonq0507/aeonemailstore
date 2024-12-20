@extends('layouts.app')

@push('css')
<style>
    body {
        width: revert-layer;
        max-width: revert-layer;
        margin: 0;
        padding: 0;
    }

    .wrapper {
        width: 100%;
        height: 100vh;
        background-image: url("{{ asset('images/auth.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }

    .center {
        position: absolute;
        top: 50%;
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

    .float-end {
        position: absolute;
        bottom: 30px;
        right: 30px;
    }

    /* nếu là pc */
    @media (min-width: 768px) {
        .float-end {
            bottom: 100px;
            right: 20%;
        }
    }
</style>

<!-- End of LiveChat code -->
@endpush
@section('content')
<div class="wrapper">
    <!-- //select lang -->
    <div class="center">
        <div class="card" style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px;">
            <img src="{{ asset('images/logo2.png') }}" alt="logo" class="img-fluid mx-auto d-block pt-3">
            <h4 class="text-center">{{ __('mess.login') }}</h4>
            <div class="card-body">
                <form action="{{ route('login') }}" method="post" id="login-form">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fa-solid fa-user" style="color: #b51c8e;"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="{{ __('mess.phone_number') }}" name="phone_number">
                            @error('phone_number')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fa-solid fa-lock" style="color: #b51c8e;"></i>
                            </span>
                            <input type="password" class="form-control" name="password" placeholder="{{ __('mess.password') }}">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <button id="login" type="submit" class="btn btn-danger w-100" style="background-color: #b51c8e; border-color: #b51c8e;">{{ __('mess.login')}}</button>
                        <a href="{{ route('register') }}" class="btn btn-secondary w-100 mt-3">{{ __('mess.register')}}</a>
                    </div>
                </form>

            </div>
            <div class="lang">
                <select name="lang" id="lang" class="form-select" style="background-color: #b51c8e; border-color: #b51c8e; color: #fff;">
                    <option value="ja" @if(config('app.locale')=='ja' ) selected @endif>{{ __('mess.Japanese') }}</option>
                    <option value="zh" @if(config('app.locale')=='zh' ) selected @endif>{{ __('mess.Chinese') }}</option>
                    <option value="ko" @if(config('app.locale')=='ko' ) selected @endif>{{ __('mess.Korean') }}</option>
                    <option value="en" @if(config('app.locale')=='en' ) selected @endif>{{ __('mess.English') }}</option>
                    <option value="vi" @if(config('app.locale')=='vi' ) selected @endif>{{ __('mess.Vietnamese') }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="float-end cskh" style=" cursor: pointer;">
        <img src="{{ asset('images/cskh4.png') }}" alt="logo" class="img-fluid" width="50px">
    </div>
</div>
@include('sweetalert::alert')

@endsection
@push('script')
<script>
    $('#lang').change(function() {
        window.location.href = '/change-lang?lang=' + $(this).val();
    });
    $('#login-form').submit(function(e) {
        e.preventDefault();
        $('#login').prop('disabled', true);
        //loading
        $('#login').html('<i class="fa-solid fa-spinner fa-spin"></i>');
        const formData = $(this).serialize()
        post("{{ route('login') }}", formData).then(response => {
            Swal.fire({
                icon: 'success',
                // title: "{{ __('mess.login_success') }}",
                text: response.message,
                // textButton
                confirmButtonText: "Loading..."
            });
            setTimeout(() => {
                window.location.href = "{{ route('home') }}"
            }, 1500);
        }).catch(error => {
            console.log(error);
            $('#login').prop('disabled', false);
            $('#login').html("{{ __('mess.login')}}");
            Swal.fire({
                icon: 'error',
                title: "{{ __('mess.login_error') }}",
                text: error.responseJSON.message
            });
        });
    });
</script>
@endpush
