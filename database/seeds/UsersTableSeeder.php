<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->delete();
    	
    	$user = User::create(['name' => 'Spencer Williams',
    			'email' => 'williamcwilliams@gmail.com',
    			'password' => Hash::make('mypass')]);
    	
    	$this->command->info('Users table is ready!');
    }
}
