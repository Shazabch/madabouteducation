@extends('admin.layout.master')

@section('title','Forms')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.form-component')
    </div>
</div>
@endsection