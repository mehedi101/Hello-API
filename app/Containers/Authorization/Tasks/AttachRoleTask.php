<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\RoleRepository;
use App\Containers\User\Models\User;
use App\Port\Task\Abstracts\Task;

/**
 * Class AttachRoleTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class AttachRoleTask extends Task
{

    /**
     * @var  \App\Containers\Authorization\Data\Repositories\RoleRepository
     */
    private $roleRepository;

    /**
     * GetAdminRoleTask constructor.
     *
     * @param \App\Containers\Authorization\Data\Repositories\RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param \App\Containers\User\Models\User $user
     * @param                                  $roles
     *
     * @return  \App\Containers\User\Models\User
     */
    public function run(User $user, $roles)
    {
        if (is_array($roles)) {

            foreach ($roles as $role) {
                $this->attachRole($user, $role);
            }

        }else{
            $this->attachRole($user, $roles);
        }

        return $user;
    }

    /**
     * @param $user
     * @param $roles
     *
     * @return  mixed
     */
    private function attachRole($user, $roles)
    {
        return $user->attachRole($this->roleRepository->findWhere(['name' => $roles])->first());
    }

}
