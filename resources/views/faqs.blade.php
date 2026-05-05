@extends('layouts.master')
@section('meta_title','MAE-FAQ') @section('meta_description','description')

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
                          <h1 class="bd-breadcrumb-title">FAQ</h1>
                          <div class="bd-breadcrumb-list">
                             <span><a href="{{ route('home') }}"><i class="flaticon-hut"></i>Home</a></span>
                             <span>FAQ</span>
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

     <!-- faq area start here  -->
     <section class="bd-faq-area pt-120 pb-95">
        <div class="container">
           <div class="row justify-content-center">
              <div class="col-lg-8">
                 <div class="bd-section-title-wrapper text-center mb-55 wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay=".3s">
                    <h2 class="bd-section-title mb-0">Frequently Asked Questions</h2>
                    <p>View classes by age, program, or subject. Check out upcoming camps and<br> special events too!
                    </p>
                 </div>
              </div>

           </div>
           <div class="row justify-content-center">
            <div class="col-lg-9">

                    <div class="bd-faq-content bd-faq-content-4 mb-25 wow fadeInLeft" data-wow-duration="1s"
                       data-wow-delay=".3s">
                       <div class="bd-faq">
                          <div class="accordion" id="accordionExample">
                             <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                   <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                      data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                      When was MAE established?
                                   </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                   aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                   <div class="accordion-body">
                                      <p>MAE has been running since 2016 with over 60 camps and more than 100 programs till date.</p>
                                   </div>
                                </div>
                             </div>
                             <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                   <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                      data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                      What are the types of programs that are available?
                                   </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                   data-bs-parent="#accordionExample">
                                   <div class="accordion-body">
                                      <p>
                                             MAE runs programs for children ages 2 years and above.  We have different programs for different age groups.
                                        <br>
                                             The Nature Play program is a 2 hours program for children 2 -6 years old to
                                           be accompanied by parents
                                        <br>
                                             The Nature Science program is a day program for children 7-12 years old.This program takes children to different places to learn about the many elements that nature has to offer
                                        <br>
                                             The Overnight camps which comprises of 3 days 2 nights, 4 days 3 nights and 1 week camp is designed for children 7-17 years old.

                                      </p>
                                   </div>
                                </div>
                             </div>
                             <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                   <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                      data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                      Where are these programs and camps held?
                                   </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                   data-bs-parent="#accordionExample">
                                   <div class="accordion-body">
                                      <p>As nature and outdoor is our classroom, we run different camps and programs at various locations depending on the objectives of the programs.  To learn more about the various locations, you can go to General Information under Venue / Facilities
                                    </p>
                                   </div>
                                </div>
                             </div>
                             <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                   <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                      data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                      What are the safety measures for the children?
                                   </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                   data-bs-parent="#accordionExample">
                                   <div class="accordion-body">
                                      <p>For overnight camps, these camps are usually located in resorts that are gated and guarded with 24 hours security.  Children will be in constant care by the facilitators and parents will get daily updates via a group chat.
                                       For day programs, risk assessments in every location will be done several times before the commencement of of the program.  Children will also be in constant guidance and care by our trained facilitators
                                      </p>
                                   </div>
                                </div>
                             </div>
                             <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                   <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                      data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                      Who are your facilitators?
                                   </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                   data-bs-parent="#accordionExample">
                                   <div class="accordion-body">
                                      <p>Our facilitators are well trained with nature and outdoor activities and are first aid certified with lots of passion in educating children the positive approach.
                                      </p>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
            </div>
           </div>
     </section>
     <!-- faq area end here  -->

     <!-- faq area 2 start here  -->
     <!-- <section class="bd-faq-area-2 theme-bg-6 pt-120 pb-70">
        <div class="container">
           <div class="row justify-content-center">
              <div class="col-lg-8">
                 <div class="bd-section-title-wrapper text-center mb-35 wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay=".3s">
                    <h2 class="bd-section-title mb-0">General Questions</h2>
                 </div>
              </div>
           </div>
           <div class="row">
              <div class="col-lg-6">
                 <div class="bd-faq-2 mb-50 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">
                    <ul>
                       <li>
                          <div class="bd-faq-number"><span>01</span></div>
                          <div class="bd-faq-content-3">
                             <h4 class="bd-faq-title">What is the best age to start Kindergarten?</h4>
                             <p>Some states and countries implement mandatory early childhood education. With
                                such rules, many preschool and kindergarten learning centers are built.</p>
                          </div>
                       </li>
                    </ul>
                 </div>
                 <div class="bd-faq-2 mb-50 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">
                    <ul>
                       <li>
                          <div class="bd-faq-number"><span>02</span></div>
                          <div class="bd-faq-content-3">
                             <h4 class="bd-faq-title">Which is the best preschool for your child ?</h4>
                             <p>Right after you book your party, you’ll receive an email confirming the date,
                                time, and details about what’s included in the package you’ve selected result observers
                                of Montessori children note that they are confident.</p>
                          </div>
                       </li>
                    </ul>
                 </div>
                 <div class="bd-faq-2 mb-50 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">
                    <ul>
                       <li>
                          <div class="bd-faq-number"><span>03</span></div>
                          <div class="bd-faq-content-3">
                             <h4 class="bd-faq-title"> Is there any play ground for students?</h4>
                             <p>From 1873 to 1886, the number of kindergarten children in this country has been
                                steadily increasing from a handful of one thousand to twenty thousand.</p>
                          </div>
                       </li>
                    </ul>
                 </div>
              </div>
              <div class="col-lg-6">
                 <div class="bd-faq-2 mb-50 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                    <ul>
                       <li>
                          <div class="bd-faq-number"><span>04</span></div>
                          <div class="bd-faq-content-3">
                             <h4 class="bd-faq-title"> Do you provide any scholarship for kids ?</h4>
                             <p>As parents, we are often excited about our kid’s milestones and may find
                                ourselves always in the rut to help our child achieve them.</p>
                          </div>
                       </li>
                    </ul>
                 </div>
                 <div class="bd-faq-2 mb-50 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                    <ul>
                       <li>
                          <div class="bd-faq-number"><span>05</span></div>
                          <div class="bd-faq-content-3">
                             <h4 class="bd-faq-title">Do you provide lunch, breakfast at Kindedo?</h4>
                             <p>What may be suitable for one may not for the other child. This means that age
                                criterion is an important parameter in determining at what age do kids start
                                kinder garten.</p>
                          </div>
                       </li>
                    </ul>
                 </div>
                 <div class="bd-faq-2 mb-50 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                    <ul>
                       <li>
                          <div class="bd-faq-number"><span>06</span></div>
                          <div class="bd-faq-content-3">
                             <h4 class="bd-faq-title">Is there any available course for parents?</h4>
                             <p>So, if you are interested in knowing kindergarten age in Texas, New York, Alaska,
                                or other states, well, have a look at the following table, which will help you in
                                providing a complete state-wise age guide.</p>
                          </div>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>
        </div>
     </section> -->
     <!-- faq area 2 end here  -->

     <!-- promotion area start here  -->
     <!-- <section class="bd-promotion-area pt-120 pb-60 fix">
        <div class="container">
           <div class="row align-items-center">
              <div class="col-xl-6 col-lg-6">
                 <div class="bd-promotion bd-promotion-2 mb-60 wow fadeInLeft" data-wow-duration="1s"
                    data-wow-delay=".3s">
                    <div class="bd-section-title-wrapper mb-35">
                       <h2 class="bd-section-title mb-10">Health and Safety</h2>
                       <span class="mb-10 d-inline-block">
                          Some states and countries implement mandatory early childhood education
                          such rules, many preschool.
                       </span>
                       <p> Being brave isn’t always a grand gesture sometimes it just means having a go attempting that
                          difficult question, offering an answer in a lesson when you’re simply really trying new.
                       </p>
                    </div>
                    <div class="bd-promotion-list-2">
                       <ul>
                          <li>
                             <div class="bd-promotion-icon">
                                <i class="flaticon-clean theme-bg-2"></i>
                             </div>
                             <span>Nightly cleaning</span>
                          </li>
                          <li>
                             <div class="bd-promotion-icon">
                                <i class="flaticon-hand-wash theme-bg"></i>
                             </div>
                             <span>Hand Washing</span>
                          </li>
                       </ul>
                    </div>
                 </div>
              </div>
              <div class="col-xl-6 col-lg-6">
                 <div class="bd-promotion-thumb-wrapper mb-60 wow fadeInRight" data-wow-duration="1s"
                    data-wow-delay=".3s">
                    <div class="bd-promotion-thumb">
                       <div class="bd-promotion-thumb-mask p-relative">
                          <img src="assets/img/promotion/3.jpg" alt="Image not found">
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
     </section> -->
     <!-- promotion area end here  -->

@endsection
