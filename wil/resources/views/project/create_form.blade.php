<div class="content-container">
    <h2 class="heading">Create New Project</h2>

    @if ($user->approved == 0)
    <p class="alert alert-danger">Note! You need to be approved by teacher to create projects.</p>
    @endif
    
    <form method="POST" action="{{ Asset('add-project') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Project Title <small class="text-danger">*</small></label>
            <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control" >
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Project Description <small class="text-danger">*</small></label>
            <textarea name="description" id="description" class="form-control" >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="num_students">Number of Students Needed (3-6) <small class="text-danger">*</small></label>
            <input type="number" name="num_students" value="{{ old('num_students') }}" id="num_students" class="form-control" >
            @error('num_students')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        
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
            <label for="files">Project Files (Images/Pdfs)</label>
            <input type="file" name="files[]" id="files" multiple  @error('files') is-invalid @enderror> 

            {{-- show file validation errors  --}}
            @if($errors->has('files.*'))
                    @foreach($errors->get('files.*') as $fileError)
                        <p class="text-danger">{{ $fileError[0] }}</p>
                    @endforeach
            @endif

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Project</button>
        </div>
    </form>
</div>