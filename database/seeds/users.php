<?php

use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array(
                'name' => 'admin',
                'email' => 'admin@lookout.com',
                'password' => 'admin',
                'admin' => true
            ),
            array(
                'name' => 'consultant',
                'email' => 'consultant@lookout.com',
                'password' => 'consultant',
                'admin' => false
            )
        );
 
        DB::table('users')->insert($users);
    }
}
