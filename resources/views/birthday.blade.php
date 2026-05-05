@extends('layouts.master')
@section('meta_title','Birthday Party') @section('meta_description','description')

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
                          <h1 class="bd-breadcrumb-title">Birthday Party</h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>Birthday Party</span>
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
                     <h3 class="">Looking for something different to celebrate your child’s birthday?  Something in the nature and outdoors? </h3>

                     <p>Mad About Education uses the nature environment and turns it into a special place to celebrate little one’s birthday.   It could be a forest, a lake, park and even the beach - we are able to curate a fun and exciting birthday party that is guaranteed to filled your little ones with loads of smiles and laughter.


                     </p>
                     <p>
                        Details of the Birthday party are as follows:
                        <ul style="list-style-type: none;">
                           <li><b>Venue:</b> Depending on your requirement</li>
                           <li><b>Time:</b> 3 hours</li>
                           <li><b>Price:</b> RM 90 per child – subject to SST, no charge for adults (inclusive of fun filled activities, materials and forest/park permit – food and decorations can be arranged at additional price) </li>
                        </ul>
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
                        <img src="{{ asset('assets/images/birthday-party.jpg') }}" alt="Image not found">
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

   <div class="container">
      <div class="row bg-light p-4 mt-3 mb-3">
         <div class="col text-center">
            Send us an enquiry for further information at <a style="color: #00BBAE;" href="mailto:enquiry@madabouteducation.com">enquiry@madabouteducation.com</a>
         </div>
      </div>
   </div>

@endsection
