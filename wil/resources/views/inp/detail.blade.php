@extends('layout.layout')
@section('home_status', 'active')

@section('content')
@php
$user = \Auth::user();
@endphp
    <div class="container content-width">

        <div class="content-container">
            

            <div class="d-flex" style="justify-content: space-between">
                <h3 class="text-primary">{{$inp->username}}</h3>
                <h3 class="text-primary">{{$inp->email}}</h3>
            </div>
            
        </div>
        
        <h2 class="heading">Projects offered by this InP</h2>


        <div class="content-container">
            <div class="inp-details">
        
                    @foreach ($projects as $project)
                            <a class="inp-project" href="{{ Asset('project-detail').'/'.$project->id }}">{{ $project->title }}</a>
                    @endforeach

                    @if(count($projects) == 0)
                        <p class="alert alert-danger">No Projects Found</p>
                    @endif
            </div>
        </div>

    </div>


    @endsection
