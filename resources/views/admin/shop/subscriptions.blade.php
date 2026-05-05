@extends('admin.layout.master')

@section('title','Shop Subscriptions')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.shop-subscriptions-component')
    </div>
</div>
@endsection
