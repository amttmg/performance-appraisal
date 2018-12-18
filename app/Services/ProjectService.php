<?php

namespace App\Services;


use App\Entities\Project;
use App\Session;
use App\User;
use Illuminate\Support\Facades\DB;

/**
 * Class ProjectService
 * @package App\Services
 */
class ProjectService extends BaseService
{
    /**
     * @var Project
     */
    protected $model;

    /**
     * ProjectService constructor.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->model = $project;
    }

    /**
     * Store from csv
     *
     * @param $storeData
     */
    public function storeFromCsv($storeData)
    {
        foreach ($storeData as $project) {
            $this->model->updateOrCreate(['project_code' => $project['project_code']], $project);
        }
    }

    /**
     * get all projects
     *
     * @return Project[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->model->all();
    }

    /**
     * @param $storeData
     * @return bool
     */
    public function linkProjectsEmployee($storeData)
    {
        $session    = Session::where('is_active', 1)->firstOrFail();
        $employeeId = $storeData['employeeId'];
        $projects   = $storeData['projects'];

        DB::transaction(function () use ($employeeId, $projects, $session) {
            $user = User::find($employeeId);
            if ($user) {
                $user->projects()->where(['session_id' => $session->id])->detach();
                foreach ($projects as $project) {
                    $user->projects()->attach($project['value'], ['session_id' => $session->id]);
                }
            }
        });

        return true;
    }

    public function getUsersWithProjects($technologyId = 0)
    {
        $session    = Session::where('is_active', 1)->firstOrFail();
        $usersQuery = User::select('*');
        if ($technologyId) {
            $usersQuery->where('technology_id', $technologyId);
        }
        $users = $usersQuery->with('projects')->whereHas('projects', function ($query) use ($session) {
            $query->where('session_id', $session->id);
        })->get();

        return $users;
    }
}
