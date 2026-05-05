@extends('admin.layout.master')

@section('title','User Management')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.user-management-component')
    </div>
</div>

<!-- end of main-content -->


@endsection