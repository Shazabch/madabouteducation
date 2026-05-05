@extends('layouts.master')
@section('meta_title', 'MAE-School') @section('meta_description', 'description')

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
                                <h1 class="bd-breadcrumb-title">School</h1>
                                <div class="bd-breadcrumb-list">
                                    <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                                    <span>School</span>
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

    <section class="bd-promotion-area-2 pt-120 pb-60 fix">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="bd-promotion bd-promotion-2 mb-60 wow fadeInLeft" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        <div class="bd-section-title-wrapper mb-35">
                            <h2 class="bd-section-title mb-10">Friendly atmosphere
                                for all kids</h2>

                            <p>We have a variety of programs and overnight camps to cater to schools, nurseries, day care
                                centers, kindergarten, learning centers, tuition centers and colleges. Below is a list of
                                programs and activities caters for different age groups:
                            </p>
                        </div>
                        <!-- <div class="bd-promotion-list-2">
                             <ul>
                                <li>
                                   <div class="bd-promotion-icon">
                                      <i class="flaticon-exclusive theme-bg-2"></i>
                                   </div>
                                   <span>Full Day Sessions</span>
                                </li>
                                <li>
                                   <div class="bd-promotion-icon">
                                      <i class="flaticon-whiteboard theme-bg"></i>
                                   </div>
                                   <span>Varied Classes</span>
                                </li>
                             </ul>
                          </div> -->
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="bd-promotion-thumb-wrapper mb-60 wow fadeInRight" data-wow-duration="1s"
                        data-wow-delay=".3s">
                        <div class="bd-promotion-thumb">
                            <div class="bd-promotion-thumb-mask p-relative">
                                <img src="{{ asset('assets/images/schools.jpg') }}" alt="Image not found">
                                <div class="panel-2 wow"></div>
                            </div>
                        </div>
                        <div class="bd-promotion-shape d-none d-lg-block">
                            <img src="assets/img/shape/tripple-line.png" alt="Shape not found">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="swiper-slide">
                        <div class="bd-class-wrapper-2 text-center">
                            <div class="bd-class-2">
                                <div class="bd-class-icon-wrapper">
                                    <div class="bd-class-icon-2">
                                        <img style="width: 100px; height:100% ; padding:6px; object-fit:contain;"
                                            src="{{ asset('assets/images/nature_play.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="bd-class-content">
                                    <h3 class="bd-class-title"><a href="#">Nature Play Program</a></h3>
                                    <p>
                                        This 3 hours program caters for nursery and kindergarten children ages 2-6 years
                                        old. The nature play program takes children to the great outdoors and within nature
                                        to explore, discover, experiment, analyse and experience the natural elements that
                                        our nature has to offer. This learn through play program includes activities such as
                                        nature scavenger hunt, art & craft, nature discovery, science experiments and many
                                        more. We conduct different themes at different locations depending on your
                                        suitability.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="swiper-slide">
                        <div class="bd-class-wrapper-2 text-center">
                            <div class="bd-class-2 clr-2">
                                <div class="bd-class-icon-wrapper">
                                    <div class="bd-class-icon-2">
                                        <img style="width: 100px; height:100% ; padding:6px; object-fit:contain;"
                                            src="{{ asset('assets/images/overnight_camp.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="bd-class-content">
                                    <h3 class="bd-class-title"><a href="#">Overnight Camps</a></h3>
                                    <p>Our overnight camps which ranges from 3 days 2 nights, 4 days 3 nights to 1 week camp
                                        are designed for children to build life skills such as teamwork, leadership skills,
                                        and critical thinking skills and building character strength such as independence
                                        and responsibilities. Activities in these camps could include high rope courses,
                                        survival skills activities, raft building, seawater kayaking, fun and exciting team
                                        sports, team challenges and many more. Our camps are carefully designed and curated
                                        based on your requirements.</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="swiper-slide">
                        <div class="bd-class-wrapper-2 text-center">
                            <div class="bd-class-2 clr-2">
                                <div class="bd-class-icon-wrapper">
                                    <div class="bd-class-icon-2">
                                        <img style="width: 100px; height:100% ; padding:6px; object-fit:contain;"
                                            src="{{ asset('assets/images/nature_science.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="bd-class-content">
                                    <h3 class="bd-class-title"><a href="#">Day Programs</a></h3>
                                    <p>This day program caters for primary and secondary schools and centers who are looking
                                        at doing field trips for their students. This program takes children to various
                                        places depending on your requirements and objectives. Some of these programs include
                                        activities such as hiking, stream exploration, ocean conservation, discovery on
                                        mangrove forest, marine exploration and many more.</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="swiper-slide">
                        <div class="bd-class-wrapper-2 text-center">
                            <div class="bd-class-2 clr-3">
                                <div class="bd-class-icon-wrapper">
                                    <div class="bd-class-icon-2">
                                        <img style="width: 100px; height:100% ;  position:relative; padding:6px; object-fit:contain;"
                                            src="{{ asset('assets/images/special_event.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="bd-class-content">
                                    <h3 class="bd-class-title"><a href="#">Special Events</a></h3>
                                    <p>We have designed and conducted special events such as sports day, family day, festive
                                        celebrations for schools, kindergartens, learning centers and even residential
                                        clubs. Events can be conducted at your own premises or in the great outdoors.
                                        Activities designed will be based on your objectives and requirements.</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row bg-light p-4 mt-3 mb-3">
            <div class="col text-center">
                To enquire more about the programs and activities, contact us at <a style="color: #00BBAE;"
                    href="mailto:enquiry@madabouteducation.com">enquiry@madabouteducation.com</a>
            </div>
        </div>
    </div>

@endsection
