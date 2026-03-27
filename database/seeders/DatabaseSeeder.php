<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);
        $roles = \App\Models\Role::all();

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name'  => 'Sistema',
            'email'      => 'admin@educacao.com',
            'cpf'        => '12345678901',
            'position'   => 'Desenvolvedor',
        ]);

        $admin->roles()->attach(1);

        $users = User::factory(39)->create()->each(function ($user) use ($roles) {
            $user->roles()->attach([2]);
        });

        $allUsers = $users->concat([$admin]);

        Post::factory(50)->make()->each(function ($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });



    }
}
