<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Admin role
    	$adminRoleId = DB::table('roles')->insertGetId([
    		'name' => 'Administrator',
    		'slug' => 'administrator',
    		'description' => 'manage back-office',
    		]);
    	// Admin user
		$adminUserId = DB::table('users')->insertGetId([
			'username' => 'Admin',
            'password' => bcrypt('admin'),
        	'email' => 'admin@group-up.com',
            'api_token' => str_random(60)
			]);
		// Associate admin role to admin user
        DB::table('role_user')->insert([
        	'role_id' => $adminRoleId,
        	'user_id' => $adminUserId
        	]);
        // Default users
        DB::table('users')->insert([
        	'username' => 'Strift', 
        	'password' => 'secret', 
        	'email' => 'lau.cazanove@gmail.com', 
        	'api_token' => str_random(60)]);
        DB::table('users')->insert([
        	'username' => 'MOPZ', 
        	'password' => 'azerty', 
        	'email' => 'paul.maupas@gmail.com', 
        	'api_token' => str_random(60)]);
        DB::table('users')->insert([
        	'username' => 'quentin', 
        	'password' => 'quentin', 
        	'email' => 'fadakeke92@gmail.com', 
        	'api_token' => str_random(60)]);
    }
}
