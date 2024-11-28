@extends('layouts.app')
@section('title', __('mess.mission'))
@push('css')
<style>
    .card {
        border-radius: 10px;
        background-color: rgb(245 245 245/1)
    }

    .no-border {
        border: none !important;
    }
</style>
@endpush
@section('content')
<div class="container mt-5">
    <div class="card position-relative">
        <img src="{{ asset($level->image) }}" alt="{{ $level->name }}" style="position: absolute; top: -20px; left: 20px; width: 100px;">
        <p class="fw-bold fs-12 text-center pt-3">{{ $level->description }}</p>
        <p class="fw-bold fs-12 text-center">
            {{ __('mess.commission') }}: {{ $level->commission }} %
        </p>
        <div class="card-body">
            <img src="{{ asset('images/mission.jpg') }}" alt="mission" class="img-fluid rounded">
            <p class="text-center pt-3">
                <span class="fw-bold" id="number_phone">038****231</span> &nbsp; <span class="badge bg-warning">Khớp thành công</span>
                <span class="text-muted" id="date_time">17/11/2024</span>
            </p>
        </div>
        <p class="text-center">
            <a href="" class="" id="start_mission">
                <img src="{{ asset('images/start.png') }}" alt="mission" class="w-50">
            </a>
        </p>
    </div>

    <h6 class="text-center fw-bold my-3">
        {{ __('mess.today_achievement') }}
    </h6>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <p class="text-center mb-0">{{__('mess.account_balance')}} </p>
                    <p class="text-center mb-0 text-danger"> ${{ auth()->user()->balance }}</p>
                </div>
                <div class="col-6">
                    <p class="text-center mb-0"> {{__('mess.number_order_completed')}} </p>
                    <p class="text-center mb-0 text-danger"> {{ $orderInDay }}/{{ $level->order }}</p>
                </div>
                <!-- hoa hồng hôm nay -->
                <div class="col-6">
                    <p class="text-center mb-0"> {{__('mess.today_commission')}} </p>
                    <p class="text-center mb-0 text-danger"> ${{ number_format($commission, 0, ',', '.') }} </p>
                </div>
                <!-- số tiền đóng băng -->
                <div class="col-6">
                    <p class="text-center mb-0"> {{__('mess.lock_balance')}} </p>
                    <p class="text-center mb-0 text-danger"> ${{ auth()->user()->balance_lock }} </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card my-3">
        <div class="card-body text-center">
            <button class="btn btn-secondary w-25">
                {{__('mess.unlock_balance')}}
            </button>
            <p class="fs-13 mt-3 mb-0">
                {{__('mess.unlock_balance_description')}}
            </p>
        </div>
    </div>

    <div class="card mb-3" style="margin-bottom: 100px !important">
        <div class="card-body">
            <div class="text-center">
                <button class="btn btn-secondary mx-auto">
                    {{__('mess.guide')}}
                </button>
            </div>
            <p class="fs-13 mt-3 mb-0">
                {{__('mess.guide_description1')}}
            </p>
            <p class="fs-13 mb-0">
                {{__('mess.guide_description2')}}
            </p>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
@push('script')
<script>
    $(document).ready(function() {
        // random income phone
        function randomIncomePhone() {
            const number3 = ['03', '05', '07', '08', '09'];
            const number4 = ['8', '6'];
            const number5 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const number6 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const number7 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const number8 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const number9 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const number10 = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

            return number3[Math.floor(Math.random() * number3.length)] + number4[Math.floor(Math.random() * number4.length)] + number5[Math.floor(Math.random() * number5.length)] + number6[Math.floor(Math.random() * number6.length)] + number7[Math.floor(Math.random() * number7.length)] + number8[Math.floor(Math.random() * number8.length)] + number9[Math.floor(Math.random() * number9.length)];
        }
        const formatNumberPhone = (phone) => {
            return phone.slice(0, 3) + '****' + phone.slice(-3);
        }
        setInterval(() => {
            $('#number_phone').text(formatNumberPhone(randomIncomePhone()));
            $('#date_time').text(new Date().toLocaleDateString('vi-VN'));
        }, 1500);

        function limitString(str, limit) {
            return str.length > limit ? str.substring(0, limit) + '...' : str;
        }

        $('#start_mission').click(function(e) {
            e.preventDefault();

            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const currentTime = hours * 100 + minutes;

            if (currentTime >= 830 && currentTime <= 2359) {
                post("{{ route('mission.start') }}", {
                    _token: "{{ csrf_token() }}"
                }).then(function(response) {
                    const data = response.data;
                    const level = response.level;
                    Swal.fire({
                        imageUrl: data.image,
                        icon: 'success',
                        title: limitString(data.name, 30),
                        text: `{{ __('mess.price_product', ['price' => ':price', 'profit' => ':profit']) }}`.replace(':price', data.price).replace(':profit', level.commission + '%'),
                        imageWidth: 200,
                        imageHeight: 200,
                        showCloseButton: true,
                        showCancelButton: true,
                        confirmButtonText: "{{ __('mess.product_buy') }}",
                        cancelButtonText: "{{ __('mess.cancel') }}"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            post("{{ route('product.buy') }}", {
                                _token: "{{ csrf_token() }}",
                                product_id: data.id
                            }).then(function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: "{{ __('mess.product_buy_success') }}",
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2500);
                            }).catch(function(error) {
                                Swal.fire({
                                    title: "{{ __('mess.product_buy_error') }}",
                                    text: error.responseJSON.message,
                                    iconHtml: `<img src="{{ asset('images/error.webp') }}" alt="error" class="img-fluid">`,
                                    customClass: {
                                        icon: 'no-border'
                                    }
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2500);
                            });
                        }
                    });

                }).catch(function(error) {
                    // nếu lỗi 400
                    if (error.status === 400) {
                        Swal.fire({
                            text: error.responseJSON.message,
                            icon: 'success',
                            customClass: {
                                icon: 'no-border'
                            }
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 2500);
                    } else if (error.status === 500) {
                        Swal.fire({
                            title: "{{ __('mess.product_buy_error') }}",
                            text: error.responseJSON.message,
                            iconHtml: `<img src="{{ asset('images/error.webp') }}" alt="error" class="img-fluid">`,
                            customClass: {
                                icon: 'no-border'
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "{{ __('mess.error') }}",
                            text: error.responseJSON.message,
                            iconHtml: `<img src="{{ asset('images/error.webp') }}" alt="error" class="img-fluid">`,
                            customClass: {
                                icon: 'no-border'
                            }
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 2500);
                    }
                });
            } else {
                Swal.fire({
                    title: "{{ __('mess.error') }}",
                    text: "{{ __('mess.mission_start_error') }}",
                    iconHtml: `<img src="{{ asset('images/error.webp') }}" alt="error" class="img-fluid">`,
                    customClass: {
                        icon: 'no-border'
                    }
                });
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        });
    });
</script>
@endpush
