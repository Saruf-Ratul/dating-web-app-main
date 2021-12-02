@extends('layouts.login_signup_master_layout')
@section('content')

    <div class="login-form">
        <form action="{{ route('image-up') }}" id="image" name="image" method="post" enctype="multipart/form-data">@csrf
            <div class="avatar"><i class="material-icons">&#xE7FF;</i></div>
            <h4 class="modal-title">Upload Your Profile Image</h4>
            <div class="form-group">
                <input type="file" class="form-control" name="image" id="image" placeholder=""
                    aria-describedby="fileHelpId">
            </div>

            <div class="form-group small clearfix">
                <a href="{{ route('dating') }}" class="forgot-link">Skip,Upload Later!</a>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Upload</button>
        </form>
    </div>
    </form>

@endsection
