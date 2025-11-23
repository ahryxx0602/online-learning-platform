<?php

namespace Modules\User\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getUser($limit)
    {
        return $this->model->paginate($limit);
    }

    public function getAllUsers()
    {
        return $this->model->select(['id','name', 'email', 'group_id', 'created_at'])->get();
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
}
