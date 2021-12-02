@extends('layouts.login_signup_master_layout')
@section('content')
    <div class="login-form">
        <form action="{{ route('login') }}" method="post">@csrf
            <div class="avatar"><i class="material-icons">&#xE7FF;</i></div>
            <h4 class="modal-title">Login to Your Account</h4>
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                    required="required">
            </div>
            <div class="form-group small clearfix">
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
        </form>
        <div class="text-center small">Don't have an account? <a href="{{ route('register') }}">Sign up</a></div>
    </div>
@endsection
