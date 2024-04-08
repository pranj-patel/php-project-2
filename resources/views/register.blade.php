@extends('layout.layout')
@section('register_status', 'active')
@section('title', 'Register')

@section('content')

    <div class="container content-width">
     
        <div class="login-container">

            <form class="login-form" action="{{ Asset('register') }}" method="POST">
                @csrf
                <h2>Register</h2>
        
                <div class="form-group">
                    <label for="username">Username <small class="text-danger">*</small></label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" autofocus>
                    @error('username') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
        
                <div class="form-group">
                    <label for="email">Email Address <small class="text-danger">*</small></label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}">
                    @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
        
                <div class="form-group">
                    <label for="password">Password <small class="text-danger">*</small></label>
                    <input type="password" id="password" name="password">
                    @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
        
                <div class="form-group">
                    <label for="password_confirmation">Confirm password <small class="text-danger">*</small></label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
                
                <div class="form-group">
                    <label for="user_type">User Type <small class="text-danger">*</small></label>
                    <select id="user_type" name="user_type">
                        <option value="">Please Select User Type</option>
                        <option value="student">Student</option>
                        <option value="inp">Industry Partner</option>
                    </select>
                    @error('user_type') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
                <br>
                <p>Already have an account? <a href="{{ Asset('login') }}">Login Here</a></p>
                <br>
                <button type="submit">Register</button>
            </form>

        </div>

    </div>


@endsection
