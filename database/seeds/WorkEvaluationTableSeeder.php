<?php

use App\WorkEvaluation;
use Illuminate\Database\Seeder;

class WorkEvaluationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::all();
        foreach ($users as $user) {
            $user->workEvaluations()->updateOrCreate(['user_id' => $user->id, 'session_id' => 2], factory(WorkEvaluation::class)->make()->toArray());
        }
    }
}
