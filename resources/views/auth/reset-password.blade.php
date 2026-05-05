@extends('layouts.master')
@section('meta_title','MAE-Reset Password') @section('meta_description','description')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-10 col-sm-8 col-lg-4 col-xl-3">
            <div class=" border  my-5 p-4 rounded-2">
                <h3 class="text_orange">Reset Password</h3>
                
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="form-group">
                        <x-input-label for="email" :value="__('Email')" />
                        <input id="email" class="form-control mt-1" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
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

                    <div class="mt-4">
                        <x-primary-button class="w-100">
                            {{ __('Reset Password') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
