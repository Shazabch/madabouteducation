@extends('admin.layout.master')

@section('title','Role Management')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.role-management-component')
    </div>
</div>
@endsection
