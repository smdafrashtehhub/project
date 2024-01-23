<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use function response;


class UserController extends Controller
{
    //--------------------------------------- login github ------------------------------------------
    public function github()
    {
        return Socialite::driver('github')->redirect();
    }

    //--------------------------------------- callback github ------------------------------------------
    public function callbackgithub()
    {
//        dd(Socialite::driver('github'));
        $user = Socialite::driver('github')->user();
        if (!User::where('email', $user->email)->count()) {
            $user_github = User::create([
                'first_name' => $user->name,
                'email' => $user->email,
                'role' => 'customer',
                'password' => bcrypt(123456),

            ]);
            \auth()->login($user_github);
        } else
            \auth()->login(User::where('email', $user->email)->first());
        return redirect()->route('workplace');
    }

    //--------------------------------------- filter ------------------------------------------

    public function filter(Request $request)
    {
//        $users = QueryBuilder::for(User::class)
//            ->allowedIncludes(['orders'])
//            ->withCount('orders')
//            ->withExists('orders')
//            ->get();
////        dd($users);
//
//        $minAge = AllowedFilter::callback('filterAgeMin', function ($query, $value) {
//            $query->where('age', '>=', $value);
//        });
//        $maxAge = AllowedFilter::callback('filterAgeMax', function ($query, $value) {
//            $query->where('age', '<=', $value);
//        });
//        $orderFilter = AllowedFilter::callback('orderFilter', function ($query, $value) {
//            $query->where('age', '<=', $value);
//        });
//        $users = QueryBuilder::for(User::class)
//            ->allowedFilters([
//                $minAge,$maxAge,
//                AllowedFilter::scope('order_filter'),
//                AllowedFilter::exact('user_name')->ignore(null),
//                AllowedFilter::exact('first_name')->ignore(null),
//                AllowedFilter::exact('last_name')->ignore(null),
//                AllowedFilter::exact('age')->ignore(null),
//                AllowedFilter::exact('phone_number')->ignore(null),
//                AllowedFilter::exact('postal_code')->ignore(null),
//                AllowedFilter::exact('status')->ignore(null),
//                AllowedFilter::exact('role')->ignore(null),
//                AllowedFilter::exact('gender')->ignore(null),
//                AllowedFilter::exact('email')->ignore(null),])
//            ->get();
//        dd(QueryBuilder::for(User::class)
//            ->allowedFilters([
//                $minAge,$maxAge,
//                AllowedFilter::exact('user_name')->ignore(null),
//                AllowedFilter::exact('first_name')->ignore(null),
//                AllowedFilter::exact('last_name')->ignore(null),
//                AllowedFilter::exact('age')->ignore(null),
//                AllowedFilter::exact('phone_number')->ignore(null),
//                AllowedFilter::exact('postal_code')->ignore(null),
//                AllowedFilter::exact('status')->ignore(null),
//                AllowedFilter::exact('role')->ignore(null),
//                AllowedFilter::exact('gender')->ignore(null),
//                AllowedFilter::exact('email')->ignore(null),]));
        $users = User::all();
        if ($request->filterEmail)
            $users = $users->where('email', $request->filterEmail);
        if ($request->filterFirstName)
            $users = $users->where('first_name', $request->filterFirstName);
        if ($request->filterLastName)
            $users = $users->where('last_name', $request->filterLastName);
        if ($request->filterUserName)
            $users = $users->where('user_name', $request->filterUserName);
        if ($request->filterAgeMin && $request->filterAgeMax)
            $users = $users->whereBetween('age', [$request->filterAgeMin, $request->filterAgeMax]);
        if ($request->filterPhoneNumber)
            $users = $users->where('phone_number', $request->filterPhoneNumber);
        if ($request->filterPostalCode)
            $users = $users->where('postal_code', $request->filterPostalCode);
        if ($request->filterGender)
            $users = $users->where('gender', $request->filterGender);
        if ($request->filterStatus)
            $users = $users->where('status', $request->filterStatus);
        if ($request->filterRoles)
            $users = $users->where('role', $request->filterRoles);
        $arr = [];
        if ($request->filterOrderStatus != 'all') {
            if ($request->filterOrderStatus == 'true') {
                foreach ($users as $user)
                    if ($user->orders->count())
                        $arr[] = $user->id;
            } else {
                foreach ($users as $user)
                    if (!$user->orders->count())
                        $arr[] = $user->id;
            }
            $users = User::find($arr);
        }
        if ($request->filterRole != 'all') {
            if ($request->filterRole == 'admin')
                $users = $users->where('role', 'admin');
            if ($request->filterRole == 'seller')
                $users = $users->where('role', 'seller');
            if ($request->filterRole == 'customer')
                $users = $users->where('role', 'customer');
        }

        return view('users.usersData', compact('users'));
    }

    public function status()
    {
        $statuses = User::where('status', 'Awaiting confirmation')->get();
        return view('users.status', ['statuses' => $statuses]);
    }

    public function confirmed(User $user)
    {
        $user->update([
            'status' => 'confirmation'
        ]);
        return redirect()->route('users.status');
    }

    public function reject(User $user)
    {
        $user->update([
            'status' => 'reject'
        ]);
        return redirect()->route('users.status');
    }

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

    public function UserRegister(RegisterRequest $request)
    {
        try {
//            $validateUser = Validator::make($request->all(),
//                [
//                    'first_name' => 'required',
//                    'email' => 'required|email|unique:users,email',
//                    'password' => 'required',
//                    'role' => 'required'
//                ]
//            );
//            if ($validateUser->fails()) {
//                return response()->json([
//                    'status' => false,
//                    'message' => 'validation error',
//                    'errors' => $validateUser->errors(),
//                ], 401);
//            }
            if ($request->role == 'seller') {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'email' => $request->email,
                    'role' => $request->role,
                    'status' => 'Awaiting confirmation',
                    'password' => Hash::make($request->password),
                ]);
            } else {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'email' => $request->email,
                    'role' => $request->role,
                    'password' => Hash::make($request->password),
                ]);
            }
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

    public function UserLogin(LoginRequest $request)
    {
        try {
//            $validateUser = Validator::make($request->all(),
//                [
//                    'email' => 'required|email',
//                    'password' => 'required',
//                ]
//            );
//            if ($validateUser->fails()) {
//                return response()->json([
//                    'status' => false,
//                    'message' => 'validation error',
//                    'errors' => $validateUser->errors(),
//                ], 401);
//            }
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }
            $user = User::where('email', $request->email)->first();
            $user->createToken('API TOKEN')->plainTextToken;
//            return response()->json([
//                'status'=>true,
//                'message'=>'User Logged In Succesfully',
//                'token'=>$user->createToken('API TOKEN')->plainTextToken,
//            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
        return redirect()->route('workplace');
    }


    public function create()
    {
        return view('users.addUser');
    }

    public function index()
    {
        if (\auth()->user()->role == 'admin')
            $users = User::all();
        else
            $users[] = User::where('id', \auth()->user()->id)->first();
        return view('users.usersData', ['users' => $users]);


    }

    public function store(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'user_name' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'age' => 'required',
                'gender' => 'required',
                'email' => 'required|email|unique:users',
                'phone_number' => 'required',
                'address' => 'required',
                'postal_code' => 'required',
                'country' => 'required',
                'province' => 'required',
                'city' => 'required',
                'password' => 'required',

            ]);


        $imagename = $request->image->getClientOriginalName();
        $request->image->move(public_path('image/users'), $imagename);

        User::create([
            'user_name' => $request->user_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => md5($request->password),
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'created_at' => date('Y-m-d H:i:s'),
            'image' => $imagename,

        ]);
        return redirect()->route('users.index');


    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('users.editUser', ['user' => $user]);
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return back();
    }

    public function update(UserUpdateRequest $request, $id)
    {
        User::where('id', $id)->update([
            'user_name' => $request->user_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'updated_at' => date('Y-m-d H:i:s'),

        ]);
        return redirect()->route('users.index');
    }

}
