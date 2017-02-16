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
        $user1Id = DB::table('users')->insertGetId([
        	'username' => 'Strift', 
        	'password' => bcrypt('secret'), 
        	'email' => 'lau.cazanove@gmail.com', 
        	'api_token' => str_random(60)]);
        $user2Id = DB::table('users')->insertGetId([
        	'username' => 'MOPZ', 
        	'password' => bcrypt('azerty'), 
        	'email' => 'paul.maupas@gmail.com', 
        	'api_token' => str_random(60)]);
        $user3Id = DB::table('users')->insertGetId([
        	'username' => 'quentin', 
        	'password' => bcrypt('quentin'), 
        	'email' => 'fadakeke92@gmail.com', 
        	'api_token' => str_random(60)]);
        // Default users schedule
        DB::table('schedules')->insert([
            'user_id' => $user1Id
            ]);
        DB::table('schedules')->insert([
            'user_id' => $user2Id
            ]);
        DB::table('schedules')->insert([
            'user_id' => $user3Id
            ]);
    }
}
