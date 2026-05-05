@extends('admin.layout.master')

@section('title','Media')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('admin.article-component')
    </div>
</div>
@endsection
