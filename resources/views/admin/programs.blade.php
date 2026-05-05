@extends('admin.layout.master')

@section('title','Programs')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.program-component')
    </div>
</div>
@endsection