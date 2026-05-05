@extends('layouts.master')
@section('meta_title','MAE-Gallery') @section('meta_description','description')

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
                          <h1 class="bd-breadcrumb-title">Gallery</h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>Gallery</span>
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
          @forelse($images as $image)
          <a href="{{asset($image)}}" data-ngthumb="{{asset($image)}}" data-ngdesc=""></a>
          @empty
                   No Content in the gallery
         @endforelse
    
        </div>
      </div>
     </section>
     

     <!-- gallery area start here  -->
     
     <!-- gallery area end here  -->

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