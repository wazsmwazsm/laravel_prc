<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(200)->make();
        User::insert($users->toArray());

        $user = User::find(1);
        $user->name = '曙光';
        $user->email = 'shuguang@sg.com';
        $user->password = bcrypt('shuguang');
        $user->is_admin = true;
        $user->activated = true;
        $user->save();
    }
}
