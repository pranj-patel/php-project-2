{{-- this same form works for updating profile  --}}
@php
$user = \Auth::user();
@endphp

<form action="{{ Asset('student-profile-update') }}" method="POST">
@csrf
<div class="form-group">
    <label for="gpa">Grade Point Average (GPA) <small class="text-danger">*</small></label>
    <input type="number" name="gpa" id="gpa" class="form-control" value="{{ isset($profile->id) ? $profile->gpa : old('gpa') }}" placeholder="Enter your GPA" {{ $user->user_type != 'student' ? 'disabled' : '' }}>
    @error('gpa')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="roles">Roles <small class="text-danger">*</small></label><br>

    <label for="software_developer">
        <input type="checkbox" name="roles[]" value="software_developer" id="software_developer" {{ isset($profile->id) && strpos($profile->roles, 'software_developer') !== false ? 'checked' : '' }} {{ $user->user_type != 'student' ? 'disabled' : '' }}>
        Software Developer
    </label>

    <label for="project_manager">
        <input type="checkbox" name="roles[]" value="project_manager" id="project_manager" {{ isset($profile->id) && strpos($profile->roles, 'project_manager') !== false ? 'checked' : '' }} {{ $user->user_type != 'student' ? 'disabled' : '' }}>
        Project Manager
    </label>

    <label for="business_analyst">
        <input type="checkbox" name="roles[]" value="business_analyst" id="business_analyst" {{ isset($profile->id) && strpos($profile->roles, 'business_analyst') !== false ? 'checked' : '' }} {{ $user->user_type != 'student' ? 'disabled' : '' }}>
        Business Analyst
    </label>

    <label for="tester">
        <input type="checkbox" name="roles[]" value="tester" id="tester" {{ isset($profile->id) && strpos($profile->roles, 'tester') !== false ? 'checked' : '' }} {{ $user->user_type != 'student' ? 'disabled' : '' }}>
        Tester
    </label>

    <label for="client_liaison">
        <input type="checkbox" name="roles[]" value="client_liaison" id="client_liaison" {{ isset($profile->id) && strpos($profile->roles, 'client_liaison') !== false ? 'checked' : '' }} {{ $user->user_type != 'student' ? 'disabled' : '' }}>
        Client Liaison
    </label>

    @error('roles')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<br>

<div class="form-group">
    <label for="skills">Skills and Expertise</label>
    <input type="text" name="skills" id="skills" class="form-control" placeholder="Your skills and expertise" value="{{ isset($profile->id) ? $profile->skills : old('skills') }}" {{ $user->user_type != 'student' ? 'disabled' : '' }}>
    @error('skills')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

@if($user->user_type == 'student')
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </div>
@else
<p class="text-danger">Only students can update their profile.</p>
@endif

</form>