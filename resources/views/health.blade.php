@extends('layouts.master')
@section('meta_title','MAE - Health & Safety') @section('meta_description','description')

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
                           <a href="{{ route('health') }}">Health & safety</a>
                          </h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>About</span>
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
                     <h2 class="bd-section-title mb-10">Health and Safety</h2>
                     <span class="mb-10 d-inline-block">
                        MAE truly understands every parents’ concern of their child, and that is why our top priority is your child’s safety.
                       

                     </span>
                     <p>
                        MAE has maintained beyond the highest standards of safety with our facilities, programs and qualified team members the moment your child comes to camp or programs.
                     </p>
                     <p >
                        At every camp and programs, we ensure the highest level of safety for your children as every activity is facilitated by a trained supervisor and is assisted with several more trained facilitators.  Each camp location that we go to has highly tight, 24 hours security to safekeep the children and facilitators. Every child that goes to camps and programs with us will be insured under travel insurance that covers your child as MAE prioritizes your child’s safety.
                     </p>
                     <p >
                        In addition to a proactive approach in health and safety of your child, the facilitators are first aid certified and have the ability to handle any emergency situation. In addition, clinics and hospitals are located nearby to each location in case of any severe cases.  Parents of the young children are advised to pack any medications to bring along for the camp/program if necessary and required to sign an authorization form.
                     </p>
                  </div>
                  
               </div>
            </div>
            <div class="col-xl-6 col-lg-6">
               <div class="bd-promotion-thumb-wrapper mb-60 wow fadeInRight" data-wow-duration="1s"
                  data-wow-delay=".3s">
                  <div class="bd-promotion-thumb">
                     <div class="bd-promotion-thumb-mask p-relative">
                        <img src="{{ asset('assets/images/health.jpg') }}" alt="Image not found">
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