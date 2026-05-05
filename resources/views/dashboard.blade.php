@extends('layouts.parent')
@section('meta_title','MAE-Dashboard') @section('meta_description','description')
@section('sub-content')
<section class="bd-shop-cat-area pt-120 pb-90">
    <div class="container">
       <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10">
             <div class="bd-section-title-wrapper text-center mb-55 wow fadeInUp" data-wow-duration="1s"
                data-wow-delay=".2s">
                <h2 class="bd-section-title mb-0">Dashboard</h2>
                <!-- <p>Our multi-level kindergarten programs cater to the age group of 2-12 years<br> with a curriculum
                   focussing children.</p> -->
             </div>
          </div>
       </div>
       <div class="row justify-content-center">
          <div class="col-lg-3 col-md-6 col-6">
             <div class="bd-shop-cat-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                <a href="{{ route('my_children') }}">
                   <div class="bd-shop-cat">
                      <div class="bd-shop-cat-content">
                         <div class="bd-shop-cat-title cat-1">
                            <h4>{{ auth()->user()->children->count() }}</h4>
                         </div>
                         <span>My Children</span>
                      </div>
                   </div>
                </a>
             </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
             <div class="bd-shop-cat-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
                <a href="{{ route('my_orders') }}">
                   <div class="bd-shop-cat">
                      <div class="bd-shop-cat-content">
                         <div class="bd-shop-cat-title cat-2">
                            <h4>{{ auth()->user()->orders->count() }}</h4>
                         </div>
                         <span>My Orders</span>
                      </div>
                   </div>
                </a>
             </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
             <div class="bd-shop-cat-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                <a href="{{ route('my_programs') }}">
                   <div class="bd-shop-cat">
                      <div class="bd-shop-cat-content">
                         <div class="bd-shop-cat-title cat-3">
                            <h4>{{ auth()->user()->programOrders->count() }}</h4>
                         </div>
                         <span>Booked Programs</span>
                      </div>
                   </div>
                </a>
             </div>
          </div>
          <!-- <div class="col-lg-3 col-md-6 col-6">
             <div class="bd-shop-cat-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".7s">
                <a href="shop.html">
                   <div class="bd-shop-cat">
                      <div class="bd-shop-cat-content">
                         <div class="bd-shop-cat-title cat-4">
                            <h4>8-12</h4>
                         </div>
                         <span>Years</span>
                      </div>
                   </div>
                </a>
             </div>
          </div> -->
       </div>
    </div>
 </section>
@endsection