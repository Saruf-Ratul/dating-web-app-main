@extends('layouts.login_signup_master_layout')
@section('content')
    <div class="login-form">
        <form action="{{ route('register') }}" method="POST">@csrf
            <div class="avatar"><i class="material-icons">&#xE7FF;</i></div>
            <h4 class="modal-title">Sign Up</h4>
            <div class="form-group">
                <input type="text" name="ip" id="ip" value="" hidden>
                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="">Date of Birth</label>
                <input type="date" class="form-control" name="dob" id="dob" placeholder="">
            </div>
            <div class="form-group">
                <label for="">Select Gender</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">Sign up</button>
        </form>
        <div class="text-center small">Already have an account? <a href="{{ route('login') }}">Login</a></div>
    </div>
    <script type="text/javascript">
        /*STORE THE IP ADDRESS USING FREE API*/
        $.getJSON("https://api.ipify.org?format=json", function(data) {
            document.getElementById("ip").value = data.ip;
        });

    </script>
@endsection
