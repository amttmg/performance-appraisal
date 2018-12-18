<?php

namespace App\Services;

use App\Session;
use Illuminate\Support\Facades\DB;

/**
 * Class SessionService
 * @package App\Services
 */
class SessionService extends BaseService
{
    /**
     * @var Session
     */
    protected $model;

    /**
     * SessionService constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->model = $session;
    }

    /**
     * @param $storeData
     * @return mixed
     */
    public function store($storeData)
    {
        return DB::transaction(function () use ($storeData) {
            $storeData['is_active'] = filter_var($storeData['is_active'], FILTER_VALIDATE_BOOLEAN);
            if ($storeData['is_active'] == true) {
                $this->model->where('is_active', 1)->update(['is_active' => false]);
            }

            return $this->model->create($storeData);
        });
    }

    /**
     * @param $storeData
     * @param $id
     * @return mixed
     */
    public function changeState($storeData, $id)
    {
        return DB::transaction(function () use ($storeData, $id) {
            $storeData['is_active'] = filter_var($storeData['is_active'], FILTER_VALIDATE_BOOLEAN);
            if ($storeData['is_active'] == true) {
                $this->model->where('is_active', 1)->update(['is_active' => false]);
            }

            return $this->update($storeData, $id);
        });
    }
}
