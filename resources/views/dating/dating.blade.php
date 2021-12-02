<?php
use Carbon\Carbon; 
use App\Like;
?>
@extends('layouts.dating_layout')
@section('content')
{{--START LOGGED IN PROFILE--}}
<header class="bg-info text-white">
    <div class="container text-center">
        @if(!empty(Auth::user()->image))
            {{--USER-HAS-IMAGE--}}
            <img class="img-fluid img-thumbnail" height="300px" width="200px" src="{{ asset('image/profile_pictures/'.Auth::user()->image) }} " alt="" />
        @else
            {{--USER-HAS-NO-IMAGE--}}
            <img class="rounded mx-auto d-block" src="https://dummyimage.com/300x200/1ec9bb/ffffff.png&text=NO+IMAGE" alt=""/>
        @endif
        <h1>{{ Auth::user()->name }}</h1>
        <p class="lead">( {{ Carbon::parse(Auth::user()->date_of_birth )->age}} y/o - {{ ucfirst(substr(Auth::user()->gender,0,1)) }} )</p>
        <p class="lead">{{ Auth::user()->location }}</p>
        <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
    </div>
</header>
{{--END LOGGED IN USER PROFILE--}}
{{--START USER AROUND YOU SECTION--}}
<section id="userAround">
    <hr><h1 class="page-section-heading text-center text-uppercase text-secondary mb-0">Users Around You ≈ 5km</h1><hr>
    <div class="container">
        <div class="card-deck">
            <div class="row">
                {{--START USER LIST::[AROUND 5KM]--}}
                @foreach ($users as $user) 
                        <div class="col-lg-4 col-md-4 col-sm-6 " style=" margin-right: auto;">
                            <div class="card custom-card"style="width: 22rem;margin-bottom: 20px;">
                                @if(empty($user['image']))
                                    {{--USER-HAS-NO-IMAGE--}}
                                    <img src="https://dummyimage.com/300x200/1ec9bb/ffffff.png&text=NO+IMAGE" height="280px" width="100px"  class="card-img-top custom-img" alt="">
                                @else
                                    {{--USER-HAS-IMAGE--}}
                                    <img src="{{ asset('image/profile_pictures/'.$user['image']) }}" height="280px" width="100px" class="card-img-top custom-img" alt="">
                                @endif
                                {{--START USER DETAILS--}}
                                <div class="card-body">
                                    <h5 class="card-title">{{$user['name']}}</h5>
                                    <p class="card-text"> <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp; Age : {{$user['age']}} y/o</p>
                                    <p class="card-text"> <i class="fa fa-transgender" aria-hidden="true"></i>&nbsp; Gender : {{ucfirst($user['gender'])}}</p>
                                    <p class="card-text"> <i class="fa fa-location-arrow" aria-hidden="true"></i> &nbsp; Location : {{$user['location']}}</p>
                                    <p class="card-text"> <i class="fa fa-road" aria-hidden="true"></i>&nbsp; Distance from you : ≈ {{$user['distance']}} km</p>
                                </div>
                                {{--END USER DETAILS--}}
                                <?php 
                                    $status = 0;  $status = Like::where(['user_id'=>Auth::user()->id,'target_user_id'=>$user['id'],'like_status'=>1])->count(); 
                                ?>
                                <div class="card-footer" style="align-items: center;">
                                @if ($status==0)
                                    {{--USER CAN EXECUTE LIKE:::[IF USER NOT LIKED THE TARGET USER YET]--}}
                                    <a title="Like" class="updateLikeStatus btn btn-info" id="target-{{$user['id']}}" target_user_name="{{$user['name']}}" target_user_id="{{$user['id']}}"href="javascript:void(0)">Like</a>
                                @else
                                    {{--USER CAN EXECUTE DISLIKE:::[IF USER LIKED THE TARGET USER ALREADY]--}}
                                    <a title="Dislike" class="updateLikeStatus btn btn-info" id="target-{{$user['id']}}" target_user_name="{{$user['name']}}" target_user_id="{{$user['id']}}"href="javascript:void(0)">Dislike</a>
                                @endif
                                </div>
                            </div>
                        </div>
                @endforeach
                {{--END USER LIST::[AROUND 5KM]--}}
                </div>
            </div>
        </div>
    </div>
</section> 
{{--END USER AROUND YOU SECTION--}}
@endsection