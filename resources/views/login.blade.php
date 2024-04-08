@extends('layout.layout')
@section('login_status', 'active')
@section('title', 'Login')

@section('content')

    <div class="container content-width">
     
        <div class="login-container">

            <form class="login-form" action="{{ Asset('login') }}" method="POST">
                @csrf
                <h2>Login</h2>
        
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

                <br>
                <p>Dont have an account? <a href="{{ Asset('register') }}">Register Here</a></p>
                <br>
        
                <button type="submit">Login</button>
            </form>

        </div>

    </div>


@endsection
