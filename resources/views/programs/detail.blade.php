@extends('layouts.master')
@section('meta_title', $program->meta_title) @section('meta_description', $program->meta_description)

@section('content')

    <style>
        .table-responsive1 {
            overflow-x: auto;
            max-width: 100%;
        }

        .html-content ul {
            list-style-type: disc !important;
            padding-left: 10px !important;
        }

        .html-content h4 {
            text-align: center;
            color: #FF9B24;
            background-color: aliceblue;
            border-radius: 12px;
            padding: 5px;
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
                                <h1 class="bd-breadcrumb-title">{{ $program->title }}</h1>
                                <div class="bd-breadcrumb-list">
                                    <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                                    <span>Programs Details</span>
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

    <!-- program details slider area start here  -->
    <section class="bd-program-details-widget pt-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-12 mb-50">
                    <div class="bd-program-details-slider p-relative wow fadeInLeft" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        <div class="bd-program-details-active swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($program->images as $image)
                                    <div class="swiper-slide">
                                        <div class="bd-program-details-slider-thumb">
                                            <img style="max-height: 700px;" src="{{ asset($image->path) }}"
                                                alt="img not found!">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- program details slider navigation  -->
                        <div class="bd-program-details-navigation mb-15 d-none d-sm-flex">
                            <button class="bd-program-details-next">
                                <i class="fa-regular fa-angle-right"></i>
                            </button>
                            <button class="bd-program-details-prev">
                                <i class="fa-regular fa-angle-left"></i>
                            </button>
                        </div>
                        <div class="panel wow"></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12 mb-50">
                    <div class="bd-program-details-widget-content theme-bg-6 wow fadeInRight" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        <h3 class="bd-program-details-widget-title mb-20">{{ $program->title }}</h3>
                        <p class="mb-25">
                            {!! $program->overview !!}
                        </p>
                        <!-- <p class="mb-25">Observers of Montessori children note that they are confident, caring, independent
                                                       as well as enthusiastic and motivated learners what they learn years comes
                                                       from perceptive. </p> -->
                        {{-- <div class="bd-program-details-author-wrapper mt-35">
                       <!-- <div class="bd-program-details-author">
                          <div class="bd-program-details-author-thumb"><img src="{{ asset('assets/img/program/author-1.png') }}"
                                alt="img not found!"></div>
                          <div class="bd-program-details-author-name">
                             <span>Settling Teacher</span>
                             <h5>Alexia Honix</h5>
                          </div>
                       </div> -->
                       <div class="bd-program-details-cat">
                        <span>Date</span>
                        <h5 class="text-capitalize"></h5>
                     </div>
                       <div class="bd-program-details-cat">
                          <span>Category</span>
                          <h5>{{ $program->category->title }}</h5>
                       </div>
                       <div class="bd-program-details-cat">
                          <span>Price</span>
                          <h5></h5>
                       </div>
                       <!-- <div class="bd-program-details-cat-wrapper">
                       </div> -->
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- program details slider area end here  -->

    {{-- Program Groups Start --}}
    <section class="px-4 mb-50" id="BookNow">
        <h2 class="text-center text_green">Book Now</h2>
        <div class="container ">
            @forelse ($program->groups as $group)
                <div class="my-2">
                    <div class="bd-program-details-widget-content theme-bg-7 wow fadeInRight" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        <h5 class="bd-program-details-widget-title mb-20">{{ $group->title }}</h5>
                        <!-- <span>Slots : (T) {{ $group->total_slots }}  / (B) {{ $group->booked_slots }} </span> -->
                        <div class="bd-program-details-author-wrapper mt-35">
                            <div class="bd-program-details-cat">
                                <span>Date</span>
                                <h5 class="text-capitalize">{{ $group->date() }} <br> {{ $group->time }}</h5>
                            </div>
                            <div class="bd-program-details-cat">
                                <span>Age</span>
                                <h5>{{ $group->age_group }} years {{ $group->age_group_extra_info }}</h5>
                            </div>
                            <div class="bd-program-details-cat">
                                <span>Price</span>
                                <h5>{{ $group->price() }}</h5>
                                @if ($group->program->is_sst_applicable)
                                    <span>*subject to SST</span>
                                @endif
                            </div>
                            <div class="bd-program-details-cat">
                                <span>Book Now</span>
                                <h5>
                                    @if ($group->booked_slots == $group->total_slots)
                                        <a href="#" class="btn btn-light">Book Now</a> <br>
                                        <small class="text-danger mt-2">No slot left for this camp!</small>
                                    @elseif(\Carbon\Carbon::parse($group->end_date)->isPast() && !$group->is_reoccuring)
                                        <a href="#" class="btn btn-light">Book Now</a> <br>
                                        <small class="text-danger mt-2">Booking closed (Camp ended)!</small>
                                    @else
                                        <a href="{{ route('programs.checkout_details', [$program->id, $group->id]) }}"
                                            class="btn btn-green">Book Now</a>
                                    @endif

                                </h5>
                            </div>
                            <!-- <div class="bd-program-details-cat-wrapper">
                                                    </div> -->
                        </div>
                    </div>

                </div>
            @empty
                <div class="my-2">
                    <div class="bd-program-details-widget-content theme-bg-7 wow fadeInRight" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        <p>No group is currently available for booking.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>
    {{-- Program Groups End --}}

    {{-- Venue and Pick and drop Start --}}
    @if ($program->pick_and_drop || $program->venue)
        <section class="px-4 mb-50">
            <div class="container ">
                <div class="my-2">
                    <div class="bd-program-details-widget-content theme-bg-6 wow fadeInRight" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        @if ($program->pick_and_drop)
                            <div>
                                <h5>Pick & Drop</h5>
                                <p>{{ $program->pick_and_drop }}</p>
                            </div>
                        @endif
                        @if ($program->venue)
                            <div>
                                <h5>Venue</h5>
                                <p>{{ $program->venue }}</p>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </section>
    @endif
    {{-- Venue and pick and drop end --}}

    <!-- shop category area start here -->
    {{-- <section class="bd-shop-cat-area pb-90">
        <div class="container">
           <div class="row justify-content-center">
              <div class="col-lg-3 col-md-6 col-sm-6">
                 <div class="bd-shop-cat-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                    <a href="shop.html">
                       <div class="bd-shop-cat">
                          <div class="bd-shop-cat-content">
                             <div class="bd-shop-cat-title cat-1">
                                <div class="bd-shop-cat-icon">
                                   <i class="flaticon-age-group"></i>
                                </div>
                             </div>
                             <h6>{{ $program->age_group }} years</h6>
                             <span>age</span>
                          </div>
                       </div>
                    </a>
                 </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                 <div class="bd-shop-cat-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                    <a href="shop.html">
                       <div class="bd-shop-cat">
                          <div class="bd-shop-cat-content">
                             <div class="bd-shop-cat-title cat-2">
                                <div class="bd-shop-cat-icon">
                                   <i class="flaticon-calendar"></i>
                                </div>
                             </div>
                             <h6>5 Days</h6>
                             <span>weekly</span>
                          </div>
                       </div>
                    </a>
                 </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                 <div class="bd-shop-cat-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                    <a href="shop.html">
                       <div class="bd-shop-cat">
                          <div class="bd-shop-cat-content">
                             <div class="bd-shop-cat-title cat-3">
                                <div class="bd-shop-cat-icon">
                                   <i class="flaticon-clock-1"></i>
                                </div>
                             </div>
                             <h6>3.30 Hrs</h6>
                             <span>period</span>
                          </div>
                       </div>
                    </a>
                 </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                 <div class="bd-shop-cat-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
                    <a href="shop.html">
                       <div class="bd-shop-cat">
                          <div class="bd-shop-cat-content">
                             <div class="bd-shop-cat-title cat-4">
                                <div class="bd-shop-cat-icon">
                                   <i class="flaticon-class"></i>
                                </div>
                             </div>
                             <h6>Class Size</h6>
                             <span>24</span>
                          </div>
                       </div>
                    </a>
                 </div>
              </div>
           </div>
        </div>
     </section> --}}
    <!-- shop category area end here-->

    <!-- program details area start here  -->
    <section class="bd-program-details-widget pb-70">
        <div class="container html-content bg-light p-2">
            {!! $program->content !!}
        </div>
    </section>
    <!-- program details area end here  -->

    {{-- Actvities Section Start --}}
    @if ($program->hasActivities())
        <section class="bd-program-details-widget pb-70">
            <div class="container html-content">
                <h2>Activities Selection</h2>
                <p>Lists of activities that campers can choose during the electives.</p>


                <div class="row">
                    @if ($program->activities_1)
                        <div class="col-md-4">
                            {!! $program->activities_1 !!}
                        </div>
                    @endif
                    @if ($program->activities_2)
                        <div class="col-md-4">
                            {!! $program->activities_2 !!}
                        </div>
                    @endif
                    @if ($program->activities_3)
                        <div class="col-md-4">
                            {!! $program->activities_3 !!}
                        </div>
                    @endif

                </div>

            </div>
        </section>
    @endif
    {{-- Actvities Section End --}}

    @if ($program->timetables->count())
        <!-- program routine area start here  -->
        <section class="bd-blog-area pt-120 pb-120">
            <div class="container">
                <div class="bd-blog-section-title mb-40">
                    <div class="row align-items-end">
                        <div class="col-lg-6">
                            <div class="bd-section-title-wrapper mb-0 wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay=".3s">
                                <h2 class="bd-section-title mb-0">Time Table</h2>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="bd-blog-navigation mb-15 wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay=".3s">
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
                    @if ($program->timetables->count() > 1)
                        <div class="col-12">
                            <div class="bd-blog-active swiper-container wow fadeInUp" data-wow-duration="1s"
                                data-wow-delay=".3s">
                                <div class="swiper-wrapper">
                                    @foreach ($program->timetables as $timetable)
                                        <div class="swiper-slide">
                                            <h3 style="font-weight:300;">{{ $timetable->title }}</h3>

                                            <div class="bd-routine-table mt-30 mb-50 wow fadeInLeft"
                                                data-wow-duration="1s" data-wow-delay=".3s">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Hour</th>
                                                            <th scope="col">Activity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($timetable->activities() as $activity)
                                                            <tr>
                                                                <td>{{ $activity['hour'] }}</td>
                                                                <td>{{ $activity['activity'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-6">
                            @foreach ($program->timetables as $timetable)
                                <h3 style="font-weight:300;">{{ $timetable->title }}</h3>
                                <div class="bd-routine-table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Hour</th>
                                                <th scope="col">Activity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($timetable->activities() as $activity)
                                                <tr>
                                                    <td>{{ $activity['hour'] }}</td>
                                                    <td>{{ $activity['activity'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- program routine area end here  -->
    @endif

    <!-- joining area start here  -->
    @livewire('program.addon-products-component', ['program' => $program])
    <!-- joining area end here  -->
    @if ($program->morePrograms()->count())
        <!-- program area start here  -->
        <section class="bd-program-area pt-120 pb-120">
            <div class="container">
                <div class="bd-program-top mb-40">
                    <div class="row align-items-end">
                        <div class="col-lg-6">
                            <div class="bd-section-title-wrapper mb-0 wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay=".3s">
                                <h2 class="bd-section-title mb-0">More Programs</h2>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="bd-swiper-navigation mb-15 wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay=".3s">
                                <button class="bd-program-prev">
                                    <i></i><i class="fa-regular fa-angle-left"></i>
                                </button>
                                <button class="bd-program-next">
                                    <i class="fa-regular fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="bd-program-active swiper-container wow fadeInUp" data-wow-duration="1s"
                            data-wow-delay=".5s">
                            <div class="swiper-wrapper">
                                @foreach ($program->morePrograms() as $program)
                                    <div class="swiper-slide">
                                        @php $clr=randomBg() @endphp
                                        @include('programs.program_card', ['program' => $program])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
