<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

            \App\Models\User::updateOrCreate(
                [
                'email' => 'user@user.com',
                'is_admin' => 0,
                ],
                [
                'name' => 'User',
                'password' => bcrypt('user'),
                'email_verified_at'=>now(),
                ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(PermissionSeeder::class);
        $this->call(CountrySeeder::class);
    }
}
