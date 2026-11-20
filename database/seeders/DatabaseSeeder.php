<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['admin@example.com', 'Admin Demo', 'admin'],
            ['student@example.com', 'Student Demo', 'student']
        ];

        foreach ($accounts as [$email, $name, $role]) {
            $user = User::firstOrNew(['email' => $email]);
            $user->name = $name;
            $user->password = Hash::make('password');
            $user->role = $role;
            $user->save();
        }
        $this->call(DemoContentSeeder::class);
    }
}
