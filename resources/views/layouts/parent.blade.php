@extends('layouts.master')

@section('content')
    <div class="bg-light container-fluid mb-2 py-3">
        <ul class="nav nav-pills justify-content-end">
            <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile.edit' ? 'active' : '' }}" href="{{ route('profile.edit') }}">Profile</a>
                </li>
            <li class="nav-item">
            <a class="nav-link {{ mainMenuActiveBySegment('my-children') }}" href="{{ route('my_children') }}">My Children</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ mainMenuActiveBySegment('my-orders') }}" href="{{ route('my_orders') }}">My Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ mainMenuActiveBySegment('my-booked-programs') }}" href="{{ route('my_programs') }}">Booked Programs</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link logout-button" href="route('logout')">Log Out</a>
            </li>
        </ul>
    </div>
    @yield('sub-content')
  
@endsection