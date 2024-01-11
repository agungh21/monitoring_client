<?php

namespace App\MyClass;

class Validations
{
    public static function userValidation($request)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|unique:users',
                'email' => 'nullable|email',
                'password' => 'required|confirmed',
                'role' => 'required',
            ],
            [
                'name.required' => 'Nama tidak boleh kosong',
                'username.required' => 'Username tidak boleh kosong',
                'username.unique' => 'Username sudah digunakan',
                'password.required' => 'Password tidak boleh kosong',
                'password.confirmed' => 'Password tidak sama',
                'role.required' => 'Role tidak boleh kosong',
            ]
        );
    }

    public static function userEditValidation($request, $userId)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|unique:users,username,' . $userId,
                'email' => 'nullable|email',
                'password' => 'nullable|confirmed',
                'role' => 'required',
            ],
            [
                'name.required' => 'Nama tidak boleh kosong',
                'username.required' => 'Username tidak boleh kosong',
                'username.unique' => 'Username sudah digunakan',
                'password.confirmed' => 'Password tidak sama',
                'role.required' => 'Role tidak boleh kosong',
            ]
        );
    }
}
