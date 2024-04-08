@extends('layout.layout')
@section('profile_status', 'active')

@section('content')
@php
$user = \Auth::user();
@endphp
    <div class="container content-width">

        <div class="content-container">
            <h2 class="heading">Student Profile - <b class="text-primary">{{ $user->username }}</b></h2>
            <br>
            @include('user.student_profile_form')
        </div>

    </div>


    @endsection


