<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role; // استيراد موديل الرتب
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // التأكد من وجود الرتب قبل الربط
        $superAdminRole = Role::where('name', 'super-admin')->first();

        if ($superAdminRole) {
            // إنشاء المستخدم أو تحديثه إذا كان موجوداً لمنع تكرار البيانات
            $admin = User::firstOrCreate(
                ['email' => 'admin@vms.local'],
                [
                    'name' => 'Super Admin',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            // ربط المستخدم برتبة الأدمن
            $admin->assignRole($superAdminRole);
        }
    }
}
