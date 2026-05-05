@extends('admin.layout.master')

@section('title','Website Users')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.website-users-component')
    </div>
</div>

<!-- end of main-content -->


@endsection
