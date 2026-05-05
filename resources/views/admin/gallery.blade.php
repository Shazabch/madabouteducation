@extends('admin.layout.master')

@section('title','Gallery')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.gallery-component')
    </div>
</div>
@endsection