<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::destroy(Permission::pluck('id'));

        Permission::create(['name' => 'user-management']);
        Permission::create(['name' => 'website-user-management']);
        Permission::create(['name' => 'role-management']);
        Permission::create(['name' => 'programs-management']);
        Permission::create(['name' => 'products-management']);
        Permission::create(['name' => 'gallery-management']);
        Permission::create(['name' => 'media-management']);
        Permission::create(['name' => 'forms-management']);
        Permission::create(['name' => 'shop-orders-management']);
        Permission::create(['name' => 'article-management']);
        Permission::create(['name' => 'newsletter-management']);
        Permission::create(['name' => 'shop-subscriptions-management']);


        $super_admin=Role::updateOrCreate(['name'=>'SuperAdmin']);

        $user=User::updateOrCreate(
            ['email'=>'superadmin@gmail.com'],
            [
            'name'=>'Super Admin',
            'is_admin'=>1,
            'password'=>Hash::make('admin')
            ]);

        $user->syncRoles($super_admin);

    }
}
