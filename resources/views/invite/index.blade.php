@extends('layouts.app')

@section('content')
    <h4 class="text-center">Nhóm của tôi</h4>
    <p>Số người đã mời : {{ auth()->user()->invite_number }}</p>
@endsection
