@extends('layouts.master')
@section('meta_title','MAE-Password Confirmation') @section('meta_description','description')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-10 col-sm-8 col-lg-5 col-xl-4">
            <div class=" border  my-5 p-4 rounded-2">
                <h3 class="text_orange">Confirm Password</h3>
                
                <div class="mb-4 text-sm text-gray-600">
                    <small>
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </small>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-primary-button>
                            {{ __('Confirm') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
