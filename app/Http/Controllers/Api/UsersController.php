<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\EmployeeCsvRequest;
use App\Services\MenuService;
use App\Services\UsersServices;
use App\User;

/**
 * Class ApiController
 * @package App\Modules\Api\Lesson\Controllers
 */
class UsersController extends ApiController
{
    /**
     * @var User
     */
    private $userServices;
    /**
     * @var MenuService
     */
    private $menuService;

    /**
     * EmployeeController constructor.
     * @param UsersServices $user
     * @param MenuService   $menuService
     */
    public function __construct(UsersServices $user, MenuService $menuService)
    {
        $this->userServices = $user;
        $this->menuService  = $menuService;
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->responseWithData($this->userServices->all());
    }

    /**
     * Select data
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function selectData()
    {
        return $this->responseWithData($this->userServices->all()->pluck('name', 'id'));
    }

    /**
     * Get logged in user
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getLoggedInUser()
    {
        $user        = auth()->user();
        $role        = $user->role;
        $user->role  = $role->only('title');
        $user->menus = $this->menuService->getAllMenuByRole($role);

        return $this->responseWithData($user->only('name', 'username', 'role', 'menus'));
    }

    /**
     * @param EmployeeCsvRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(EmployeeCsvRequest $request)
    {
        $importedFileCsv = $request->file('importedFile');

        $this->userServices->store($importedFileCsv);

        return $this->responseSuccessCreate();
    }

    /**
     * Response with data
     *
     * @param $role
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getUserByRole($role)
    {
        return $this->responseWithData($this->userServices->getByRole($role));
    }

    /**
     * Set new password
     *
     * @param null $id
     */
    public function setNewPassword($id = null)
    {
        $this->userServices->setNewPassword($id);
    }

    /**
     * Delete the employee
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id)
    {
        $this->userServices->destroy($id);

        return $this->responseSuccessDelete();
    }

    /**
     * @param $technologyId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function usersByTechnology($technologyId)
    {
        $users = $this->userServices->getUsersByTechnology($technologyId);

        return $this->responseWithData($users);
    }

    /**
     * @return array
     */
    public function usersWithReport()
    {
        $users = $this->userServices->getUsersWithReports();

        return $this->responseWithData($users);
    }
}
