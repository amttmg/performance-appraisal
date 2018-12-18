<?php

namespace App\Services;

use App\Employee;
use App\Notifications\SendNewPasswordNotification;
use App\Technology;
use App\User;

/**
 * Class EmployeeServices
 * @package App\Services
 */
class UsersServices extends BaseService
{
    /**
     * @var Employee
     */
    protected $model;
    /**
     * @var Technology
     */
    private $technology;

    /**
     * EmployeeServices constructor.
     * @param User       $employee
     * @param Technology $technology
     */
    public function __construct(User $employee, Technology $technology)
    {
        $this->model      = $employee;
        $this->technology = $technology;
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function all()
    {
        return $this->model->with(['role', 'technology'])->orderBy('name', 'asc')->get();
    }

    /**
     * @param array $storeData
     * @return mixed|void
     */
    public function store($storeData)
    {
        $employees = csvToArray($storeData);
        foreach ($employees as $employee) {
            if ($this->model->where('email', $employee['email'])->exists()) {
                $this->model->where('email', $employee['email'])->update($employee);
            } else {
                $employee['password'] = bcrypt('password');
                $this->model->create($employee);
            }
        }
    }

    /**
     * Get By Role
     *
     * @param $role
     * @return
     */
    public function getByRole($role)
    {
        return $this->model->whereHas('role', function ($query) use ($role) {
            $query->where('title', 'developer');
        })->get();
    }

    /**
     * Set New Password
     *
     * @param null $id
     */
    public function setNewPassword($id = null)
    {
        if ($id) {
            $user = $this->model->find($id);
            $this->changePassword($user);
        } else {
            $users = $this->model->where('name', '!=', 'admin')->get();
            foreach ($users as $user) {
                $this->changePassword($user);
            }
        }
    }

    /**
     * @param $user
     */
    private function changePassword($user)
    {
        $plainPassword  = $this->generatePassword();
        $user->password = bcrypt($plainPassword);
        $user->save();
        $user->notify(new SendNewPasswordNotification($plainPassword, $user->name, $user->email));
    }

    /**
     * Generate Password
     *
     * @return int
     */
    public function generatePassword()
    {
        return str_random(10);
    }

    /**
     * @param $technologyId
     * @return
     */
    public function getUsersByTechnology($technologyId)
    {
        if (!$technologyId) {
            return $this->model->get();
        }

        return $this->model->where('technology_id', $technologyId)->get();
    }

    /**
     * Users with reports
     */
    public function getUsersWithReports()
    {
        return $this->model->with(['activeReport'])->orderBy('name', 'asc')->get();
    }
}
