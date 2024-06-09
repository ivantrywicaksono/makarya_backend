<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // User::factory(10)->create();
        $govermentRole = Role::create(['name' => 'Goverment']);
        $artistRole = Role::create(['name' => 'Artist']);
        $communityRole = Role::create(['name' => 'Community']);

        $goverment = User::factory()->create([
            'name' => 'Test Goverment',
            'email' => 'gov@example.com',
        ]);
        $goverment->assignRole($govermentRole);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'artist@example.com',
        ]);
        $user->assignRole($artistRole);

        $community = User::factory()->create([
            'name' => 'Test Community',
            'email' => 'community@example.com',
        ]);
        $community->assignRole($communityRole);

        $this->call([
            PublicationSeeder::class,
            EventSeeder::class,
            PengajuanSeeder::class,
        ]);
    }
}
