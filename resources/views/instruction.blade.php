@extends('layouts.master')
@section('meta_title','MAE-Instructions') @section('meta_description','description')

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
                          <h1 class="bd-breadcrumb-title">Instructions</h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>Instructions For Parents</span>
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

     <section>
      <div class="container my-5">
            <div class="row">
               <div class="col-md-6">
                   <h4>1- Register / login</h4>
                   <p>Use this page to login or click the register button to register.</p>
                   <img src="{{ asset('img/auth.png') }}" width="600px" height="300px" alt="">
               </div>
               <div class="col-md-6">
                   <h4>2- Adding Guardians & Childs</h4>
                   <p>Add Guardians & Childrens through your dashboard to use later.</p>
                   <img src="{{ asset('img/childs.png') }}" width="600px" height="300px" alt="">
               </div>
               <div class="col-md-6 mt-3">
                   <h4>3- Select a program</h4>
                   <p>Select a program from these categories you want to book.</p>
                   <img src="{{ asset('img/programs.png') }}" width="600px" height="300px" alt="">
               </div>
               <div class="col-md-6 mt-3">
                   <h4>4- Start Booking</h4>
                   <p>While booking you can prefill the child details by using prefill child dropdown.</p>
                   <img src="{{ asset('img/booking.png') }}" width="600px" height="300px" alt="">
               </div>
               <div class="col-md-6 mt-3">
                   <h4>5- Filling Booking Form</h4>
                   <p>You need to fill this form for each child (once).</p>
                   <img src="{{ asset('img/booking.png') }}" width="600px" height="300px" alt="">
               </div>
               <div class="col-md-6 mt-3">
                   <h4>6- Checkout Page</h4>
                   <p>Go to Cart after filling form you can also add products & other programs along.</p>
                   <img src="{{ asset('img/booking.png') }}" width="600px" height="300px" alt="">
               </div>
               <div class="col-md-6 mt-3">
                   <h4>7- Placing Order</h4>
                   <p>Place the order after filling the billing form</p>
                   <img src="{{ asset('img/billing.png') }}" width="600px" height="300px" alt="">
               </div>
               <div class="col-md-6 mt-3">
                   <h4>8- Making payment</h4>
                   <p>Use your card to pay for your order</p>
                   <img src="{{ asset('img/payment.png') }}" width="600px" height="300px" alt="">
               </div>
            </div>
      </div>
      <div class="container my-5">
         <section>
            <div class="row">
               <div class="col">
                  <h2 style="background-color: #55d6cd ;" class="mt-5 text-white text-center">Thank You</h2>
               </div>
            </div>
         </section>
      </div>
     </section>

@endsection
