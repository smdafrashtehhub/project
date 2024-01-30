<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\LoginRequest;
use App\Http\Requests\api\RegisterRequest;
use App\Mail\DemoMail;
use App\Models\User;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{


    //------------------------------------------------- filter --------------------------------------------
    public function filter(Request $request)
    {
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
            $users = $users->whereBetween('age', [$request->filterAgeMin,$request->filterAgeMax]);
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
        $arr=[];
        if($request->filterOrderStatus == 'true' || $request->filterOrderStatus == 'false')
        {
            if($request->filterOrderStatus ==  'true')
            {
                foreach ($users as $user)
                    if($user->orders->count())
                        $arr[] = $user->id;
            }
            else
            {
                foreach ($users as $user)
                    if(!$user->orders->count())
                        $arr[]=$user->id;
            }
            $users=User::find($arr);
        }
        if($request->filterRole == 'admin' || $request->filterRole == 'seller' || $request->filterRole == 'customer')
        {
            if($request->filterRole == 'admin' )
                $users=$users->where('role','admin');
            if($request->filterRole == 'seller' )
                $users=$users->where('role','seller');
            if($request->filterRole == 'customer' )
                $users=$users->where('role','customer');
        }
        if ($users->count())
        return response()->json([
           'status'=>true,
           'Message'=>$users,
        ]);
        return response()->json([
           'status'=>false,
           'Message'=>'کاربر درخواستی شما یافت نشد',
        ]);
    }

    //-------------------------------------- Awaiting_confirmation --------------------------------------------
    public function Awaiting_confirmation()
    {
        try {
            $user=User::where(['status'=>'Awaiting confirmation'])->get();
            if($user->count())
            return response()->json([
                'status' => true,
                'message' => $user
            ]);
            else
                return response()->json([
                    'status' => true,
                    'message' => 'کاربری موجود نیست'
                ]);
        } catch (\throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }

    }

    //------------------------------------------------- store --------------------------------------------
    public function store()
    {
        dd(\auth('api')->user()->permissions);
//        Permission::create(['name'=>'show_user']);
//        Role::create(['name' => 'customer']);

//        auth()->guard('api')->user()->assignRole('customer');
//        auth()->guard('api')->user()->givePermissionTo('show_user');
    }

    //------------------------------------------------- login --------------------------------------------
    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::guard('web')->attempt($request->only('email', 'password'))) {
                return response()->json([
                    'status' => false,
                    'message' => 'email and password are not match',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            $token = $user->createToken('API TOKEN')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => ' کاربر ' . \auth()->user()->first_name . ' با موفقیت وارد شد',
                'token' => $token,
            ], 200);
        } catch (\throwable $th) {
            response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);

        }

    }

    //------------------------------------------------- register --------------------------------------------
    public function register(RegisterRequest $request)
    {
        try {
            if ($request->role == 'seller') {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'email' => $request->email,
                    'role' => $request->role,
                    'status' => 'Awaiting confirmation',
                    'password' => Hash::make($request->password),
                ]);
                $user->assignRole('seller');
            } else {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'email' => $request->email,
                    'role' => $request->role,
                    'password' => Hash::make($request->password),
                ]);
                if ($request->role == 'admin')
                    $user->assignRole('admin');
                if ($request->role == 'customer')
                    $user->assignRole('customer');
            }
//            $user->givePermissionTo
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
            ], 200);
        } catch (\throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    //------------------------------------------------- logout --------------------------------------------
    public function logout()
    {

        try {
//            dd(auth()->guard('api')->user()->first_name);
            auth()->guard('api')->user()->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => ' کاربر' . auth('api')->user()->first_name . ' ' . auth('api')->user()->last_name . ' با موفقیت خارج شد'
            ]);
        } catch (\throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }

    }

    //------------------------------------------------- index --------------------------------------------
    public function index()
    {
        try {
            return User::all();
        } catch (\throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    //------------------------------------------------- destroy --------------------------------------------
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => ' باموفقیت حذف شد' . $user->first_name . ' ' . $user->last_name . 'کاربر '
            ]);
        } catch (\throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    //------------------------------------------------- update --------------------------------------------
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
//            dd($user);
            if ($user->id == auth('api')->user()->id || auth('api')->user()->role == 'admin')
            {$user->update([
                'user_name' => $request->user_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'age' => $request->age,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
                'role' => $request->role,
                'status' => $request->status,
            ]);
            return response()->json([
                'status' => true,
                'message' => ' باموفقیت ویرایش شد' . $user->first_name . ' ' . $user->last_name . 'کاربر '
            ]);
            }
            return response()->json([
                'status' => false,
                'message' => ' ویرایش کاربر برای شما در دسترس نیست ',
            ]);
        } catch (\throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    //------------------------------------------------- show --------------------------------------------
    public function show(User $user)
    {
        try {
                if ($user->id == \auth('api')->user()->id || auth('api')->user()->hasRole('admin'))
                    return response()->json([
                        'user' => $user,
                        'status' => true,
                        'message' => ' نشان داده شد' . $user->first_name . ' ' . $user->last_name . 'کاربر '
                    ]);
            return response()->json([
                'status' => false,
                'message' => 'شما دسترسی به این کاربر ندارید',
            ]);

        } catch (\throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    //------------------------------------------------- confirmation --------------------------------------------
    public function confirmed(Request $request,User $user)
    {
        if($user->role == 'seller' && $user->status== 'Awaiting confirmation')
        {
            if($request->confirmed == 'confirmation')
            {
                $user->update([
                    'status'=> 'confirmation',
                ]);
//                dd('lll');
                $user->syncRoles('seller');
                return response()->json([
                    'status'=>true,
                    'message'=>'نقش کاربر به فروشنده تغییر یافت'
                ]);
            }
            if($request->confirmed == 'reject')
            {
                $user->update([
                    'status'=> 'reject',
                ]);
                return response()->json([
                    'status'=>true,
                    'message'=>'نقش کاربر تغییر پیدا نکرد'
                ]);
            }
        }
        return response()->json([
            'status'=>false,
            'message'=>'نقش کاربر را نمیتوان عوض کرد'
        ]);



    }

}
