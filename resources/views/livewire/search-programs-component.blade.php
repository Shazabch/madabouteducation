<div>
    <div class="bd-search-btn-wrapper">
        <button class="bd-search-open-btn">
           <i class="flaticon-search " style="font-size: 20px; color:#FF9B24;" title="search programs.."></i>
        </button>
     </div>
    <div class="bd-search-popup-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bd-search-popup">
                        <div class="bd-search-form">
                                <div class="bd-search-input">
                                    <input type="text" wire:model.debounce.500ms="search" placeholder="Type here to search ...">
                                    <div class="bd-search-submit">
                                        <button type="submit"><i class="flaticon-search"></i></button>
                                    </div>
                                </div>
                            <div class="bd-search-close">
                                <div class="bd-search-close-btn">
                                    <button><i class="fa-thin fa-close"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12" style="height: 15px;">
                    <small wire:loading class="text-white">Loading...</small>
                </div>
                @forelse($totalPrograms as $singleProgram)
                    <div class="col-md-4">
                        <a href="{{ route('programs.detail', [$singleProgram->category->slug, $singleProgram->slug]) }}">
                            <p class="text-white">{{ $singleProgram->title }}</p>
                        </a>
                    </div>
                @empty
                <div><p class="text-white">No Record Found</p></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
