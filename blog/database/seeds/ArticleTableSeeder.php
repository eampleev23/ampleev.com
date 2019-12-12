<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'Евгений Амплеев',
            'email' => 'e+1000@mpleev.com',
            'password' => bcrypt('password'),
            'avatar_path' => '/storage/user_avatars/female-3_my.jpg',
        ]);

        DB::table('blog_sections')->insert([
            'title' => 'Agile',
        ]);

        DB::table('articles')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
