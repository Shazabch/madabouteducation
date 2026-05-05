@extends('layouts.master')
@section('meta_title', 'MAE-Travel & Transportation') @section('meta_description', 'description')

@section('content')


    <!-- breadcrumb area start here -->
    <section class="bd-breadcrumb-area p-relative fix theme-bg">
        <!-- breadcrumb background image -->
        <div class="bd-breadcrumb-bg" data-background="{{ asset('assets/images/page-banner.jpg') }}"></div>
        <div class="bd-breadcrumb-wrapper mb-60 p-relative">
            <div class="container">
                <div class="bd-breadcrumb-shape d-none d-sm-block p-relative">
                    <div class="bd-breadcrumb-shape-1">
                        <img src="assets/img/shape/curved-line-2.png" alt="img not found!">
                    </div>
                    <div class="bd-breadcrumb-shape-2">
                        <img src="assets/img/shape/white-curved-line.png" alt="img not found!">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="bd-breadcrumb d-flex align-items-center justify-content-center">
                            <div class="bd-breadcrumb-content text-center">
                                <h1 class="bd-breadcrumb-title">
                                    <a href="{{ route('travel') }}">Travel & Transportation</a>
                                </h1>
                                <div class="bd-breadcrumb-list">
                                    <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                                    <span>Travel & Transportation</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bd-wave-wrapper bd-wave-wrapper-3">
            <div class="bd-wave bd-wave-3"></div>
            <div class="bd-wave bd-wave-3"></div>
        </div>
    </section>
    <!-- breadcrumb area end here  -->

    <section class="bd-promotion-area pt-120 pb-60 fix">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="bd-promotion bd-promotion-2 mb-60 wow fadeInLeft" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        <div class="bd-section-title-wrapper mb-35">
                            <h2 class="bd-section-title mb-10">Travel & Transportation</h2>

                            <p> For most of the camps and programs (with the exception of the Summer Camp and Winter
                                Solstice Camp), all children can be dropped off at Roadside of Bukit Utama 1 Condominium –
                                Changkat Bukit Utama, Bandar Utama, 47800 Petaling Jaya, Selangor. We have buses ready to
                                transport children to the designated locations.
                            </p>
                            <p style="font-size: larger;">
                                As for our The Earth Rangers and Tiny Explorers Program, parents are required to drive to
                                the specific locations as advised. These locations are chosen based on several importants
                                aspects such as safety, locations, objective of each camp, activities provided and resources
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="bd-promotion-thumb-wrapper mb-60 wow fadeInRight" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        <div class="bd-promotion-thumb">
                            <div class="bd-promotion-thumb-mask p-relative">
                                <img src="{{ asset('assets/images/travel.jpg') }}" alt="Image not found">
                                <div class="panel-2 wow"></div>
                            </div>
                        </div>
                        <div class="bd-promotion-shape d-none d-lg-block">
                            <img src="{{ asset('assets/img/shape/tripple-line.png') }}" alt="Shape not found">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
