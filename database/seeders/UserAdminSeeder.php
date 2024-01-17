<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->withoutModelEvents(function () {
            $user = [
                'name' => 'Phuc Nguyen',
                'email' => 'phucnguyen@besmartee.com',
                'password' => Hash::make('Abc12345'),
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ];
            User::query()->createOrFirst(Arr::only($user, 'email'), $user);
        })();
    }
}
