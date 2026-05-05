@extends('layouts.master')
@section('meta_title', 'Youth & Summer Camp For Kids in Malaysia')
@section('meta_description',
    'Exciting Youth & Summer Camp For Kids & Teens in Malaysia. Fun & Skills Building
    Activities During School Holidays by Mad About Education.')
@section('meta_keywords', 'summer camp malaysia, youth camp malaysia')
@push('styles')
    <style>
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            padding: 20px;
        }

        .carousel-indicators button {
            background-color: rgba(0, 0, 0, 0.5);
            height: 10px !important;
            width: 10px !important;
            border-radius: 50%;
            margin: 0 5px;
        }

        .carousel-indicators .active {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Optional: Add fade effect */
        .carousel-fade .carousel-item {
            opacity: 0;
            transition: opacity 0.6s ease-in-out;
        }

        .carousel-fade .carousel-item.active {
            opacity: 1;
        }

        /* Carousel Styles */
        .home-carousel {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .home-carousel .carousel-item {
            position: relative;
            background-color: #f8f9fa;
            /* Light background for image loading */
        }

        .home-carousel .carousel-image {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        @media (min-width: 992px) {
            .home-carousel .carousel-image {
                padding-top: 42.85%;
                /* 21:9 Aspect Ratio for larger screens */
            }
        }

        .home-carousel .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 8px;
            max-width: 80%;
            margin: 0 auto;
            bottom: 50px;
        }

        .home-carousel .carousel-caption h5 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .home-carousel .carousel-control-prev,
        .home-carousel .carousel-control-next {
            width: 5%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .home-carousel:hover .carousel-control-prev,
        .home-carousel:hover .carousel-control-next {
            opacity: 1;
        }

        .home-carousel .carousel-control-prev-icon,
        .home-carousel .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 25px;
            border-radius: 50%;
            background-size: 50%;
        }

        .home-carousel .carousel-indicators {
            margin-bottom: 1rem;
        }

        .home-carousel .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid rgba(0, 0, 0, 0.5);
        }

        .home-carousel .carousel-indicators button.active {
            background-color: #fff;
        }

        /* Optional loading animation */
        .home-carousel .carousel-item.loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 50px;
            height: 50px;
            margin: -25px 0 0 -25px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myCarousel = document.getElementById('homeCarousel');
            var carousel = new bootstrap.Carousel(myCarousel, {
                interval: 5000,
                ride: true,
                wrap: true,
                touch: true
            });

            // Optional: Pause on hover
            myCarousel.addEventListener('mouseenter', function() {
                carousel.pause();
            });
            myCarousel.addEventListener('mouseleave', function() {
                carousel.cycle();
            });

            // Preload next image
            myCarousel.addEventListener('slide.bs.carousel', function(event) {
                const nextImage = event.relatedTarget.querySelector('.carousel-image');
                if (nextImage) {
                    const backgroundImage = nextImage.style.backgroundImage;
                    if (backgroundImage) {
                        const url = backgroundImage.match(/url\(['"]?([^'"]+)['"]?\)/)[1];
                        const img = new Image();
                        img.src = url;
                    }
                }
            });
        });
    </script>
@endpush

@section('content')
    <!-- hero area start here  -->
    @php
        $carouselImages = App\Models\CarouselImage::where('status', true)->orderBy('order')->get();
    @endphp

    <section class="home-carousel-section">
        <div class="container-fluid p-0">
            <div id="homeCarousel" class="carousel slide home-carousel" data-bs-ride="carousel">
                <!-- Carousel Indicators -->
                @if ($carouselImages->count() > 1)
                    <div class="carousel-indicators">
                        @foreach ($carouselImages as $index => $image)
                            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="{{ $index }}"
                                @if ($loop->first) class="active" aria-current="true" @endif
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    @forelse($carouselImages as $image)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="carousel-image"
                                style="background-image: url('{{ asset($image->getImage()) }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;">
                            </div>
                        </div>
                    @empty
                        <div class="carousel-item active">
                            <div class="carousel-image"
                                style="background-image: url('{{ asset('assets/images/default-banner.jpg') }}');">
                            </div>
                        </div>
                    @endforelse
                </div>

                @if ($carouselImages->count() > 1)
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>
        </div>
    </section>
    <!-- hero area end here  -->
    <section class="bd-program-area pt-120 pb-120">
        <div class="container">
            <!-- program bg -->
            <div class="bd-gradient-bg"></div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-55 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                        <h2 class="bd-section-title mb-0">Upcoming Programs </h2>

                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    @php $count = 0; @endphp
                    @foreach ($vc_programs as $program)
                        @php
                            // Check if the program has at least one group with end_date > now
                            $hasValidGroup = $program->groups->where('start_date', '>', now())->isNotEmpty();
                        @endphp

                        @if ($hasValidGroup)
                            @if ($count < 3)
                                <div class="col-md-12 col-lg-6 mt-2">
                                    @php $clr = randomBg() @endphp
                                    @include('programs.program_card', [
                                        'program' => $program,
                                        'homePage' => true,
                                    ])
                                </div>
                                @php $count++; @endphp
                            @else
                                @break
                            @endif
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    <!-- promotion area start here  -->
    <section class="bd-promotion-area pt-120 pb-60">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="bd-promotion-thumb-wrapper mb-60">
                        <div class="bd-promotion-thumb">
                            <div class="bd-promotion-thumb-mask p-relative wow fadeInLeft" data-wow-delay=".3s"
                                data-wow-duration="1">
                                <img src="{{ asset('assets/images/IMG1.jpeg') }}" alt="Image not found">
                                <div class="panel wow"></div>
                            </div>
                        </div>
                        <div class="bd-promotion-shape d-none d-lg-block">
                            <img src="{{ asset('assets/img/shape/tripple-line.png') }}" alt="Shape not found">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="bd-promotion mb-60 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                        <div class="bd-section-title-wrapper mb-35">
                            <h2 class="bd-section-title mb-10">Kids Activities in Malaysia by M.A.E</h2>
                            <p>
                                A holistic approach towards children’s development is the key towards bringing out one’s
                                true potentials. <br> <br>
                                Mad About Education Group or MAE Group is an education company that advocates on the
                                importance of building children’s character strength and developing life skills. Formed
                                by two education enthusiasts, the company believes in making a difference in our
                                country’s education system and giving our children a holistic and well-rounded kids
                                activities and education that they deserved.
                            </p>
                        </div>
                        <div class="bd-promotion-counter-wrapper mb-40">
                            <div class="bd-promotion-counter">
                                <div class="bd-promotion-counter-number">
                                    <p><span class="counter">7</span>+</p>
                                </div>
                                <div class="bd-promotion-counter-text">
                                    <span>Years of</span>
                                    <span>experience</span>
                                </div>
                            </div>
                            <div class="bd-promotion-counter">
                                <div class="bd-promotion-counter-number">
                                    <p><span><span class="counter">1</span>K</span>+</p>
                                </div>
                                <div class="bd-promotion-counter-text">
                                    <span>Students</span>
                                    <span>each year</span>
                                </div>
                            </div>
                            <div class="bd-promotion-counter">
                                <div class="bd-promotion-counter-number">
                                    <p><span class="counter">60</span>+</p>
                                </div>
                                <div class="bd-promotion-counter-text">
                                    <span>Campus</span>
                                    <span>Conducted</span>
                                </div>
                            </div>
                        </div>

                        <div class="bd-promotion-btn-wrapper flex-wrap">
                            <div class="bd-promotion-btn">
                                <a href="{{ route('programs') }}" class="bd-btn">
                                    <span class="bd-btn-inner">
                                        <span class="bd-btn-normal">View More</span>
                                        <span class="bd-btn-hover">View More</span>
                                    </span>
                                </a>
                            </div>
                            <div class="bd-promotion-btn-2 bd-pulse-btn btn-2">
                                <a href="https://www.youtube.com/watch?v=yCBQX4ZEIs8" class="popup-video"><i
                                        class="flaticon-play-button"></i> Promotional Video</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- promotion area end here  -->

    <!-- class area start here -->
    @include('partials.categories')
    <!-- class area end here -->

    <!-- program area start here  -->

    <!-- program area end here -->


    <!-- testimonial area start here  -->
    @include('partials.testimonials')
    <!-- testimonial area end here  -->

    <!-- blog area start here  -->
    <!-- <section class="bd-blog-area-2 p-relative fix pt-120 pb-120">
                <div class="container">
                   <div class="bd-blog-section-title mb-40">
                      <div class="row align-items-end">
                         <div class="col-lg-6">
                            <div class="bd-section-title-wrapper mb-0 wow fadeInLeft" data-wow-duration="1s"
                               data-wow-delay=".3s">
                               <h2 class="bd-section-title mb-0">Kindedo News</h2>
                               <p>It is our goal to provide age appropriate opportuniy for every child enrolled in Kindedo Kids
                                  Club
                                  enrichment classes.</p>
                            </div>
                         </div>
                         <div class="col-lg-6">
                            <div class="bd-blog-navigation mb-15 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                               <button class="bd-blog-prev">
                                  <i></i><i class="fa-regular fa-angle-left"></i>
                               </button>
                               <button class="bd-blog-next">
                                  <i class="fa-regular fa-angle-right"></i>
                               </button>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="row">
                      <div class="col-12">
                         <div class="bd-blog-active swiper-container wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
                            <div class="swiper-wrapper">
                               <div class="swiper-slide">
                                  <div class="bd-blog">
                                     <a href="news-details.html">
                                        <div class="bd-blog-thumb">
                                           <img src="{{ asset('assets/img/blog/2.jpg') }}" alt="blog image">
                                        </div>
                                     </a>
                                     <div class="bd-blog-content bd-blog-content-2">
                                        <div class="test-thumb">
                                           <div class="bd-blog-date-2">
                                              <span>22 Jan 2022</span>
                                           </div>
                                        </div>
                                        <div class="bd-blog-meta">
                                           <span><i class="fas fa-user"></i> by <a href="news.html">Alex</a></span>
                                           <span><i class="fa-solid fa-comment-dots"></i><a href="news-details.html">0
                                                 Comments</a></span>
                                        </div>
                                        <h4 class="bd-blog-title"><a href="news-details.html">Tips to Understand Your Child
                                              Better - Parents Guide !</a></h4>
                                     </div>
                                  </div>
                               </div>
                               <div class="swiper-slide">
                                  <div class="bd-blog">
                                     <a href="news-details.html">
                                        <div class="bd-blog-thumb">
                                           <img src="{{ asset('assets/img/blog/4.jpg') }}" alt="blog image">
                                        </div>
                                     </a>
                                     <div class="bd-blog-content bd-blog-content-2">
                                        <div class="bd-blog-date-2">
                                           <span>22 Nov 2022</span>
                                        </div>
                                        <div class="bd-blog-meta">
                                           <span><i class="fas fa-user"></i> by <a href="news.html">Alex</a></span>
                                           <span><i class="fa-solid fa-comment-dots"></i><a href="news-details.html">04
                                                 Comments</a></span>
                                        </div>
                                        <h4 class="bd-blog-title"><a href="news-details.html">Why Toys for pre schoolers are
                                              Important - ready setup</a></h4>
                                     </div>
                                  </div>
                               </div>
                               <div class="swiper-slide">
                                  <div class="bd-blog">
                                     <a href="news-details.html">
                                        <div class="bd-blog-thumb">
                                           <img src="{{ asset('assets/img/blog/3.jpg') }}" alt="blog image">
                                        </div>
                                     </a>
                                     <div class="bd-blog-content bd-blog-content-2">
                                        <div class="bd-blog-date-2">
                                           <span>22 Dec 2022</span>
                                        </div>
                                        <div class="bd-blog-meta">
                                           <span><i class="fas fa-user"></i> by <a href="news.html">Alex</a></span>
                                           <span><i class="fa-solid fa-comment-dots"></i><a href="news-details.html">02
                                                 Comments</a></span>
                                        </div>
                                        <h4 class="bd-blog-title"><a href="news-details.html">Which Toys are Best for Pre
                                              School in Area
                                              Kids in USA
                                           </a></h4>
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </section> -->
    <!-- blog area end here  -->

    <!-- gallery area start here  -->
    <section class="bd-gallery-area p-relative pt-120 pb-60 theme-bg-6 p-relative mt-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bd-section-title-wrapper mb-55 text-center wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        <h2 class="bd-section-title mb-0">See our gallery</h2>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="bd-gallery-active swiper-container wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay=".5s">
                        <div class="swiper-wrapper">
                            @foreach ($images as $image)
                                <div class="swiper-slide">
                                    <div class="bd-gallery">
                                        <div class="bd-gallery-thumb-wrapper">
                                            <div class="bd-gallery-thumb">
                                                <img src="{{ asset($image) }}" alt="img not found!">
                                            </div>
                                            <div class="bd-gallery-icon">
                                                <a href="{{ asset($image) }}" class="popup-image"><i
                                                        class="flaticon-eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- program slider dots pagination  -->
                    <div class="bd-gallery-pagination bd-dots-pagination fill-pagination wow fadeInUp"
                        data-wow-duration="1s" data-wow-delay=".4s"></div>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="bd-class-btn text-center wow fadeInUp" data-wow-duration="1s">
                    <a href="{{ route('gallery') }}" class="bd-btn bd-btn-grey">
                        <span class="bd-btn-inner">
                            <span class="bd-btn-normal">View More</span>
                            <span class="bd-btn-hover">View More</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- gallery area end here  -->

@endsection
