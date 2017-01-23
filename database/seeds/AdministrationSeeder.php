<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;

class AdministrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roleAdmin = new Kodeine\Acl\Models\Eloquent\Role();
		$roleAdmin->name = 'Administrator';
		$roleAdmin->slug = 'administrator';
		$roleAdmin->description = 'manage back office';
		$roleAdmin->save();

        $user = factory(App\User::class)->create([
        	'username' => 'Admin', 
            'password' => bcrypt('admin'),
        	'email' => 'admin@group-up.com',
            'api_token' => str_random(60)
        	]);

        DB::table('role_user')->insert([
        	'role_id' => $roleAdmin->id,
        	'user_id' => $user->id
        	]);
    }
}
