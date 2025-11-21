<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        $superAdminUserId = DB::table('users')->insertGetId([
            'name' => 'Jan Kück',
            'email' => 'jankuek@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => now(),
        ]);

        $userId = DB::table('users')->insertGetId([
            'name' => 'Max Mustermann',
            'email' => 'maxmustermann@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => now(),
        ]);

        $user1Id = DB::table('users')->insertGetId([
            'name' => 'Anita Musterfrau',
            'email' => 'anitamusterfrau@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => now(),
        ]);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'view.dashboard-menu']);
        Permission::create(['name' => 'view.vehicles-menu']);
        Permission::create(['name' => 'view.users-menu']);
        Permission::create(['name' => 'view.roles-menu']);
        
        Permission::create(['name' => 'vehicles.create']);
        Permission::create(['name' => 'vehicles.edit']);
        Permission::create(['name' => 'vehicles.delete']);

        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'users.edit.roles']);

        Permission::create(['name' => 'roles.create']);
        Permission::create(['name' => 'roles.edit']);
        Permission::create(['name' => 'roles.delete']);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::create(['name' => 'user'])
            ->givePermissionTo(['view.vehicles-menu', 'view.dashboard-menu']);

        $role = Role::create(['name' => 'user-extended'])
            ->givePermissionTo(['view.vehicles-menu', 'view.dashboard-menu', 'view.users-menu', 'users.create', 'users.edit', 'users.delete']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userExtendedRole = Role::firstOrCreate(['name' => 'user-extended']);

        $superAdminUser = User::find($superAdminUserId);
        $superAdminUser->assignRole($adminRole);

        $normalUser = User::find($userId);
        $normalUser->assignRole($userRole);

        $userExtended = User::find($user1Id);
        $userExtended->assignRole($userExtendedRole);

    }
}
