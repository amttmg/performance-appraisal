<?php

use App\Technology;
use Illuminate\Database\Seeder;

class TechnologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technologies = [
            ['name' => 'IOS', 'description' => 'IOS'],
            ['name' => 'Android', 'description' => 'Android'],
            ['name' => 'Web Service', 'description' => 'Web Service'],
            ['name' => 'Laravel', 'description' => 'Laravel'],
            ['name' => 'Wordpress', 'description' => 'Wordpress'],
            ['name' => 'E-COMMERCE', 'description' => 'E-COMMERCE'],
            ['name' => 'ASP.NET', 'description' => 'ASP'],
            ['name' => 'Quality Analyst', 'description' => 'Quality Analyst'],
            ['name' => 'Business Analyst', 'description' => 'Business Analyst'],
            ['name' => 'Project Management', 'description' => 'Project Management'],
        ];
        foreach ($technologies as $technology) {
            Technology::updateOrCreate(['name' => $technology['name']], $technology);
        }
    }
}
