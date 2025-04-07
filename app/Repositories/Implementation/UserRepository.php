<?php

namespace App\Repositories\Implementation;

use App\Models\User;
use App\Repositories\Interface\IUser;

class UserRepository implements IUser
{

 
 
    public function getByEmail($email)
    {
        return User::where('email', $email)->first();
    }
    public function store($model)
    {
        return User::create($model);
    }

    public function update($model)
    {
        return $model->save();
    }

   



}
