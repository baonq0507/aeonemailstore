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
</style>
<!-- Start of LiveChat (www.livechat.com) code -->
<script>
    window.__lc = window.__lc || {};
    window.__lc.license = "{{ $livechat_id }}";
    window.__lc.integration_name = "manual_onboarding";
    window.__lc.product_name = "livechat";;
    (function(n, t, c) {
        function i(n) {
            return e._h ? e._h.apply(null, n) : e._q.push(n)
        }
        var e = {
            _q: [],
            _h: null,
            _v: "2.0",
            on: function() {
                i(["on", c.call(arguments)])
            },
            once: function() {
                i(["once", c.call(arguments)])
            },
            off: function() {
                i(["off", c.call(arguments)])
            },
            get: function() {
                if (!e._h) throw new Error("[LiveChatWidget] You can't use getters before load.");
                return i(["get", c.call(arguments)])
            },
            call: function() {
                i(["call", c.call(arguments)])
            },
            init: function() {
                var n = t.createElement("script");
                n.async = !0, n.type = "text/javascript", n.src = "https://cdn.livechatinc.com/tracking.js", t.head.appendChild(n)
            }
        };
        !n.__lc.asyncInit && e.init(), n.LiveChatWidget = n.LiveChatWidget || e
    }(window, document, [].slice))
</script>
<noscript><a href="https://www.livechat.com/chat-with/18928437/" rel="nofollow">Chat with us</a>, powered by <a href="https://www.livechat.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
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

    <div class="float-end" style=" cursor: pointer;">
        <img src="{{ asset('images/cskh3.png') }}" alt="logo" class="img-fluid" width="50px">
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
