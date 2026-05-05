@extends('admin.layout.master')

@section('title','Groups')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.program-group-component',['program'=>$program])
    </div>
</div>
@endsection
