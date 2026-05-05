<!-- class area start here -->
<section class="bd-class-area pt-120 pb-120">
    <div class="container">
       <div class="row justify-content-center">
          <div class="col-lg-8">
             <div class="bd-section-title-wrapper text-center mb-55 wow fadeInUp" data-wow-duration="1s"
                data-wow-delay=".2s">
                <h2 class="bd-section-title mb-0">Shop by Category</h2>
                <p></p>
             </div>
          </div>
       </div>
       <div class="row">
        @forelse($categories as $category)
        <div class="col-md-3">
           <div class="bd-class-wrapper-2 text-center h-100">
              <div class="bd-class-2 {{ $loop->even ? 'clr-2':'' }} h-100">
                 <div class="bd-class-icon-wrapper">
                    <div class="bd-class-icon-2">
                     <img style="width: 100px; height:100%; padding:6px; object-fit:contain;" src="{{ asset($category->getImage()) }}" alt="{{ $category->name }}">
                    </div>
                 </div>
                 <div class="bd-class-content">
                    <h6 class="bd-class-title"><a href="{{ route('shop', ['category' => $category->slug]) }}">{{ $category->name }}</a></h6>
                    <small>{{ $category->description }}</small>
                    <p class="text-muted mt-2">{{ $category->products_count }} Products</p>
                    <div class="bd-class-btn mt-4">
                       <a href="{{ route('shop', ['category' => $category->slug]) }}" class="bd-btn bd-btn-grey">
                          <span class="bd-btn-inner">
                             <span class="bd-btn-normal">View Products</span>
                             <span class="bd-btn-hover">View Products</span>
                          </span>
                       </a>
                    </div>
                 </div>
              </div>
           </div>
        </div>
        @empty
        <div class="text-center">
            No Product Categories Found!
        </div>
        @endforelse
       </div>
    </div>
 </section>
 <!-- class area end here -->
