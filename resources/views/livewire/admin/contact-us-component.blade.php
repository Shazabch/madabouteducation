<div class="col-xl-6 mb-60">
    <div class="">
        <div class="bd-contact-form wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">
           <h3 class="bd-contact-form-title mb-25">Contact Us Right Here</h3>
           <form wire:submit.prevent="submitForm">
              <div class="row">
                 <div class="col-md-6">
                    <div class="bd-contact-input mb-30">
                       <label for="name">Name <sup><i class="fa-solid fa-star-of-life"></i></sup></label>
                       <input wire:model.defer="name" id="name" type="text" class="@error('name') border-red-500 @enderror">
                       @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                 </div>
                 <div class="col-md-6">
                    <div class="bd-contact-input mb-30">
                       <label for="email">Email <sup><i class="fa-solid fa-star-of-life"></i></sup></label>
                       <input wire:model.defer="email" id="email" type="text" class="@error('email') border-red-500 @enderror">
                       @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                 </div>
                 <div class="col-md-6">
                    <div class="bd-contact-input mb-30">
                       <label for="phone">Phone <sup><i class="fa-solid fa-star-of-life"></i></sup></label>
                       <input wire:model.defer="phone" id="phone" type="text" class="@error('phone') border-red-500 @enderror">
                       @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                 </div>
                 <div class="col-md-6">
                    <div class="bd-contact-input mb-30">
                       <label for="subject">Subject <sup><i class="fa-solid fa-star-of-life"></i></sup></label>
                       <input wire:model.defer="subject" id="subject" type="text" class="@error('subject') border-red-500 @enderror">
                       @error('subject') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                 </div>
                 <div class="col-md-12">
                    <div class="bd-contact-input mb-20">
                       <label for="textarea">Comments <sup><i class="fa-solid fa-star-of-life"></i></sup></label>
                       <textarea wire:model.defer="comments" id="textarea" class="@error('comments') border-red-500 @enderror"></textarea>
                       @error('comments') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                 </div>
                 <div class="col-md-12">
                    <div class="bd-contact-agree-btn">
                       <button type="submit" class="bd-btn">
                          <span class="bd-btn-inner">
                             <span class="bd-btn-normal">Send now</span>
                             <span class="bd-btn-hover">Send now</span>
                          </span>
                       </button>
                    </div>
                 </div>
              </div>
           </form>
        </div>
     </div>
</div>

