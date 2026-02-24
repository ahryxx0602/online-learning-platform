<?php

namespace Modules\Students\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Modules\Students\Models\Student;
use Modules\Students\Models\Students;

class StudentsRepository extends BaseRepository implements StudentsRepositoryInterface
{
    public function getModel()
    {
        return Student::class;
    }

    public function getStudent($limit)
    {
        return $this->model->paginate($limit);
    }

    public function getAllStudents()
    {
        return $this->model->select(['id','name', 'email', 'phone', 'address', 'status'])->latest();
    }
    public function setPassword($password, $id)
    {
        return $this->update($id, ['password' => Hash::make($password)]);
    }
    public function checkPassword($password, $id){
        $user = $this->find($id);
        if($user){
            $hashPassword = $user->password;
            return Hash::check($password, $hashPassword);
        }
        return false;
    }

    public function deleteMultiple(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}
