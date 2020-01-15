<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('admin_users')->insert([
                    'id'=>1,
                    'username' => 'admin',
                    'email' => 'admin@admin.admin',
                    'password' => bcrypt('bzhpwd123456'),
                    'avatar' => '',
                    'nickname' => '',
                    'mobile' => '',
                    'qq' => '',
                    'last_login_at' => date('Y-m-d'),
                    'last_login_ip' => '',
                    'remember_token' => '',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                    'deleted_at' => date('Y-m-d'),
                ]
            );
        }

}
