@extends('layout.layout')
@section('title', 'Projects List')
@section('list_status','active')
@section('content')

<div class="container content-width">
  
    <h4 class="heading">Projects List</h4>
    <div class="content-container">


        @foreach ($projectsByYearTrimester as $year => $trimesters)
        <h3>Year: <span class="text-primary"> {{ $year }}</span></h3>
        
        <div class="project-list">
            @foreach ($trimesters as $trimester => $projects)
                <h4 class="heading">Trimester: <span class="text-primary"> {{ $trimester }}</span></h4>
                @foreach ($projects as $project)
                <a class="inp-project" href="{{ Asset('project-detail').'/'.$project->id }}">{{ $project->title }} ---- by --- <b class="text-primary">{{ $project->inp_username }}</b></a>
                @endforeach
                @endforeach
        </div>
        @endforeach


    </div>

</div>

@endsection
