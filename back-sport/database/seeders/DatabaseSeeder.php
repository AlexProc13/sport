<?php

namespace Database\Seeders;

use DB;
use DateTime;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = config('app.user');
        $userExist = DB::table('users')->where('id', $user['id'])->first();
        if (!$userExist) {
            DB::table('users')->insert([
                'id' => $user['id'],
                'email' => $user['email'],
                'last_activity' => new DateTime(),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
