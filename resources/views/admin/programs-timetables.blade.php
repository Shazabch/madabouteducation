@extends('admin.layout.master')

@section('title','TimeTable')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.time-table-component',['programId'=>$id])
    </div>
</div>
@endsection
