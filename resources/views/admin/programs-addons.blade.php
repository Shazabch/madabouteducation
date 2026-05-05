@extends('admin.layout.master')

@section('title','Program Addons')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.program-addons-component',['programId'=>$id])
    </div>
</div>
@endsection
