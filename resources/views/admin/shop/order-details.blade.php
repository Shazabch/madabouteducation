@extends('admin.layout.master')

@section('title','Shop Orders')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.order-detail-component',['order'=>$order])
    </div>
</div>
@endsection
