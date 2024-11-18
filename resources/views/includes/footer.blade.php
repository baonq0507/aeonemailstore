<footer class="text-white text-center p-3">
    <div class="row">
        <div class="col">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <img src="{{ request()->is('home') ? asset('images/home-active.png') : asset('images/home.png') }}" alt="logo" class="img-fluid" width="30" height="30">
                <h6 class="fs-12 {{ request()->is('home') ? 'text-warning' : 'text-dark' }} mb-0">{{ __('mess.home') }}</h6>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('order.index') }}" class="text-decoration-none">
                <img src="{{ request()->is('order') ? asset('images/history-active.png') : asset('images/history.png') }}" alt="logo" class="img-fluid" width="30" height="30">
                <h6 class="fs-12 {{ request()->is('order') ? 'text-warning' : 'text-dark' }} mb-0">{{ __('mess.history') }}</h6>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <img src="{{ asset('images/logo1.png') }}" alt="logo" class="img-fluid" width="50" height="50">
                <h6 class="fs-12 text-dark mb-0"></h6>
            </a>
        </div>
        <div class="col">
            <a id="livechat" target="_blank" class="text-decoration-none">
                <img src="{{ asset('images/cskh.png') }}" alt="logo" class="img-fluid" width="30" height="30">
                <h6 class="fs-12 text-dark mb-0">CSKH</h6>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('user.index') }}" class="text-decoration-none">
                <img src="{{ request()->is('user') ? asset('images/user-active.png') : asset('images/user.png') }}" alt="logo" class="img-fluid" width="30" height="30">
                <h6 class="fs-12 {{ request()->is('user') ? 'text-warning' : 'text-dark' }} mb-0">{{ __('mess.account') }}</h6>
            </a>
        </div>
    </div>
</footer>
