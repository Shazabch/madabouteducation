@extends('layouts.master')
@section('meta_title','Delivery-Policy') @section('meta_description','description')

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
                           <a href="{{ route('delivery_policy') }}">Delivery Policy</a>
                          </h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>Delivery Policy</span>
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
                 <h4 class="text_green text-decoration-underline">Applicability</h4>
                 <p>
                  This delivery policy applies only to physical products purchased from our store.
                 </p>
                 <h4 class="text_green text-decoration-underline">Shipping Methods & Processing Time</h4>
                 <p>
                  We offer several shipping options, including City-Link Express, J&T Express, and DHL eCommerce.
                 </p>
                 <p>
                  Standardized shipping rates:
                  <ul style="margin-left: 30px ">
                     <li>West Malaysia: RM8</li>
                     <li>East Malaysia: RM15</li>
                  </ul>
               </p>
                 <h4 class="text_green text-decoration-underline">Delivery Timeframe</h4>
                 <p>Orders are typically processed and shipped within 1 – 5 business days.</p>
                 <p>Delivery times vary based on your location.</p>

                 <h4  class="text_green text-decoration-underline">Express & International Shipping</h4>
                 <p>Not available at this time.</p>

                 <h4  class="text_green text-decoration-underline"> Tracking Information</h4>
                 <p>
                  Once your order has been shipped, you will receive a confirmation email with tracking details to monitor your shipment’s progress.
                 </p>
                 <h4  class="text_green text-decoration-underline">
                  Local Pickup
                 </h4>
                 <p>
                  Self-pickup is available at: <b>Unit 405 & 406, Block A, Level 4, Kelana Business Centre.</b>
                 </p>
                 <p>To schedule a pickup, please contact MAE Hotline number  <b>+6011 2775 8056 (Beverley)</b></p>
              </div>
           </div>
        </div>
     </section>
     <!-- promotion area end here  -->
     
  
@endsection