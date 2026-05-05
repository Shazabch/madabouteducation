
<div class="bd-newsletter-form">
    <form wire:submit.prevent="save">
       <div class="bd-newsletter-input bd-newsletter-input-2">
          <input type="email" placeholder="your email" wire:model.defer="newsletterSubcription.email" required>
          <button type="submit" class="bd-btn" wire:loading.attr="disabled">
             <span class="bd-btn-inner">
                <span class="bd-btn-normal"><i
                      class="fa-sharp fa-solid fa-paper-plane"></i>Subscribe now</span>
                <span class="bd-btn-hover"><i
                      class="fa-sharp fa-solid fa-paper-plane"></i>Subscribe now</span>
             </span>
          </button>
       </div>
    </form>
 </div>
