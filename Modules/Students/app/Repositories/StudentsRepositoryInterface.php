<?php

namespace Modules\Students\Repositories;

use App\Repositories\RepositoryInterface;

interface StudentsRepositoryInterface extends RepositoryInterface
{
    // Define methods here
        // Define methods here
        public function getStudent($limit);

        public function getAllStudents();
    
        public function setPassword($password, $id);
    
        public function checkPassword($password, $id);
    
        public function deleteMultiple(array $ids);
}
