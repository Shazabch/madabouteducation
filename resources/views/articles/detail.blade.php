@extends('layouts.master')
@section('meta_title', 'MAE-Articles') @section('meta_description', '')

@section('content')

    <!-- breadcrumb area start here -->
    <section class="bd-breadcrumb-area p-relative fix theme-bg">
        <!-- breadcrumb background image -->
        <div class="bd-breadcrumb-bg" data-background="{{ asset('assets/images/page-banner.jpg') }}"></div>
        <div class="bd-breadcrumb-wrapper mb-60 p-relative">
            <div class="container">
                <div class="bd-breadcrumb-shape d-none d-sm-block p-relative">
                    <div class="bd-breadcrumb-shape-1">
                        <img src="{{ asset('assets/img/shape/curved-line-2.png') }}" alt="img not found!">
                    </div>
                    <div class="bd-breadcrumb-shape-2">
                        <img src="{{ asset('assets/img/shape/white-curved-line.png') }}" alt="img not found!">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="bd-breadcrumb d-flex align-items-center justify-content-center">
                            <div class="bd-breadcrumb-content text-center">
                                <h1 class="bd-breadcrumb-title">{{ $article->title }}</h1>
                                <div class="bd-breadcrumb-list">
                                    <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                                    <span><a href="{{ route('articles') }}"><i class="flaticon-hut"></i>Articles</a></span>
                                    <span>{{ $article->title }}</span>
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


    <section class="bd-program-details-widget pt-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset($article->image) }}" alt="Blog image" class="card-img-top img-fluid w-100">
                        <div class="card-body d-flex justify-content-center align-items-center p-2">
                            <span class="text-muted small">
                                <i class="text-primary fas fa-user me-1"></i> by
                                <a href="news.html" class="text-decoration-none">Admin</a>
                            </span>
                            <span class="text-muted small mx-2">
                                <i class="text-success fas fa-calendar-days me-1"></i> {{ $article->published_on }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-12 mb-50">
                    <div class="bd-program-details-widget-content theme-bg-6 wow fadeInRight" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        <h3 class="bd-program-details-widget-title mb-20">{{ $article->title }}</h3>
                        <p class="mb-25">
                            {!! $article->content !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- detail start --}}

    {{-- detail end --}}

    {{-- Related Blogs Start --}}
    <section class="bd-blog-area pb-120">
        <div class="container">
            <div class="bd-blog-section-title mb-40">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="bd-section-title-wrapper text-center mb-0 wow fadeInUp" data-wow-duration="1s"
                            data-wow-delay=".2s">
                            <h2 class="bd-section-title mb-0">Related Articles</h2>
                            <p class="text-center">It is our goal to provide age appropriate opportunity for every child
                                enrolled.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="bd-blog-active swiper-container wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                        <div class="swiper-wrapper">
                            @foreach ($article->relatedArticles() as $article)
                                <div class="swiper-slide">
                                    @include('articles.card', ['article' => $article])
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- slider dots pagination -->
                    <div class="bd-blog-pagination bd-dots-pagination wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay=".3s"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Related Blogs End --}}


@endsection
