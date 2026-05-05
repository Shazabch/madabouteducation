@extends('layouts.master')
@section('meta_title','Privacy-Policy') @section('meta_description','description')

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
                           <a href="{{ route('privacy_policy') }}">Privacy Policy</a>
                          </h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>Privacy Policy</span>
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

     <!-- promotion area start here  -->
     <section class="bd-promotion-area pt-120 pb-60">
        <div class="container">
           <div class="row align-items-center">
              <div class="col-xl-12 col-lg-12">
                 <h4 class="text_green text-decoration-underline"> Information We Collect</h4>
                 <p>
                  When you purchase a product, enroll in a program, or interact with our website, we may collect personal information such as:
                  <ul style="margin-left: 30px ">
                     <li>Your name</li>
                     <li>Children’s details (for programs and camps)</li>
                     <li>Email address</li>
                     <li>Shipping address</li>
                     <li>Payment information</li>

                  </ul>
                 </p>
                 <h4 class="text_green text-decoration-underline">How We Use Your Information</h4>
                 <p>
                  To process orders/camps/programs, manage accounts, and improve services.
                 </p>
                 <p>
                  With your consent, we may send promotional materials and updates.
               </p>
                 <h4 class="text_green text-decoration-underline">Data Protection</h4>
                 <p>We prioritize your privacy and data security by implementing measures to protect against unauthorized access and disclosure.</p>
              </div>
           </div>
        </div>
     </section>
     <!-- promotion area end here  -->
     
  
@endsection