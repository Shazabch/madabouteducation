@extends('admin.layout.master')

@section('title', 'Promotions Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            @livewire('admin.promotion.dashboard')
        </div>
    </div>
@endsection
