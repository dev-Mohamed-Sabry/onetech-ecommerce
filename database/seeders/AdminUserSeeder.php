<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use function Symfony\Component\Clock\now;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء Role admin لو مش موجود
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // إنشاء الأدمن لو مش موجود
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        // إسناد الدور
        if (!$user->hasRole('admin')) {
            $user->assignRole($adminRole);
        }
    }
}
