@extends('layouts.master')
@section('meta_title','Checkout') @section('meta_description','description')

@section('content')
<section>
    <div class="container">
        {{ json_encode($order) }}
    </div>
</section>
@endsection