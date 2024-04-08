@extends('layout.layout')
@section('home_status', 'active')

@section('content')
@php
$user = \Auth::user();
@endphp
    <div class="container content-width">

        <div class="content-container">
            <h2 class="heading">Edit Project</h2>
            <form method="POST" action="{{ Asset('update-project') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <div class="form-group">
                    <label for="title">Project Title <small class="text-danger">*</small></label>
                    <input type="text" name="title" value="{{ $project->title }}" id="title" class="form-control" >
                    @error('title')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
        
                <div class="form-group">
                    <label for="description">Project Description <small class="text-danger">*</small></label>
                    <textarea name="description" id="description" class="form-control" >{{ $project->description }}</textarea>
                    @error('description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
        
                <div class="form-group">
                    <label for="num_students">Number of Students Needed (3-6) <small class="text-danger">*</small></label>
                    <input type="number" name="num_students" value="{{ $project->num_students }}" id="num_students" class="form-control" >
                    @error('num_students')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="d-flex">
                    
                <div class="form-group w-50">
                    <label for="year">Year <small class="text-danger">*</small></label>
                    <input type="number" name="year" value="{{ $project->year }}" id="year" class="form-control" placeholder="YYYY">
                    @error('year')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group w-50">
                    <label for="trimester">Trimester (1-3) <small class="text-danger">*</small></label>
                    <input type="number" name="trimester" value="{{ $project->trimester }}" id="trimester" class="form-control">
                    @error('trimester')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                </div>

                            
                <div class="form-group">
                    <label for="files">Project Files (Images/Pdfs)</label>
                    <input type="file" name="files[]" id="files" multiple>

                    {{-- show file validation errors  --}}
                    @if($errors->has('files.*'))
                            @foreach($errors->get('files.*') as $fileError)
                                <p class="text-danger">{{ $fileError[0] }}</p>
                            @endforeach
                    @endif
                </div>
        
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Project</button>
                </div>
            </form>
        </div>

    </div>


    @endsection


