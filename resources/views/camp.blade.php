@extends('layouts.master')
@section('meta_title','MAE-Camp/Program Preparation') @section('meta_description','description')

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
                           <a href="{{ route('camp') }}">Camp/Program Preparation</a>
                          </h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>Camp/Program Preparation</span>
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
                     <h2 class="bd-section-title mb-10">Camp/Program Preparation</h2>

                     <p>  At every camp and programs, a group chat with the parents will be set up 10 days to 1 week prior to the dates.  Constant updates which include videos and photos will be given to parents.
                     </p>
                     <p>
                        Though we try to accommodate as much as we can for a less hassle experience for both parents and children, we highly advise parents to pack the following items below as for sanitary purposes:
                     </p>
                     <div class="p-3">
                        <ul>
                           <li>Mosquito repellent</li>
                           <li>Clothing – sports attire, shoes, slippers, hat, comfortable clothing</li>
                           <li>Amenities – shampoo, body shampoo, toothbrush, toothpaste</li>
                           <li>Towel</li>
                           <li>Sun Block</li>
                           <li>Rain Coat</li>
                           <li>Water bottle</li>
                           <li>Swimming attire</li>
                           <li>Medication if needed</li>
                       </ul>
                       </div>
                  </div>

               </div>
            </div>
            <div class="col-xl-6 col-lg-6">
               <div class="bd-promotion-thumb-wrapper mb-60 wow fadeInRight" data-wow-duration="1s"
                  data-wow-delay=".3s">
                  <div class="bd-promotion-thumb">
                     <div class="bd-promotion-thumb-mask p-relative">
                        <img src="{{ asset('assets/images/camp-prep.JPG') }}" alt="Image not found">
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
