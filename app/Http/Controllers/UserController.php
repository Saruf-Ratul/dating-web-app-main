<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Validator;
use Image;
Use Alert;
use App\Like;

class UserController extends Controller
{
    /*--------------------------------------------------------------------------
    | USER REGISTRATION/SIGNUP FUNCTION
    |--------------------------------------------------------------------------*/
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email',
                'gender' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
            }
            /*--------------------------------------------------------------------------
            | Duplicate Email Check
            |--------------------------------------------------------------------------*/
            $emailCount = User::where('email',$data['email'])->count();
            if($emailCount>0){
                Alert::warning('Warning', 'Account with this email already exists!');
                return back();
            }
            /*--------------------------------------------------------------------------
            | Store User's Data
            |--------------------------------------------------------------------------*/
            $geoipInfo = geoip()->getLocation($data['ip']); //Laravel Geoip package by Torann
            $location = $geoipInfo->city . ',' . $geoipInfo->state_name . ',' . $geoipInfo->country;    //Generate Complete Location
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->date_of_birth = $data['dob'];
            $user->gender = $data['gender'];
            $user->location = $location;
            $user->latitude = $geoipInfo->lat;      //Automatically Store User's Latitude & Longitude based on IP Address
            $user->longitude = $geoipInfo->lon;
            $user->save();
            // echo "<pre>"; print_r($data);die;
            alert()->success('Registered successfully','Please login!');
            return redirect('/login');
        }
        return view('user.register');
    }
    /*--------------------------------------------------------------------------
    | USER LOGIN FUNCTION
    |--------------------------------------------------------------------------*/
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>" ; print_r($data) ; die;
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                Session::put('datingSignInSession', $data['email']);
                $msg = Auth::user()->name;
                if(empty(Auth::user()->image)){
                    //FORCE USER TO UPLOAD IMAGE
                    Alert::warning('Warning', 'Please Upload Profile Photo');
                    return redirect('/dating/image-upload');
                }else{
                    return redirect('/dating')->with('toast_success','Welcome back,'.$msg);
                }
            } else {
                return back()->with('toast_error', 'The email or password is incorrect, please try again!');
            }
        }
        return view('user.login');
    }
    /*--------------------------------------------------------------------------
    | USER PROFILE PICTURE UPLOAD FUNCTION
    |--------------------------------------------------------------------------*/
    public function imageUp(Request $request)
    {
        if($request->isMethod('post')){
            if ($request->hasFile('image')) {
                $image_temp = $request->file('image');
                if ($image_temp->isValid()) {
                    $image_name = $image_temp->getClientOriginalName();
                    $imageName = rand(111, 99999) . '-' . $image_name;
                    $image_path = 'image/profile_pictures/' . $imageName;
                    Image::make($image_temp)->save($image_path);
                    User::where('email', Auth::user()->email)->update(['image' => $imageName]);
                    return redirect('/dating');
                }
            }
        }
        return view('user.image_upload');
    }
    /*--------------------------------------------------------------------------
    | MAIN DATING PAGE FUNCTION
    |--------------------------------------------------------------------------*/
    public function dating()
    {
        $current_user_latitude = Auth::user()->latitude;    //get current logged in user's lat & long
        $current_user_longitude = Auth::user()->longitude;
         /*--------------------------------------------------------------------------
        | Haversine formula -A function To Calculate circle distance on a sphere
        |--------------------------------------------------------------------------*/
        function distance($lat1, $lon1, $lat2, $lon2){
            if (($lat1 == $lat2) && ($lon1 == $lon2)){
              return 0;
            } else {
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $km = $miles* 1.609344;
                return round($km,2);
              }
        }

        // $userlists = User::inRandomOrder()->get()->except(Auth::id())->toArray();
        $userlists = User::orderBy('id', 'DESC')->get()->except(Auth::id())->toArray();
        $users = [];
        /*--------------------------------------------------------------------------
        | Store User around 5 km in Empty Array
        |--------------------------------------------------------------------------*/
        foreach($userlists as $user){
           $distance = distance($current_user_latitude, $current_user_longitude, $user['latitude'], $user['longitude']);
           if($distance<=5) {
                $users[] = [
                                'id'=>$user['id'],
                                'name'=>$user['name'],
                                'image'=>$user['image'],
                                'gender'=>$user['gender'],
                                'location'=>$user['location'],
                                'age'=>Carbon::parse($user['date_of_birth'])->age,
                                'distance'=>$distance
                            ];
                } else{
                    }
        }
        //  echo "<pre>"; print_r($users);die;
        return view('dating.dating')->with(compact('users'));
    }
    /*--------------------------------------------------------------------------
    | USER LOGOUT FUNCTION
    |--------------------------------------------------------------------------*/
    public function logout()
    {
        Auth::logout();
        Session::forget('datingSignInSession');
        return redirect('/');
    }
    /*--------------------------------------------------------------------------
    | USER LIKE, DISLIKE, MUTUTAL FUCNTION
    |--------------------------------------------------------------------------*/
    public function updateLikeStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            if($data['like_status']=="Like"){ 
                $status = 1;
            }
            else{
                $status = 0;
            }
            /*--------------------------------------------------------------------------
            | CHECK TARGET USER IS EXIST IN THE DB OR NOT 
            |--------------------------------------------------------------------------*/
            if(Like::where(['user_id'=>$data['user_id'],'target_user_id'=>$data['target_user_id']])->exists())
            {   //IF EXIST ,THEN UPDATE THE ACTION IN DB
                Like::where(['user_id'=>$data['user_id'] ,'target_user_id'=>$data['target_user_id']])->update(['like_status'=>$status]);
            }else{
                //IF NOT ,THEN CREATE THE ACTION IN DB
                $like = new Like;
                $like->user_id = $data['user_id'];
                $like->target_user_id =$data['target_user_id'];
                $like->like_status = 1;
                $like->save();
            }
            /*--------------------------------------------------------------------------
            | MUTUTAL STATUS CHECK
            |--------------------------------------------------------------------------*/
            $count = Like::where(['user_id'=>$data['target_user_id'] ,'target_user_id'=>$data['user_id'] ,'like_status'=>1])->count();
            if($count == 1){
                $mututal = 1;
            }else{
                $mututal = 0;
            }
            return response()->json(['like_status'=>$status,'target_user_id'=>$data['target_user_id'] ,'mututal'=>$mututal]);
        }
    }
    
}
