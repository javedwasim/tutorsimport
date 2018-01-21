<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Lesson;

class LesssonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan make:seeder LesssonTableSeeder
     * composer search faker
     * composer require fzaninotto/faker --dev
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,30) as $index){
            Lesson::create([

                'title'=>$faker->sentence(5),
                'body'=>$faker->paragraph(4),

            ]);
        }
    }
}
