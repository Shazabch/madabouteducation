<!-- class area start here -->
<section class="bd-class-area pt-120 pb-120">
    <div class="container">
       <div class="row justify-content-center">
          <div class="col-lg-8">
             <div class="bd-section-title-wrapper text-center mb-55 wow fadeInUp" data-wow-duration="1s"
                data-wow-delay=".2s">
                <h2 class="bd-section-title mb-0">Programs by Category</h2>
                <p></p>
             </div>
          </div>
       </div>
       <div class="row">
        @forelse($vc_program_categories as $category)
        <div class="col-md-3">
           <div class="bd-class-wrapper-2 text-center h-100">
              <div class="bd-class-2 {{ $loop->even ? 'clr-2':'' }} h-100">
                 <div class="bd-class-icon-wrapper">
                    <div class="bd-class-icon-2">
                     <img style="width: 100px; height:100% ; padding:6px; object-fit:contain;"  src="{{ asset($category->icon) }}" alt="">
                    </div>
                 </div>
                 <div class="bd-class-content">
                    <h6 class="bd-class-title"><a href="{{ route('programs.category',$category->slug) }}">{{ $category->title }}</a></h6>
                    <small>{{ $category->short_desc }}</small>
                    <div class="bd-class-btn mt-4">
                       <a href="{{ route('programs.category',$category->slug) }}" class="bd-btn bd-btn-grey">
                          <span class="bd-btn-inner">
                             <span class="bd-btn-normal">View Details</span>
                             <span class="bd-btn-hover">View Details</span>
                          </span>
                       </a>
                    </div>
                 </div>
              </div>
           </div>
        </div>
        @empty
        <div class="text-center">
            No Porgram Category Found!
        </div>
        @endforelse

       </div>
    </div>
 </section>
 <!-- class area end here -->
