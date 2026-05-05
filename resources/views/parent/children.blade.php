@extends('layouts.parent')
@section('meta_title','MAE- My Children') @section('meta_description','description')
@section('sub-content')
<div class="container-fluid">
    @livewire('parent.guardian-component')
    @livewire('parent.children-component')
</div>
@endsection