<?php

use App\AdministrativeEvaluation;
use App\User;
use Illuminate\Database\Seeder;

class AdministrativeEvaluationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->administrativeEvaluations()
                ->updateOrCreate(['user_id' => $user->id, 'session_id' => 2], factory(AdministrativeEvaluation::class)->make()->toArray());
        }
    }
}
