<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // User::factory(10)->create();

        static::seedInitialData($this);
        static::seedFakeData($this);
    }

    public static function seedInitialData(?self $instance = null): void
    {
        $instance ??= app(static::class);

        static::initialAdminUsers();
    }

    public static function seedFakeData(?self $instance = null): void
    {
        $instance ??= app(static::class);

        if (app()?->environment(['stage', 'production']) || app()?->isProduction()) {
            return;
        }

        $instance->call([
            //
        ]);

        User::factory(2)->create();
    }

    public static function initialAdminUsers(?self $instance = null): void
    {
        $instance ??= app(static::class);

        $adminUsers = [
            [
                'email' => 'admin@mail.com',
                'name' => 'Admin',
                'password' => Hash::make('power@123'),
            ]
        ];

        foreach ($adminUsers as $adminUser) {
            $user = User::updateOrCreate([
                'email' => $adminUser['email'],
            ], $adminUser);
        }
    }
}
