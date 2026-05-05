@extends('layouts.master')
@section('meta_title','MAE-Login') @section('meta_description','description')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-10 col-sm-8 col-lg-4 col-xl-3">
            <div class=" border  my-5 p-4 rounded-2">



            <!-- Session Status -->
            <x-auth-session-status class="" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <h3 class="text_green text-center mb-2">Log In</h3>
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4 form-group">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-underline" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="w-100 mt-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>



            </div>
        </div>
    </div>
</div>
@endsection
