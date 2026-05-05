@extends('admin.layout.master')
@section('title','Carousel Management')
@section('content')
    <div class="row">
        <div class="col-12">
            @livewire('admin.carousel-component')
        </div>
    </div>
@endsection
