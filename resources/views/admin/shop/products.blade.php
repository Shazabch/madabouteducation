@extends('admin.layout.master')

@section('title','Products')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.product-component')
    </div>
</div>
@endsection