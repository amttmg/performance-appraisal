<?php

use App\Constants\UserRole;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * @var \App\Entities\Menu
     */
    private $menu;

    /**
     * MenuTableSeeder constructor.
     * @param \App\Entities\Menu $menu
     */
    public function __construct(\App\Entities\Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name'        => 'Dashboard',
                'description' => 'Dashboard',
                'url'         => '/dashboard',
                'icon'        => 'icon-speedometer',
                'order'       => 1,
                'roles'       => [UserRole::ADMIN_ID],
            ],
            [
                'name'        => 'Session',
                'description' => 'Session',
                'url'         => '/session',
                'icon'        => 'fa fa-clock-o',
                'order'       => 2,
                'roles'       => [UserRole::ADMIN_ID],
            ],
            [
                'name'        => 'Appraisal',
                'description' => 'Appraisal',
                'url'         => '/appraisal',
                'icon'        => 'fa fa-clock-o',
                'order'       => 3,
                'roles'       => [UserRole::ADMIN_ID],
            ],
            [
                'name'        => 'Project Employee',
                'description' => 'Project Employee',
                'url'         => '/project-employee',
                'icon'        => 'fa fa-clock-o',
                'order'       => 4,
                'roles'       => [UserRole::ADMIN_ID],
            ],
            [
                'name'        => 'A. W. Evaluations',
                'description' => 'Employee Evaluations',
                'url'         => '/employee-evaluations',
                'icon'        => 'fa fa-clock-o',
                'order'       => 4,
                'roles'       => [UserRole::ADMIN_ID],
            ],
            [
                'name'        => 'Employee',
                'description' => 'Employee',
                'icon'        => 'fa fa-users',
                'url'         => '/employees/list',
                'roles'       => [UserRole::ADMIN_ID],
                'order'       => 5,
                'sub_menus'   => [
                ],
            ],
            [
                'name'        => 'Project',
                'description' => 'Employees',
                'icon'        => 'fa fa-book',
                'url'         => '/projects/list',
                'order'       => 6,
                'roles'       => [UserRole::ADMIN_ID],
            ],
            [
                'name'        => 'P. Evaluation',
                'description' => 'JPT',
                'icon'        => 'fa fa-book',
                'url'         => '/performance-evaluation/form',
                'order'       => 7,
                'roles'       => [UserRole::SUPERVISOR_ID, UserRole::DEVELOPER_ID],
            ],
            [
                'name'        => 'Question',
                'description' => 'Questions',
                'icon'        => 'fa fa-book',
                'url'         => '/questions/list',
                'order'       => 8,
                'roles'       => [UserRole::ADMIN_ID],
            ],
            [
                'name'        => 'Reports Entry',
                'description' => 'Reports Entry',
                'icon'        => 'fa fa-download',
                'url'         => '/reports/entry',
                'order'       => 10,
                'roles'       => [UserRole::ADMIN_ID],
            ],
            [
                'name'        => 'Reports',
                'description' => 'Reports',
                'icon'        => 'fa fa-book',
                'url'         => '/reports/export',
                'order'       => 11,
                'roles'       => [UserRole::ADMIN_ID],
            ],
        ];
        foreach ($menus as $menu) {
            $parentMenu = $this->menu->updateOrCreate(['name' => $menu['name']], ['name' => $menu['name'], 'order' => $menu['order'], 'description' => $menu['description'], 'icon' => $menu['icon'], 'url' => $menu['url']]);
            $parentMenu->roles()->sync($menu['roles']);
            if (isset($menu['sub_menus']) && $parentMenu) {
                foreach ($menu['sub_menus'] as $sub_menu) {
                    $childMenu = $this->menu->updateOrCreate(['name' => $sub_menu['name'], 'parent_id' => $parentMenu->id],
                        ['name' => $sub_menu['name'], 'description' => $sub_menu['description'], 'icon' => $sub_menu['icon'], 'url' => $sub_menu['url'], 'order' => $menu['order']]);
                    $childMenu->roles()->sync($sub_menu['roles']);
                }
            }
        }
    }
}
