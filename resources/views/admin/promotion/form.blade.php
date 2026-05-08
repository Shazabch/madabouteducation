@extends('admin.layout.master')

@section('title', 'Add/Edit Promotions')

@section('content')
    <div class="row">
        <div class="col-12">
            @livewire('admin.promotion.form', ['promoId' => $id ?? null])
        </div>
    </div>
@endsection
