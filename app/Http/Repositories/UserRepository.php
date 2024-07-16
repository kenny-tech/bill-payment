<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Register user function
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return object
     */
    public function create(string $name, string $email, string $password) : object
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;

        $user->save();

        return $user;
    }
}
