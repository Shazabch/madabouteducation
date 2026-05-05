@extends('admin.layout.master')

@section('title','Programs Catgeories')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.program-category-component')
    </div>
</div>
@endsection