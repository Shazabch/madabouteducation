@extends('admin.layout.master')

@section('title','Program Bookings')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.camp-bookings-component')
    </div>
</div>
@endsection