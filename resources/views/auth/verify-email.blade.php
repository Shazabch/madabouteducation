@extends('layouts.master')
@section('meta_title','MAE-Verify Email') @section('meta_description','description')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-10 col-sm-8 col-lg-6 col-xl-6">
            <div class="border my-5 p-4 rounded-2">
                <h3 class="text_orange">Verify Email</h3>
                
                <div class="mb-4">
                    <small>
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </small>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="mt-4 d-flex align-items-center justify-content-between flex-wrap">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <x-primary-button>
                                {{ __('Resend Verification Email') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <button type="submit" class="logout-button">
                        {{ __('Log Out') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
