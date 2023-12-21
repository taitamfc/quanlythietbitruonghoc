<?php

namespace Modules\AdminUser\database\seeders;

use Illuminate\Database\Seeder;
use Modules\AdminUser\app\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = AdminUser::where('email','admin@gmail.com')->first();
        if(!$user){
            $user = new AdminUser();
            $user->name = 'admin';
            $user->email = 'admin@gmail.com';
            $user->password = Hash::make(123456);
            $user->save();
        }
    }
}
