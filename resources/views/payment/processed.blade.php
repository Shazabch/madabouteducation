@extends('layouts.master')
@section('meta_title','MAE- Payment Response') @section('meta_description','')

@section('content')
<section>
    <div class="container mt-80">
        <div class="p-2 rounded {{ $data->is_successfull ? 'bg-success':'bg-danger'; }} text-center" >
            <h4 class="text-center text-white"> {{ $data->is_successfull ? 'Payment Successfull':'Payment Failed'; }}</h4>
            <p class="text-center text-white">{{ $data->message }}</p>
            @if(!$data->is_successfull && isset($data->order_id,$data->type))
            <a class="btn btn-light" href="{{ route('payment.checkout',[$data->type,$data->order_id]) }}">Retry</a>
            @endif
        </div>
    </div>
</section>
@endsection