<?php

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
            \Illuminate\Support\Facades\DB::table('users')->insert([
                'name'     => \Illuminate\Support\Str::random(3),
                'email'    => \Illuminate\Support\Str::random(3) . '@gmail.com',
                'password' => bcrypt('secret'),
            ]);
        }
    }
