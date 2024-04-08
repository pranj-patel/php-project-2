@extends('layout.layout')
@section('home_status', 'active')
@section('title', 'Project Detail')
@section('content')
@php
$user = \Auth::user();
@endphp
    <div class="container content-width">
     

        <div class="container content-width">
            <div class="content-container">
                <h4 class="heading">Project Detail</h4>
        
                <div class="project-details">
                    <h2>{{ $project->title }}</h2>
                    <hr><br>
                    <p>Inp Name: <b> {{ $project->inp_username }}</b></p>
                    <p>InP Email: <b> {{ $project->inp_email }}</b></p>
                    <p>Description: <b> {{ $project->description }}</b></p>
                    <p>Team Size: <b> {{ $project->num_students }}</b></p>
                    <p>Trimester: <b> {{ $project->trimester }}</b></p>
                    <p>Year: <b> {{ $project->year }}</b></p>
        
                    @if ($user->user_type === 'inp' && $user->id === $project->inp_id)
                      <div class="project_action">
                        <a href="{{ Asset('project-edit').'/'.$project->id }}" class="">Edit Project</a> | 
                        <a href="{{ Asset('project-delete').'/'.$project->id }}" style="color:red">Delete Project</a>
                      </div>
                    @endif
                    
                </div>
            </div>


            {{-- show project files if any  --}}
            @if($project_files->count() > 0)
            <div class="content-container">

                <h4 class="heading">Project Files</h4>

                <div class="project-files">
                @foreach ($project_files as $file)
                    @if($file->type != 'pdf')
                        <a class="project-file" href="{{ Asset('files').'/'.$file->name }}" target="_blank">
                            <img src="{{ Asset('files').'/'.$file->name }}" alt="{{ $file->name }}">
                        </a>
                    @else
                        <div class="heading">
                            <a class="project-pdf" href="{{ Asset('files').'/'.$file->name }}" target="_blank"><b>{{ $file->name }}</b></a>
                        </div>
                    @endif
                @endforeach
                </div>

                  </div>
                @endif




                {{-- apply to project form   --}}
                @if($user->user_type == 'student')
                    <div class="content-container">
                        <h4 class="heading">Apply to work on this project</h4>
                        <br>

                        {{-- if student profile exists then show the application form  --}}
                        @if($student_profile)
                            @include('project.application_form')
                        @else
                            {{-- else show the create profile form  --}}
                        <h4 class=" text-danger">Please complete your profile to apply on any project.</h4><br>
                        @include('user.student_profile_form')

                        @endif

                    </div>
                @endif
 

                

                    {{-- show project files if any  --}}
                    @if($project_applications->count() > 0)
                    <div class="content-container">

                        <h4 class="heading">Students Applications for this Project</h4>

                        <div class="projet-applications">
                            @foreach ($project_applications as $application)
                                <div class="application">
                                    <a href="{{ Asset('student-profile').'/'.$application->user_id }}" class="username">{{ $application->username }}</a>
                                    <p class="justification">{{ $application->justification }}</p>
                                </div>
                            @endforeach
                        </div>

                        </div>
                    @endif

                    {{-- show project assignments if any  --}}
                    @if($project_assignments->count() > 0)
                    <div class="content-container">

                        <h4 class="heading">Students Assigned to this Project</h4>

                        <div class="projet-applications">
                            @foreach ($project_assignments as $assign)
                                <div class="application">
                                    <a href="{{ Asset('student-profile').'/'.$assign->user_id }}" class="username">{{ $assign->username }}</a>
                                    <p class="justification">{{ date('d-M-Y h:i a',strtotime($assign->created_at)) }}</p>
                                </div>
                            @endforeach
                        </div>

                        </div>
                    @endif

        </div>

    </div>


    @endsection
