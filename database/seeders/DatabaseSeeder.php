<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Community;
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
            'name' => 'goverment',
            'email' => 'gov@example.com',
        ]);
        $goverment->assignRole($govermentRole);

        $user = User::factory()->create([
            'name' => 'artist',
            'email' => 'artist@example.com',
        ]);
        Artist::create([
            'name' => 'Test Artist',
            'phone_number' => '085112345678',
            'description' => 'Test description',
            'image' => 'profile/test.png',
            'user_id' => $user->id,
        ]);

        $ivan = User::factory()->create([
            'name' => 'ivantrywicaksono',
            'email' => 'ivan@me.com',
        ]);
        Artist::create([
            'name' => 'Ivan Try Wicaksono',
            'phone_number' => '085112341234',
            'description' => 'Saya adalah seorang seniman yang mengagumi keindahan atas kesederhanaan.',
            'image' => 'profile/ivan.jpg',
            'user_id' => $ivan->id,
        ]);

        $user->assignRole($artistRole);
        $ivan->assignRole($artistRole);

        $community = User::factory()->create([
            'name' => 'community',
            'email' => 'community@example.com',
        ]);
        Community::create([
            'name' => 'Test Community',
            'phone_number' => '085112344321',
            'description' => 'Kami adalah komunitas seniman yang mengagumi keindahan atas kesederhanaan.',
            'image' => 'profile/test.png',
            'user_id' => $community->id,
        ]);
        $community->assignRole($communityRole);

        $this->call([
            PublicationSeeder::class,
            EventSeeder::class,
            PengajuanSeeder::class,
            LikeSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
