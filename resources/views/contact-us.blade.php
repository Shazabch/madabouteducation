@extends('layouts.master')
@section('meta_title','MAE-Contact') @section('meta_description','description')

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
                          <h1 class="bd-breadcrumb-title">Contact Us</h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>Contact Us</span>
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

     <!-- contact info area start here -->
     <section class="bd-contact-info-area pt-120 pb-95">
        <div class="container">
           <div class="row justify-content-center">
              <div class="col-lg-4 col-md-4 col-sm-12">
                 <div class="bd-contact-info-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                    <div class="bd-contact-info">
                       <div class="bd-contact-info-content">
                          <div class="bd-contact-info-icon cat-1">
                             <a href="tel:9072003462"><i class="flaticon-phone-call"></i></a>
                          </div>
                          <h6><a href="tel:+601127758056">+6011 2775 8056</a></h6>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                 <div class="bd-contact-info-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                    <div class="bd-contact-info">
                       <div class="bd-contact-info-content">
                          <div class="bd-contact-info-icon cat-2">
                             <a href="#"><i class="flaticon-location-pin"></i></a>
                          </div>
                          <h6><a href="#">Dynamic Learning Strategy Sdn Bhd (1283315-P).Unit 405 & 406 Block A, Level 4, Kelana Business Centre
                        </a></h6>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                 <div class="bd-contact-info-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
                    <div class="bd-contact-info">
                       <div class="bd-contact-info-content">
                          <div class="bd-contact-info-icon cat-3">
                             <a href="mailto:enquiry@madabouteducation.com"><i class="flaticon-email"></i></a>
                          </div>
                          <h6><a href="mailto:enquiry@madabouteducation.com">enquiry@madabouteducation.com</a></h6>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </section>
     <!-- contact info area end here-->

     <!-- contact area start here  -->
     <section class="bd-contact-area pb-60">
        <div class="container">
           <div class="row">
              @livewire('admin.contact-us-component')
              <div class="col-xl-6 mb-60">
                 <div class="bd-contact-map wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3983.991363350641!2d101.58851617477643!3d3.0969546534716956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zM8KwMDUnNDkuMCJOIDEwMcKwMzUnMjcuOSJF!5e0!3m2!1sen!2s!4v1696191228139!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                 </div>
              </div>
           </div>
        </div>
     </section>
     <!-- contact area end here  -->

     <!-- newsletter area start here  -->
     <!-- <section class="bd-newsletter-area">
        <div class="container">
           <div class="bd-newsletter pt-100 pb-100 theme-bg">
              <div class="bd-newsletter-bg" data-background="{{ asset('assets/img/bg/newsletter-bg.jpg') }}"></div>
              <div class="row justify-content-center">
                 <div class="col-xl-8 col-lg-10">
                    <div class="bd-newsletter-content">
                       <div class="bd-section-title-wrapper text-center is-white mb-45">
                          <h2 class="bd-section-title mb-0">Join Our Newsletter</h2>
                          <p>Subscribe our newsletter to get our latest update & news.</p>
                       </div>
                       <div class="bd-newsletter-form">
                          <form action="#">
                             <div class="bd-newsletter-input">
                                <input type="text" placeholder="your email">
                                <button type="submit" class="bd-btn">
                                   <span class="bd-btn-inner">
                                      <span class="bd-btn-normal"><i
                                            class="fa-sharp fa-solid fa-paper-plane"></i>Subscribe now</span>
                                      <span class="bd-btn-hover"><i
                                            class="fa-sharp fa-solid fa-paper-plane"></i>Subscribe now</span>
                                   </span>
                                </button>
                             </div>
                          </form>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </section> -->
     <!-- newsletter area end here  -->
  
@endsection