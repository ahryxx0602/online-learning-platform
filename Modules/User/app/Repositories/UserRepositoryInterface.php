<?php

namespace Modules\User\Repositories;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    // Define methods here
    public function getUser($limit);

    public function getAllUsers();

    public function setPassword($password, $id);

    public function checkPassword($password, $id);

    public function deleteMultiple(array $ids);
}
