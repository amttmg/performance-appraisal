<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // $this->call(TechnologyTableSeeder::class);
        //$this->call(UserTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(AppraisalTypeSeeder::class);
        //$this->call(QuestionTableSeeder::class);
        //$this->call(MenuTableSeeder::class);
        //$this->call(WorkEvaluationTableSeeder::class);
       // $this->call(AdministrativeEvaluationTableSeeder::class);
    }
}