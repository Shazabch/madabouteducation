<footer>
    <div class="bd-footer-area fix pt-170 theme-bg-6">
       <div class="bd-wave-wrapper">
          <div class="bd-wave"></div>
          <div class="bd-wave"></div>
       </div>
       <div class="theme-bg bd-footer-wrapper p-relative pt-60">
          <div class="container">
             <!-- footer area bg here  -->
             <div class="bd-footer-bg-2" data-background=""></div>
             <div class="bd-footer-top">
                <div class="row ">
                   <div class="col-lg-6 text-center">
                      <div class="bd-footer-top-widget-1 mb-60">
                         <div class="bd-footer-logo mb-15 ">
                            <a href="index.html"> <img src="{{ asset('assets/images/mae-logo.png') }}"  alt="img not found!" style="width:180px;"></a>
                         </div>
                         <div class="bd-footer-widget-content  is-white mb-40">
                            <p>
                              Camp MAE is a nature and outdoor education center that caters to promote the importance of nature education to children.
                            </p>
                         </div>
                      </div>
                   </div>
                   <div class="col-lg-6">
                      <div class="bd-newsletter-content-2 p-relative z-index-1 mb-60">
                         <h4 class="bd-footer-widget-title is-white mb-20">Join Our Newsletter</h4>
                         @livewire('do-newsletter-subcription-component')
                      </div>
                   </div>
                </div>
             </div>
             <div class="bd-footer-2 pb-15 pt-60 p-relative">
                <div class="bd-footer-shape d-none d-lg-block">
                   <img src="{{ asset('assets/img/shape/white-curved-line.png') }}" alt="img not found!">
                </div>
                <div class="row">
                   <div class="col-lg-3 col-md-6 col-sm-6">
                      <div class="bd-footer-widget-2 mb-50">
                         <div class="bd-footer-widget-content">
                            <h4 class="bd-footer-widget-title is-white mb-20">Quick links</h4>
                            <div class="bd-footer-list bd-footer-list-2">
                               <ul>
                                  <li><a href="{{ route('delivery_policy') }}">Delivery Policy</a></li>
                                  <li><a href="{{ route('refund_policy') }}">Refund Policy</a></li>
                                  <li><a href="{{ route('privacy_policy') }}">Privacy Policy</a></li>
                                  <li><a href="{{ route('terms_conditions') }}">Terms & Conditions</a></li>
                                  <li><a href="{{ route('contact_us') }}">Contact</a></li>
                                  <li><a href="{{ route('instruction') }}">Instructions</a></li>
                               </ul>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="col-lg-3 col-md-6 col-sm-6">
                      <div class="bd-footer-widget-2 mb-50">
                         <div class="bd-footer-widget-content">
                            <h4 class="bd-footer-widget-title is-white mb-20">Programs</h4>
                            <div class="bd-footer-list bd-footer-list-2">
                               <ul>
                                 @foreach($vc_programs->take('5') as $program)
                                 <li><a href="{{ route('programs.detail',[$program->category->slug,$program->slug]) }}">{{ $program->title }}</a></li>
                                 @endforeach
                                  <li><a href="{{ route('programs') }}">View All Programs</a></li>
                               </ul>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="col-lg-3 col-md-6 col-sm-6">
                      <div class="bd-footer-widget-2 mb-50">
                         <div class="bd-footer-widget-content">
                            <h4 class="bd-footer-widget-title is-white mb-20">Social Links</h4>
                            <div class="bd-footer-list bd-footer-list-2">
                               <!-- hero area side social  -->
                               <div class="bd-footer-social-wrapper is-white">
                                  <div class="bd-footer-social">
                                     <a href="https://www.facebook.com/madabouteducationgroup" target="_blank"><i class="fa-brands fa-facebook-f"></i>facebook</a>
                                  </div>
                                  <div class="bd-footer-social">
                                     <a href="https://www.instagram.com/madabouteducation.group/" target="_blank"><i class="fa-brands fa-instagram"></i>instagram</a>
                                  </div>
                                  <!-- <div class="bd-footer-social">
                                     <a href="#"><i class="fa-brands fa-youtube"></i>youtube</a>
                                  </div> -->
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="col-lg-3 col-md-6 col-sm-6">
                      <div class="bd-footer-widget-2 mb-50">
                         <div class="bd-footer-widget-content">
                            <h4 class="bd-footer-widget-title is-white mb-20">Contact Us</h4>
                            <div class="bd-footer-contact is-white">
                               <ul>
                                  <li><i class="fa-light fa-location-dot"></i>
                                    Dynamic Learning Strategy Sdn Bhd (1283315-P) Unit 405 & 406 Block A, Level 4, Kelana Business Centre</li>
                                  <li><i class="fa-light fa-phone"></i><a href="tel:+601127758056">+6011 2775 8056</a></li>
                                  <li><i class="fa-light fa-envelope"></i><a
                                        href="mailto:enquiry@madabouteducation.com">enquiry@madabouteducation.com</a></li>
                               </ul>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="bd-footer-copyright pb-5 pt-25">
                <div class="bd-footer-copyright-wrap d-flex justify-content-center">
                   <div class="bd-footer-copyright-text is-white pb-20">
                      <p>Copyright &copy;{{ date('Y') }} <a href="#"
                            rel="nofollow">Dynamic Learning Strategy Sdn Bhd (1283315-P). All rights reserved
                           </a>
                      </p>
                   </div>
                </div>
             </div>
             {{-- <div class="bd-footer-copyright">
                <div class="bd-footer-copyright-wrap d-flex justify-content-center">
                   <div class="bd-footer-copyright-text is-white pb-20">
                      <p>Developed by <a href="https://majesticsofts.com/" target="_blank" style="color: #6d41cc" rel="nofollow">@MajesticSofts</a>
                      </p>
                   </div>
                </div>
             </div> --}}
          </div>
       </div>
    </div>
 </footer>
