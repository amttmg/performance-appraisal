<?php

namespace App\Services;


use App\Technology;

/**
 * Class TechnologyService
 * @package App\Services
 */
class TechnologyService extends BaseService
{
    /**
     * @var Technology
     */
    protected $model;

    /**
     * TechnologyService constructor.
     * @param Technology $technology
     */
    public function __construct(Technology $technology)
    {
        $this->model = $technology;
    }

    /**
     * @param string $projectName
     * @return
     */
    public function firstOrCreate(string $projectName)
    {
        return $this->model->firstOrCreate(['name' => str_slug($projectName)], ['description' => $projectName]);
    }
}
