<?php
namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'over_name' => '阿野',
            'under_name' => '治貴',
            'over_name_kana' => 'アノ',
            'under_name_kana' => 'ハルキ',
            'mail_address' => 'compass@example.com',
            'sex' => 1, // 例: 1=男性, 2=女性など
            'birth_day' => '1990-01-01',
            'role' => 1, // 例: 1=一般ユーザー, 2=管理者など
            'password' => Hash::make('password'),
        ]);
    }
}
