<?php

namespace App\Http\Controllers;

use Response;
use Carbon\Carbon;
use App\Models\User;
use Tests\Unit\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use App\Http\Requests\AddAvatarRequest;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserPasswordUpdateRequest;


class UserController extends Controller
{
    // function for register the user

    public function register(UserStoreRequest $request){


        if(Auth::check()){
            $is_auth_check = auth()->check();
            return response()->json([
                "is_auth_checked" => $is_auth_check
            ]);
            // if((Auth::user()->is_super_admin == 1) ){
            //     $request['is_admin']->required;
            //     $validated = $request->validated();
            //     $validated['password'] = Hash::make($validated['password']);
            //     $user = User::create($validated);
            //     return new UserResource($user);
            // }else if(Auth::user()->is_admin == 1){
            //     $request['is_admin'] = 0;
            //     $validated = $request->validated();
            //     $validated['password'] = Hash::make($validated['password']);
            //     $user = User::create($validated);
            //     return new UserResource($user);
            // }else{
            //     abort (403 , "You cannot permission to create a user!");
            // }

        }else{
            $is_auth_check = auth()->check();
            return response()->json([
                "is_auth_checked" => $is_auth_check
            ]);

        }
    }

    // function for add the avatar
    public function addAvatar(AddAvatarRequest $addAvatarRequest , User $user){
        if(Auth::user()->is_super_admin == 1){
            $filName = time().$addAvatarRequest->file('avatar')->getClientOriginalName();
            $path = $addAvatarRequest->file('avatar')->storeAs('avatars' , $filName , 'public');
            $requestData ["avatar"] = '/storage/'. $path;
            $validated = $addAvatarRequest->validated();
            $validated['avatar'] = $requestData["avatar"];
            $user -> update($validated);
            return new UserResource($user);
        }else if (Auth::user()->is_admin == 1){
            $filName = time().$addAvatarRequest->file('avatar')->getClientOriginalName();
            $path = $addAvatarRequest->file('avatar')->storeAs('avatars' , $filName , 'public');
            $requestData ["avatar"] = '/storage/'. $path;
            $validated = $addAvatarRequest->validated();
            $validated['avatar'] = $requestData["avatar"];
            $user -> update($validated);
            return new UserResource($user);
        }else{
            if(Auth::user()->id == $user->id){
                $filName = time().$addAvatarRequest->file('avatar')->getClientOriginalName();
                $path = $addAvatarRequest->file('avatar')->storeAs('avatars' , $filName , 'public');
                $requestData ["avatar"] = '/storage/'. $path;
                $validated = $addAvatarRequest->validated();
                $validated['avatar'] = $requestData["avatar"];
                $user -> update($validated);
                return new UserResource($user);
            }else{
                abort(403 , "You can't set a profile to other users!");
            }
        }
    }

    // function fore login the user
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|email' ,
            'password' => 'required'
        ]);

        if(! Auth::attempt($validated)){
            return response()->json([
                'message' => 'login information is incorrect!'
            ] , 401)  ;
        }
            $user = User::where('email', $validated['email'])->first();
            $user->last_entry = Carbon::now()->toDateString();
            $user->save();
            return response()->json([
                'access_token' => $user->createToken('api_token')->plainTextToken ,
                'type_token' => 'Bearer'
            ]) ;

    }



    //show the user itself
    public function show(User $user){
            return new UserResource( $user );
    }


    //update the user data
    public function update(UserUpdateRequest $request, User $user){
        if(!empty($request['password'])){
            abort(403 , "You can't change the password from here!");
        }else{

        }
    }

    //show the profile
    public function profile(){
            $user = Auth::user();
            if((bool)$user == true){
                return new UserResource( $user );
            }
            abort(403 , "no founding the user");
    }

    public function changePassword(UserPasswordUpdateRequest $request){
            $validated = $request->validated();
            $isCheck =(bool) $validated['password'] == Auth::user()->password;
            if($isCheck){
                $validated['password'] = Hash::make($validated['password']);
                $validated['password'] = $validated['new_password'];
                $user = User::where('email' , Auth::user()->email)->first();
                $user->update($validated);
                return new UserResource( $user );
            }




    }

    public function index(){
        $user = Auth::user();

        if(($user->is_super_admin == 1) || ($user->is_admin == 1)){
            return new UserCollection(User::paginate());
        }else{
            abort(403 , 'You cannot get access to this page');
        }

        // $user = new UserTest();
    }





}
