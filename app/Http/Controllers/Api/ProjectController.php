<?php

namespace App\Http\Controllers\Api;

use App\Entities\Project;
use App\Http\Requests\ProjectCsvRequest;
use App\Services\ProjectService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ProjectController
 * @package App\Http\Controllers\Api
 */
class ProjectController extends ApiController
{
    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * ProjectController constructor.
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return $this->responseWithData($this->projectService->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Project $project
     * @return void
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entities\Project    $project
     * @return void
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id)
    {
        $this->projectService->destroy($id);

        return $this->responseSuccessDelete();
    }

    /**
     * Upload Csv
     *
     * @param ProjectCsvRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function uploadCsv(ProjectCsvRequest $request)
    {
        $importedFileCsv = $request->file('importedFile');
        $projects        = $this->projectService->storeFromCsv(csvToArray($importedFileCsv));

        return $this->responseSuccessCreate($projects);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function linkProjectsEmployee(Request $request)
    {
        $this->projectService->linkProjectsEmployee($request->only('employeeId', 'projects'));

        return $this->responseSuccessCreate();
    }

    /**
     * @param $technologyId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getUsersWithProjects($technologyId)
    {
        return $this->responseWithData($this->projectService->getUsersWithProjects($technologyId));
    }

    public function unLinkProjectEmployee($id)
    {
        $success = DB::table('project_user')->where('id', $id)->delete();
        dd($success);
    }
}
