<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function Laravel\Prompts\password;

class UserApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_index=Permission::create(['name'=>'User_index']);
        $user_show=Permission::create(['name'=>'User_show']);
        $user_update=Permission::create(['name'=>'User_update']);
        $user_destroy=Permission::create(['name'=>'User_destroy']);
        $user_confirmed=Permission::create(['name'=>'User_confirmed']);

        //--------------------------------------------- admin -------------------------------------------------------
        $admin_role=Role::create(['name'=>'admin']);
        $admin_role->givePermissionTo([
            $user_confirmed,
            $user_destroy,
            $user_index,
            $user_show,
            $user_update
        ]);
        $admin=User::create([
           'first_name'=>'admin',
           'email'=>'admin@gmail.com',
            'role'=>'admin',
            'password'=>Hash::make('123456'),
        ]);

        $admin->assignRole($admin_role);
        $admin->givePermissionTo([
            $user_confirmed,
            $user_destroy,
            $user_index,
            $user_show,
            $user_update
        ]);

        //--------------------------------------------- seller -------------------------------------------------------
        $seller_role=Role::create(['name'=>'seller']);
        $seller_role->givePermissionTo([
            $user_show,
            $user_update
        ]);
        $seller=User::create([
           'first_name'=>'seller',
           'email'=>'seller@gmail.com',
            'role'=>'seller',
            'status'=>'Awaiting confirmation',
            'password'=>Hash::make('123456'),
        ]);
        $seller->assignRole($seller_role);
        $seller->givePermissionTo([
            $user_show,
            $user_update
        ]);
        //--------------------------------------------- customer -------------------------------------------------------
        $customer_role=Role::create(['name'=>'customer']);
        $customer_role->givePermissionTo([
            $user_show,
            $user_update
        ]);
        $customer=User::create([
            'first_name'=>'customer',
            'email'=>'customer@gmail.com',
            'role'=>'customer',
            'password'=>Hash::make('123456'),
        ]);
        $customer->assignRole($customer_role);
        $customer->givePermissionTo([
            $user_show,
            $user_update
        ]);
    }
}
