<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //--------------------------------------- Logout ------------------------------------------

    public function UserLogout()
    {
        $user = Auth::user();
//        dd($user->id);
//        $user->tokens()->where('tokenable_id', $user->id)->delete();

        $user->tokens()->delete();
//        $user->tokens()->delete();
        auth()->logout();
        return redirect()->route('login');
    }

    //--------------------------------------- Register ------------------------------------------

    public function UserRegister(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'first_name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',
                ]
            );
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }
            $user = User::create([
                'first_name' => $request->first_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            session()->put('token', $user->createToken("API TOKEN")->plainTextToken);
            return redirect()->route('workplace');

//            dd(session()->has('token'));
//            return response()->json([
//                'status'=>true,
//                'message'=>'User Created Successfully',
//                'token'=>$token,
//            ],200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

//--------------------------------------- login ------------------------------------------

    public function UserLogin(Request $request)
    {
        try{
            $validateUser=Validator::make($request->all(),
                [
                    'email'=>'required|email',
                    'password'=>'required',
                ]
            );
            if($validateUser->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>'validation error',
                    'errors'=>$validateUser->errors(),
                ],401);
            }
            if(!Auth::attempt($request->only(['email','password']))){
                return response()->json([
                    'status'=>false,
                    'message'=>'Email & Password does not match with our record.',
                ],401);
            }
            $user=User::where('email',$request->email)->first();
            $user->createToken('API TOKEN')->plainTextToken;
//            return response()->json([
//                'status'=>true,
//                'message'=>'User Logged In Succesfully',
//                'token'=>$user->createToken('API TOKEN')->plainTextToken,
//            ],200);
        } catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage(),
            ],500);
        }
        return redirect()->route('workplace');
    }


    public function create()
    {
        return view('users.addUser');
    }
    public function index()
    {
        $users = User::where('status','enable')->get();
        return view('users.usersData', ['users' => $users]);
    }
    public function store(UserRequest $request)
    {
//        $request->validate([
//            'user_name'=>'required',
//            'first_name'=>'required',
//            'last_name'=>'required',
//            'age'=>'required',
//            'gender'=>'required',
//            'email'=>'required|email|unique:users',
//            'phone_number'=>'required',
//            'address'=>'required',
//            'postal_code'=>'required',
//            'country'=>'required',
//            'province'=>'required',
//            'city'=>'required',
//            'password'=>'required',
//
//        ]);

        $imagename=$request->image->getClientOriginalName();
        $request->image->move(public_path('image/users'),$imagename);

        User::create([
            'user_name'=>$request->user_name,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'age'=>$request->age,
            'gender'=>$request->gender,
            'email'=>$request->email,
            'phone_number'=>$request->phone_number,
            'password'=>md5($request->password),
            'address'=>$request->address,
            'postal_code'=>$request->postal_code,
            'country'=>$request->country,
            'province'=>$request->province,
            'city'=>$request->city,
            'created_at'=>date('Y-m-d H:i:s'),
            'image'=>$imagename,

        ]);
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user=User::where('id',$id)->first();
        return view('users.editUser',['user'=>$user]);
    }

    public function destroy($id)
    {
        User::where('id',$id)->update(['status'=>'disable']);
        return back();
    }

    public function update(UserUpdateRequest $request,$id)
    {
        User::where('id',$id)->update([
            'user_name'=>$request->user_name,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'age'=>$request->age,
            'gender'=>$request->gender,
            'email'=>$request->email,
            'phone_number'=>$request->phone_number,
            'address'=>$request->address,
            'postal_code'=>$request->postal_code,
            'country'=>$request->country,
            'province'=>$request->province,
            'city'=>$request->city,
            'updated_at'=>date('Y-m-d H:i:s'),

        ]);
        return redirect()->route('users.index');
    }
}
