@extends('layouts.master')
@section('meta_title','MAE-Checkout Details') @section('meta_description','description')

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
                          <h1 class="bd-breadcrumb-title">Checkout</h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>Checkout</span>
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
     @livewire('parent.checkout-details-component')

     <!-- newsletter area start here  -->
     <!-- <section class="bd-newsletter-area ">
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
