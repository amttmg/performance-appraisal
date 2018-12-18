<?php

use App\AppraisalType;
use App\Constants\AppraiseTypes;
use Illuminate\Database\Seeder;

/**
 * Class AppraisalTypeSeeder
 */
class AppraisalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['title' => AppraiseTypes::SELF],
            ['title' => AppraiseTypes::PEER],
            ['title' => AppraiseTypes::SUPERVISOR],
        ];
        foreach ($types as $type) {
            AppraisalType::updateOrCreate(
                ['title' => $type['title']], $type
            );
        }
    }
}
