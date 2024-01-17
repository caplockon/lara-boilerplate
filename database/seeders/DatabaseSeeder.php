<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @var array
     */
    protected array $partialSeeders = [
        UserAdminSeeder::class,
    ];

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

        foreach ($this->partialSeeders as $seeder) {
            $this->call($seeder);
        }
    }

    /**
     * Push more seeders into global seeder
     *
     * @param ...$seeders
     * @return void
     */
    public function push(...$seeders): void
    {
        $this->partialSeeders = array_merge($this->partialSeeders, $seeders);
    }
}
