@extends('layouts.master')
@section('meta_title','MAE-About') @section('meta_description','description')

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
                           <a href="{{ route('about_us') }}">About MAE</a>
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

     <!-- promotion area start here  -->
     <section class="bd-promotion-area pt-120 pb-60">
        <div class="container">
           <div class="row align-items-center">
              <div class="col-xl-6 col-lg-6">
                 <div class="bd-promotion-thumb-wrapper mb-60 wow fadeInLeft" data-wow-duration="1s"
                    data-wow-delay=".3s">
                    <div class="bd-promotion-thumb">
                       <div class="bd-promotion-thumb-mask p-relative">
                          <img src="{{ asset('assets/images/B&D.jpg') }}" alt="Image not found">
                          <div class="panel wow"></div>
                       </div>
                    </div>
                    <div class="bd-promotion-shape d-none d-lg-block">
                       <img src="{{ asset('assets/img/shape/tripple-line.png') }}" alt="Shape not found">
                    </div>
                 </div>
              </div>
              <div class="col-xl-6 col-lg-6">
                 <div class="bd-promotion mb-60 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                    <div class="bd-section-title-wrapper mb-35">
                       <h2 class="bd-section-title mb-10">Our Story</h2>
                       <span>
                        Mad About Education Group is a company that is passionately involved in the education industry.  Formed by two educational idealists, the company strongly believes in the importance of building basic character strength in children with education.
                       </span>
                       <p >
                        Building character strength in children encourages them to develop life skills and learn more about themselves, their strength and weakness, their likes and dislikes and their potentials and capabilities.  With great character strength, it will help mould children in all aspect of life, be it socially, physically, mentally and emotionally.  And with that it shapes our children to become the potential leaders of their own contributing to the society that we are in.
                       </p>

                       <p class="text-align:justify;">
                        With great vision towards developing a solid foundation in the education industry in the country, we have developed a variety of programs and activities that are designed to encourage children to build character strength and developed different skill sets.  Our educational programs strongly emphasise on the concept of learning rather than studying hence we encourage children to learn through analysing, experimenting, exploring and experiencing in the different fields of subjects. Our programs which ranges from indoor and outdoor activities are designed for children of all ages.  We are also constantly developing new programs and activities and improving our current ones for the betterment of the children.
                       </p>
                    </div>
                    
                    <div class="bd-promotion-btn-wrapper flex-wrap">
                       <!-- <div class="bd-promotion-btn">
                          <a href="#" class="bd-btn">
                             <span class="bd-btn-inner">
                                <span class="bd-btn-normal">View More</span>
                                <span class="bd-btn-hover">View More</span>
                             </span>
                          </a>
                       </div> -->
                       <div class="bd-promotion-btn-2 bd-pulse-btn btn-2">
                          <a href="https://www.youtube.com/watch?v=lHghFcRLUyM" class="popup-video"><i
                                class="flaticon-play-button"></i> Watch MAE</a>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </section>
     <section class="bd-promotion-area pt-120 pb-60">
        <div class="container">
           <div class="row align-items-center">
              <div class="col-xl-6 col-lg-6">
                 <div class="bd-promotion-thumb-wrapper mb-60 wow fadeInLeft" data-wow-duration="1s"
                    data-wow-delay=".3s">
                    <div class="bd-promotion-thumb">
                       <div class="bd-promotion-thumb-mask p-relative">
                          <img src="{{ asset('assets/images/Why-Camp-MAE.jpg') }}" alt="Image not found">
                          <div class="panel wow"></div>
                       </div>
                    </div>
                    <div class="bd-promotion-shape d-none d-lg-block">
                       <img src="{{ asset('assets/img/shape/tripple-line.png') }}" alt="Shape not found">
                    </div>
                 </div>
              </div>
              <div class="col-xl-6 col-lg-6">
                 <div class="bd-promotion mb-60 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                    <div class="bd-section-title-wrapper mb-35">
                       <h2 class="bd-section-title mb-10">Why Camp MAE?</h2>
                       <span>
                        Camp MAE is a nature and outdoor education center that caters to promote the importance of nature education to children.
                       </span>
                       <p>
                        Developed by the Mad About Education Group, all programs and activities designed caters to children of all ages and places great emphasis on the importance of going back to the nature and encouraging the city child to explore the wilderness within their surrounding environment. Mad About Education conducts camps at several different locations depending on the objectives of each camp.
                       </p>

                       <p>
                        These locations are choosen based on several different important aspects such as security, safety, comfortability and its resources. These place are lushful greens and serene landscape provides children and parents the perfect place to escape from the hustle and bustle of city life and a wonderful place for children to learn and to connect with Mother Nature.
                       </p>
                    </div>
                    <!-- <div class="bd-promotion-list mb-50">
                       <ul>
                          <li>We believe every child is intelligent so we care.</li>
                          <li>Teachers make a difference of your child.</li>
                       </ul>
                    </div> -->
                    <!-- <div class="bd-promotion-btn-wrapper flex-wrap-->
                       <!-- <div class="bd-promotion-btn">
                          <a href="#" class="bd-btn">
                             <span class="bd-btn-inner">
                                <span class="bd-btn-normal">View More</span>
                                <span class="bd-btn-hover">View More</span>
                             </span>
                          </a>
                       </div> -->
                       <!-- <div class="bd-promotion-btn-2 bd-pulse-btn btn-2">
                          <a href="https://www.youtube.com/watch?v=yCBQX4ZEIs8" class="popup-video"><i
                                class="flaticon-play-button"></i> Watch MAE</a>
                       </div> -->
                       
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </section>
     <!-- promotion area end here  -->
     
  
@endsection