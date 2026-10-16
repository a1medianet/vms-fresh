<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تم حذف display_name و description لأنها تسببت في الانهيار الأخير
        $roles = [
            ['name' => 'super-admin', 'guard_name' => 'web'],
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'staff', 'guard_name' => 'web'],
        ];

        foreach ($roles as $role) {
            // استخدام updateOrCreate يضمن عدم توقف السكربت حتى لو تكرر التشغيل
            Role::updateOrCreate(
                ['name' => $role['name']],
                ['guard_name' => $role['guard_name']]
            );
        }
    }
}
