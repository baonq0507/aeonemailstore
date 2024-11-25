@extends('layouts.app')
@section('title', __('mess.deposit'))
@section('content')
<div class="container">
    <h4 class="fw-bold text-center my-3 text-success">{{__('mess.will_receive')}}</h4>

    <h4 class="fw-bold text-center my-3 text-warning text-wrap"><span id="will_receive_amount">$0.00</span></h4>

    <form action="{{route('deposit.store')}}" method="post" id="deposit_form">
        @csrf
        <div class="form-group">
            <label for="amount" class="mb-3 fw-bold">{{__('mess.amount')}}:</label>
            <div class="input-group">
                <span class="input-group-text">USD</span>
                <input type="number" class="form-control" id="amount" name="amount" min="{{$min_deposit->value}}" max="{{$max_deposit->value}}">
            </div>

        </div>
        <button class="btn btn-danger w-100 mt-3" id="deposit_btn">{{__('mess.deposit')}}</button>
    </form>
</div>
@include('includes.footer')
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#amount').on('input', function() {
            var amount = $(this).val();
            //format number to 2 decimal places
            //111111111111 => $111,111,111,111.00
            if (amount == '') {
                $('#will_receive_amount').text('0.00');
            } else {
                amount = parseFloat(amount).toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD'
                });
                $('#will_receive_amount').text(amount);
            }
        });

        $('#deposit_form').submit(function(event) {
            event.preventDefault();
            const formData = $(this).serialize();
            $('#deposit_btn').prop('disabled', true);
            //loading
            $('#deposit_btn').html('<i class="fa fa-spinner fa-spin"></i>');
            post("{{ route('deposit.store') }}", formData).then(response => {
                // $('#deposit_btn').prop('disabled', false);
                // $('#deposit_btn').html("{{__('mess.deposit')}}");
                Swal.fire({
                    icon: 'success',
                    title: "{{ __('mess.create_order_success') }}",
                    text: "{{__('mess.contact_cs_message')}}",
                    confirmButtonText: "CSKH"
                }).then((result) => {
                    if (result.isConfirmed) {
                        openLiveChat();
                    }
                });
            }).catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: "{{ __('mess.deposit_error') }}",
                    text: error.responseJSON.message
                });
            });
        });
    });
</script>
@endpush
