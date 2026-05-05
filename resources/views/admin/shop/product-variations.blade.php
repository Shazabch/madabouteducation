@extends('admin.layout.master')

@section('title','Product Variations')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.variation-management',['product'=>$product])
    </div>
</div>
@endsection
