<?php

namespace App\Services;


use App\Entities\Menu;
use App\Role;

class MenuService extends BaseService
{
    /**
     * @var Menu
     */
    private $model;

    /**
     * MenuService constructor.
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    /**
     * Get all menu
     *
     * @param Role $role
     * @return mixed
     */
    public function getAllMenuByRole(Role $role)
    {
        return $this->model->select('id', 'name', 'description', 'url', 'icon')
            ->where('parent_id', null)
            ->whereHas('roles', function ($query) use ($role) {
                $query->where('role_id', $role->id);
            })
            ->with(['children' => function ($query) {
                $query->select('parent_id', 'name', 'description', 'url', 'icon');
            }])
            ->orderBy('order', 'asc')
            ->get();
    }
}