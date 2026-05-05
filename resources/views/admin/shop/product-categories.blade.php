@extends('admin.layout.master')

@section('title','Product Categories')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.product-category-component')
    </div>
</div>
@endsection
