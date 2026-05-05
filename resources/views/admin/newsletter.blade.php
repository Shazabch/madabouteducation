@extends('admin.layout.master')

@section('title','Newsletter')

@section('content')
<div class="row">
    <div class="col-12">
    @livewire('admin.newsletter-subcription-component')
    </div>
</div>
@endsection
