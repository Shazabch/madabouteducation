@extends('layouts.master')
@section('meta_title','MAE World, your one stop educational learning materials and toys for children')
@section('meta_description','Shop MAE World for educational toys, nature learning materials, and fun gifts for children')
@section('meta_keywords','educational toys, children gifts, toys for 2 years old, toys for boys, toy store near me, toys for girls, kids learning, MAE World, farm animals, insects, subscription box kids malaysia')
@push('styles')
    <style>
        /* Banner Styles */
        .categories-banner {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .categories-banner-image {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }


        .categories-banner-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 100%;
            z-index: 1;
        }

        .categories-banner-title {
            color: #fff;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .categories-banner-breadcrumb {
            color: #fff;
            font-size: 1.1rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .categories-banner-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .categories-banner-breadcrumb i {
            margin: 0 0.5rem;
        }
    </style>
@endpush

@section('content')
    <!-- breadcrumb area start here -->
    <section class="categories-banner">
        <div class="categories-banner-image" style="background-image: url('{{ asset('assets/images/shop-banner.png') }}');">
        </div>
    </section>
    <!-- breadcrumb area end here  -->

    <!-- categories area start here  -->
    @include('partials.shop-categories')
    <!-- categories area end here -->
@endsection
