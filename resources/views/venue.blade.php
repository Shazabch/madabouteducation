@extends('layouts.master')
@section('meta_title','MAE-Venue & facilities') @section('meta_description','description')
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/nanogallery2@3/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/nanogallery2@3/dist/jquery.nanogallery2.min.js"></script>
<style>
   .nGY2 .nGY2GThumbnail {
      background-color: white;
   }
   .nGY2 .nGY2GThumbnailImage {
      background-color: white;
      border-radius: 10px;
   }
</style>
@endpush
   
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
                           <a href="{{ route('venue') }}">Venue / Facilities</a>
                          </h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>Venue / Facilities</span>
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
               <div class="row mb-3 text-center justify-content-center">
                  <div class="col-md-9">
                     <p style="font-size: larger;">
                        Mad About Education conducts camps and programs at several different locations depending on the objectives.  These locations are chosen based on several different important aspects such as security, safety, comfortability and its resources.
                     </p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="swiper-slide">
                        <div class="bd-class-wrapper-2 ">
                           <div class="bd-class-2">
                              <div class="bd-class-content">
                                 <h3 class="bd-class-title"><a href="#">These are some of the locations we do for programs: </a></h3>
                                 <p>
                                   <ul class="text-lg-start">
                                    <li>Kuala Selangor Nature Park</li>
                                    <li>Residential beach at Port Dickson</li>
                                    <li>National Elephant Conservation Center in Kuala Gandah, Pahang</li>
                                    <li>Bukit Kiara Hiking Park, TTDI</li>
                                    <li>Taman Persekutuan Bukit Kiara, TTDI</li>
                                    <li>Kota Damansara Community Forest</li>
                                    <li>Morib Beach, Banting</li>
                                    <li>Kelanang Beach, Banting</li>
                                    <li>Putrajaya Wetland Park, Putrajaya</li>
                                    <li>Taman Saujana Hijau, Putrajaya</li>
                                    <li>and many more</li>

                                   </ul>
                                 </p>
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="swiper-slide" >
                        <div class="bd-class-wrapper-2 text-center">
                           <div class="bd-class-2 clr-2">
                              <div class="bd-class-content">
                                 <h3 class="bd-class-title"><a href="#">These are some of the locations that we conduct some of our camps </a></h3>
                                 <p>
                                   <ul class="text-lg-start">
                                    <li>Eagle Ranch Resort, Port Dickson  </li> 
                                    <li>Paradise Valley Broga, Broga, Semenyih  </li> 
                                    <li>Earth Camp by Nomad Adventure, Gopeng  </li> 
                                    <li>Kampong Solesor Beach Resort, Port Dickson  </li> 


                                   </ul>
                                 </p>
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
     </section>

     <section class="pb-120">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <section>
                        <div class="container my-5">
                           <div ID="ngy2p" data-nanogallery2='{
                              "thumbnailWidth":   "auto XS80 SM120",
                              "thumbnailHeight":  "200 XSauto SMauto"
                              "thumbnailAlignment": "fillWidth",
                              "thumbnailOpenImage": true,
                              "thumbnailBorderHorizontal": 0,
                              "thumbnailL1BorderHorizontal":0, 
                              "thumbnailBorderVertical":0,
                              "thumbnailL1BorderVertical":0,
                            }'>
                              <a href="{{ asset('assets/images/Venue 1.jpg') }}" data-ngthumb="{{ asset('assets/images/Venue 1.jpg') }}" data-ngdesc=""></a>
                              <a href="{{ asset('assets/images/Venue 2.jpg') }}" data-ngthumb="{{ asset('assets/images/Venue 2.jpg') }}" data-ngdesc=""></a>
                              <a href="{{ asset('assets/images/Venue 3.jpg') }}" data-ngthumb="{{ asset('assets/images/Venue 3.jpg') }}" data-ngdesc=""></a>
                              <a href="{{ asset('assets/images/Venue 4.jpg') }}" data-ngthumb="{{ asset('assets/images/Venue 4.jpg') }}" data-ngdesc=""></a>
                              <a href="{{ asset('assets/images/Venue 5.jpg') }}" data-ngthumb="{{ asset('assets/images/Venue 5.jpg') }}" data-ngdesc=""></a>
                              <a href="{{ asset('assets/images/Venue 6.jpg') }}" data-ngthumb="{{ asset('assets/images/Venue 6.jpg') }}" data-ngdesc=""></a>
                              <a href="{{ asset('assets/images/Venue 7.jpg') }}" data-ngthumb="{{ asset('assets/images/Venue 7.jpg') }}" data-ngdesc=""></a>
                            
                          </div>
                        </div>
                       </section>
                  </div>
               </div>
            </div>
     </section>

     

   <section>
      <div class="container">
         <div class="row text-center">
            <h3 class="bd-class-title mb-2"><a href="#">Facilities in some of these places include:</a></h3>
         </div>
         <div class="row">
            <div class="col-md-4 text-center">
               <div class="">
                  <div class="bd-class-icon ml-4">
                     <img style="width: 100px; height:100% ; padding:6px; object-fit:contain;"  src="{{ asset('assets/images/shower-toilet.png') }}" alt="">
                  </div>
                  <div class="bd-class-content">
                     <h3 class="bd-class-title"><a href="#">Shower / Toilet Facilities</a></h3>
                  </div>
               </div>
            </div>
            <div class="col-md-4 text-center">
               <div class="">
                  <div class="bd-class-icon ml-4">
                     <img style="width: 100px; height:100% ; padding:6px; object-fit:contain;"  src="{{ asset('assets/images/halal.png') }}" alt="">
                  </div>
                  <div class="bd-class-content">
                     <h3 class="bd-class-title"><a href="#">Halal Food</a></h3>
                  </div>
               </div>
            </div>
            <div class="col-md-4 text-center">
               <div class="">
                  <div class="bd-class-icon ml-4">
                     <img style="width: 100px; height:100% ; padding:6px; object-fit:contain;"  src="{{ asset('assets/images/first-aid-kit.png') }}" alt="">
                  </div>
                  <div class="bd-class-content">
                     <h3 class="bd-class-title"><a href="#">First Aid Kit</a></h3>
                  </div>
               </div>
            </div>
            <div class="col-md-4 text-center">
               <div class="">
                  <div class="bd-class-icon ml-4">
                     <img style="width: 100px; height:100% ; padding:6px; object-fit:contain;"  src="{{ asset('assets/images/Electricity.png') }}" alt="">
                  </div>
                  <div class="bd-class-content">
                     <h3 class="bd-class-title"><a href="#">Electricity </a></h3>
                  </div>
               </div>
            </div>
            <div class="col-md-4 text-center">
               <div class="">
                  <div class="bd-class-icon ml-4">
                     <img style="width: 100px; height:100% ; padding:6px; object-fit:contain;"  src="{{ asset('assets/images/hall.png') }}" alt="">
                  </div>
                  <div class="bd-class-content">
                     <h3 class="bd-class-title"><a href="#">Halls </a></h3>
                  </div>
               </div>
            </div>
            <div class="col-md-4 text-center">
               <div class="">
                  <div class="bd-class-icon ml-4">
                     <img style="width: 100px; height:100% ; padding:6px; object-fit:contain;"  src="{{ asset('assets/images/Dormitories.png') }}" alt="">
                  </div>
                  <div class="bd-class-content">
                     <h3 class="bd-class-title"><a href="#">Dormitories</a></h3>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
  
@endsection