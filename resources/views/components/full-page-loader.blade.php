@once
@push('styles')
<style>

    .pg-loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 999999999999;
        background: #00bbae2f;
        -webkit-animation: fadeIn 0.6s;
         animation: fadeIn 0.6s;
      }
      .pg-loader {
         position: absolute;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
        font-size:0px;
        padding:0px;
     }

     .pg-loader span {
        vertical-align:middle;
        border-radius:100%;
        display:inline-block;
        width:20px;
        height:20px;
        margin:3px 2px;
        -webkit-animation:loader 0.8s linear infinite alternate;
        animation:loader 0.8s linear infinite alternate;
     }
     .pg-loader span:nth-child(1) {
        -webkit-animation-delay:-1s;
        animation-delay:-1s;
       background:#FF9B24;
     }

     .pg-loader span:nth-child(2) {
        -webkit-animation-delay:-0.8s;
        animation-delay:-0.8s;
       background:#FF9B24;
     }

     .pg-loader span:nth-child(3) {
        -webkit-animation-delay:-0.26666s;
        animation-delay:-0.26666s;
       background:#FF9B24;
     }

     .pg-loader span:nth-child(4) {
        -webkit-animation-delay:-0.8s;
        animation-delay:-0.8s;
       background:#FF9B24;
     }

     .pg-loader span:nth-child(5) {
        -webkit-animation-delay:-1s;
        animation-delay:-1s;
       background:#FF9B24;
     }

     @keyframes loader {
        from {transform: scale(0, 0);}
        to {transform: scale(1, 1);}
     }

     @-webkit-keyframes loader {
        from {-webkit-transform: scale(0, 0);}
        to {-webkit-transform: scale(1, 1);}
     }
</style>
@endpush
@endonce
<div {{ $attributes->merge(['class' => 'pg-loader-wrapper']) }}>
    <div class="pg-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
