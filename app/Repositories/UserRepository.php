<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public static function all()
    {
        return User::all();
    }

    public static function findById(string $id)
    {
        return User::find($id);
    }

    public static function deleteById(string $id)
    {
        return User::where('id', $id)->delete();
    }

    public static function create(array $data)
    {
        return User::create($data);
    }

    public static function updateById(string $id, array $data)
    {
        return User::where('id', $id)->update($data);
    }
}
