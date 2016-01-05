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
                'name' => 'coco',
                'email' => 'coco@gmail.com',
                'password' => bcrypt('cococo'),
                'admin' => true
            ),
            array(
                'name' => 'lolo',
                'email' => 'lolo@gmail.com',
                'password' => bcrypt('lololo'),
                'admin' => false
            )
        );
 
        DB::table('users')->insert($users);
    }
}
