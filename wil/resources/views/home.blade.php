@extends('layout.layout')
@section('home_status', 'active')

@section('content')
@php
$user = \Auth::user();
@endphp
<div class="container content-width">
     
    {{-- Check if the user is an Industry Partner (INP) and display the project creation form if true --}}
    @if($user->user_type == 'inp')
        @include('project.create_form')
    @endif

    <div class="content-container">
            
        {{-- Check if there are no registered Industry Partners (INPs) --}}
        @if(!isset($inps[0]))
            <p class="alert alert-danger">No Industry Partners Registered !</p>
        @else

            <h4 class="heading">All Inps</h4>

            {{-- Loop through each INP --}}
            @foreach ($inps as $inp)
                <div class="inp">
                    <a class="inp-username" href="{{ Asset('inp-detail').'/'.$inp->id }}">
                        <h3>{{ $inp->username }}</h3>
                    </a>
                    
                    {{-- Show Inp Approve button  --}}
                    {{-- Check if the user is a teacher and if the INP is approved --}}
                    @if($user->user_type == 'teacher')
                        @if($inp->approved == 0)
                            {{-- Display an "Approve" button if the INP is not approved --}}
                            <a href="{{ Asset('inp-approve').'/'.$inp->id }}" class="btn">Approve</a>
                        @else
                            {{-- Display a "Approved" button with a green background if the INP is approved --}}
                            <button class="btn" style="background-color: green">Approved</button>
                        @endif
                    @endif

                </div>
            @endforeach

            <div class="pagination">
                {{-- Display pagination links using Bootstrap 4 styles --}}
                {{$inps->links("pagination::bootstrap-4")}}
            </div>
                
        @endif  
    </div>
        
    {{-- Check if the user is a teacher and display the auto-assignment form if true --}}
    @if($user->user_type == 'teacher')
        <div class="content-container">
            <form method="POST" action="{{ Asset('auto-assignment') }}">
                @csrf
                <div class="d-flex">
                    <div class="form-group w-50">
                        <label for="year">Year <small class="text-danger">*</small></label>
                        <input type="number" name="year" value="{{ old('year') }}" id="year" class="form-control" placeholder="YYYY">
                        @error('year')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group w-50">
                        <label for="trimester">Trimester (1-3) <small class="text-danger">*</small></label>
                        <input type="number" name="trimester" value="{{ old('trimester') }}" id="trimester" class="form-control">
                        @error('trimester')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    {{-- Display the "Trigger Auto Assignment" button --}}
                    <button type="submit" class="btn btn-primary">Trigger Auto Assignment</button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
