@extends('layouts.master')
@section('meta_title','MAE-Register') @section('meta_description','description')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-10 col-sm-8 col-lg-4 col-xl-3">
            <div class=" border  my-5 p-4 rounded-2">

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="intended_url" value="{{ $intended_url ?? '' }}">

                    <div>
                        <h3 class="text_orange text-center mb-2">Sign Up</h3>
                    </div>
            
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
            
                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
            
                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
            
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
            
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
            
                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
            
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
            
                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a> <br>
            
                        <button class="btn btn-orange ml-4 w-100 mt-3" type="submit">
                            {{ __('Register') }}
                        </button>
                        
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</div>
@endsection
