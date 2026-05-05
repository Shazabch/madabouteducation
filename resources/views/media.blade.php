@extends('layouts.master')
@section('meta_title', 'MAE-Media') @section('meta_description', 'description')

@section('content')

    <style>
        .bd-blog-thumb {
            width: 100%;
            max-height: 350px;
            /* control max height of container */
            overflow: hidden;
            /* hides the extra part of long images */
            border-radius: 6px;
            /* optional */
        }

        .bd-blog-thumb img {
            width: 100%;
            height: auto;
            /* keep aspect ratio */
            display: block;
            object-fit: cover;
            /* ensures it fills the box neatly */
        }
    </style>


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
                                <h1 class="bd-breadcrumb-title">Media</h1>
                                <div class="bd-breadcrumb-list">
                                    <span><a href="index.html"><i class="flaticon-hut"></i>MAE</a></span>
                                    <span>News</span>
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

    <!-- blog area start here  -->
    <section class="bd-blog-area pt-120 pb-120">
        <div class="container">

            <div class="row grid">
                @forelse($media as $item)
                    <div class="col-xl-4 col-lg-6 col-md-6 grid-item c-1 c-3 c-4">
                        <div class="bd-blog shadow mb-40 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                            <a href="{{ $item->link }}">
                                <div class="bd-blog-thumb">
                                    <img src="{{ asset($item->image) }}" alt="media image">
                                </div>
                            </a>
                            <div class="bd-blog-content">
                                <div class="bd-blog-date">
                                    <span>{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                                <!-- <div class="bd-blog-meta">
                              <span><i class="fas fa-user"></i> by <a href="news.html">Alex</a></span>
                              <span><i class="fa-solid fa-comment-dots"></i><a href="news-details.html">0
                                    Comments</a></span>
                           </div> -->
                                <h4 class="bd-blog-title"><a href="{{ $item->link }}">{{ $item->title }}</a></h4>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center">
                        No Media Found !
                    </div>
                @endforelse
            </div>

        </div>
    </section>
    <!-- blog area end here  -->

@endsection
