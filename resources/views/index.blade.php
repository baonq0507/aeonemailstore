@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="container">
    <header class="my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-5">
                <h5>{{ __('mess.welcome') }}</h5>
                <span class="text-muted fs-12">{{ __('mess.welcome_desc') }}</span>
            </div>
            <div class="col-5">
                <h5>{{ auth()->user()->full_name }}</h5>
                <span class="badge bg-danger w-100">
                    $ {{ auth()->user()->balance }}
                </span>
            </div>
            <div class="col-2">
                <img src="{{ asset('images/avat.png') }}" alt="avatar" class="img-fluid" width="50" height="50">
            </div>
        </div>
    </header>

    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ asset('images/banner1.jpg') }}" alt="banner" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('images/banner2.jpg') }}" alt="banner" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('images/banner3.jpg') }}" alt="banner" class="img-fluid">
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="row my-3">
        <div class="col-3 text-center">
            <a href="" class="text-decoration-none text-dark">
                <img src="{{ asset('images/vi.png') }}" alt="icon" width="70" height="70">
                <p class="fs-14">Vòng quay may mắn</p>
            </a>
        </div>
        <div class="col-3 text-center">
            <a href="" class="text-decoration-none text-dark">
                <img src="{{ asset('images/vi2.png') }}" alt="icon" width="70" height="70">
                <p class="fs-14">Ví lợi nhuận</p>
            </a>
        </div>
        <div class="col-3 text-center">
            <a href="" class="text-decoration-none text-dark">
                <img src="{{ asset('images/nap.png') }}" alt="icon" width="70" height="70">
                <p class="fs-14">Nạp tiền</p>
            </a>
        </div>
        <div class="col-3 text-center">
            <a href="" class="text-decoration-none text-dark">
                <img src="{{ asset('images/rut.png') }}" alt="icon" width="70" height="70">
                <p class="fs-14">Rút tiền</p>
            </a>
        </div>
    </div>

    <div class="row">
        <h5 class="mb-3">Sảnh nhiệm vụ</h5>
        @foreach ($levels as $level)
        <div class="col-6 my-3">
            <div class="card position-relative" style="background-color: hsla(180,4%,95%,.6)">
                <img src="{{ asset($level->image) }}" width="120" height="120" alt="task" class="img-fluid" style="position: absolute; top: -20px; left: 0;">
                <div class="card-body position-relative">
                    <h6 class="card-title fw-bold">Hoa hồng {{ $level->commission }}%</h6>
                    <p class="card-text fs-12">{{ $level->description }}</p>
                    <img src="{{ asset('images/logo.png') }}" alt="join" class="img-fluid">
                    <!-- // làm mờ  -->
                    @if (auth()->user()->level_id < $level->id)
                        <div class="position-absolute bottom-0 end-0 d-flex justify-content-center align-items-center flex-column py-2" style="background-color: rgba(0,0,0,0.5); width: 100%; height: 50%;">
                            <img src="{{ asset('images/lock.png') }}" alt="join" class="img-fluid" style="width: 30px; height: 30px;">
                            <p class="text-white fs-12">Chờ nâng cấp</p>
                        </div>
                        @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mb-3">
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/about.png') }}" alt="about" class="img-fluid">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/des.png') }}" alt="about" class="img-fluid">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/taichinh.png') }}" alt="about" class="img-fluid">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/vanhoa.png') }}" alt="about" class="img-fluid">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/dieukien.png') }}" alt="about" class="img-fluid">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/mauthunhap.png') }}" alt="about" class="img-fluid">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/phanchianhom.png') }}" alt="about" class="img-fluid">
        </div>
        <div class="col-3 text-center mb-3">
            <img src="{{ asset('images/chínhachcanhan.png') }}" alt="about" class="img-fluid">
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h6 class="mb-3">Động thái thu nhập hoa hồng người dùng</h6>
            <div id="list-income">

            </div>
        </div>
    </div>
</div>
@include('includes.footer')

@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .swiper {
        max-width: 500px;
        height: 250px;
    }
</style>
@endpush
@push('script')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 1500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    // random income phone
    function randomIncomePhone() {
        const number3 = ['03', '05', '07', '08', '09'];
        const number4 = ['8', '9'];
        const number5 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const number6 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const number7 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const number8 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const number9 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        const number10 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return number3[Math.floor(Math.random() * number3.length)] + number4[Math.floor(Math.random() * number4.length)] + number5[Math.floor(Math.random() * number5.length)] + number6[Math.floor(Math.random() * number6.length)] + number7[Math.floor(Math.random() * number7.length)] + number8[Math.floor(Math.random() * number8.length)] + number9[Math.floor(Math.random() * number9.length)];
    }

    // random income amount
    function randomIncomeAmount() {
        return Math.random() * 100;
    }
    const formatNumber = (number) => {
        return number.toFixed(2);
    }
    //format number phone che 4 số giữa
    const formatNumberPhone = (phone) => {
        return phone.slice(0, 3) + '****' + phone.slice(-3);
    }
    for (let i = 0; i < 10; i++) {
        $('#list-income').append(`
            <div class="row mb-3">
                <div class="col-4">
                    <strong>${formatNumberPhone(randomIncomePhone())}</strong>
                </div>
                <div class="col-4">
                    <span class="badge bg-success">Hoa hồng thu nhập $${formatNumber(randomIncomeAmount())}</span>
                </div>
                <div class="col-4 text-end">
                    <span class="fs-12">${new Date().toLocaleDateString()}</span>
                </div>
            </div>
            `);
    }

    setInterval(() => {
        $('#list-income').html('');
        for (let i = 0; i < 10; i++) {
            $('#list-income').append(`
            <div class="row mb-3">
                <div class="col-4">
                    <strong>${formatNumberPhone(randomIncomePhone())}</strong>
                </div>
                <div class="col-4">
                    <span class="badge bg-success">Hoa hồng thu nhập $${formatNumber(randomIncomeAmount())}</span>
                </div>
                <div class="col-4 text-end">
                    <span class="fs-12">${new Date().toLocaleDateString()}</span>
                </div>
            </div>
            `);
        }
    }, 3000);
</script>
@endpush
