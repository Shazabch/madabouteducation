@extends('admin.layout.master')

@section('title', 'All Promotions')

@section('content')
    <div class="row">
        <div class="col-12">
            @livewire('admin.promotion.index')
        </div>
    </div>
@endsection
