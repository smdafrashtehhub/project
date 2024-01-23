<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes,HasRoles;
    protected string $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded=[];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeOrderFilter(Builder $query,$data) :Builder
    {
//        dd('hh');
         $arr=[];
//        if($data == 'true')
//        dd('kkk');
        foreach ($query->get() as $user)
        {
            if($data == 'true' && $user->orders->count())
                $arr[]=$user->where('id',$user->id);
            if($data == 'false' && !$user->orders->count())
                $arr[]=$user->where('id',$user->id);
            if($data == 'all')
                $arr[]=$user->where('id',$user->id);
        }
        return $query->find($arr);
        dd('dd');
//        if(auth()->user()->orders->count())
//        dd(auth()->user()->orders->count());
//            return $query->;
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
