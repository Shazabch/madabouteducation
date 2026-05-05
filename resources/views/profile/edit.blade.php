@extends($layout)
@section($section)
<div class="container my-4 p-4 rounded-3" style="background-color: #F8F9FA;">
    <div class="">
        <div class="">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="mt-5">
            @include('profile.partials.update-password-form')
        </div>

        <div class="mt-3">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
