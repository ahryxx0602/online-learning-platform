<?php

namespace Modules\User\Repositories;

interface UserRepositoryInterface
{
    // Define methods here
    public function getUser($limit);

    public function getAllUsers();

    public function setPassword($password, $id);

    public function checkPassword($password, $id);

    public function deleteMultiple(array $ids);
}
