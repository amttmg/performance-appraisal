<?php

use App\QuestionGroup;
use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionGroups = [
            ['title' => 'Technical Skills'],
            ['title' => 'Analytical and Problem Solving Skills'],
            ['title' => 'Attitude and Behavior'],
            ['title' => 'PHP', 'parent_id' => 1],
            ['title' => 'Javascript/Jquery', 'parent_id' => 1],
            ['title' => 'Database', 'parent_id' => 1],
            ['title' => 'GIT', 'parent_id' => 1],
        ];

        foreach ($questionGroups as $questionGroup) {
            QuestionGroup::updateOrCreate(
                ['title' => $questionGroup['title']],
                $questionGroup
            );
        }
    }
}
