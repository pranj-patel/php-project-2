<form action="{{ Asset('project-application') }}" method="POST">
    @csrf
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <div class="form-group">
        <label for="justification">Justification <small class="text-danger">*</small></label>
        <textarea name="justification" id="justification" class="form-control" placeholder="Why you want to work on this project">{{ old('justification') }}</textarea>
        @error('justification')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>


            
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit Application</button>
    </div>
</form>