<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $avatar =  array("bear", "dog", "fox", "koala", "lion", "monkey", "owl", "panda", "tiger", "wolf");

        Validator::make($input, [
            'access_code' => ['required', 'string', 'in:C41416'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:200'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ],
        [
            'access_code.required' => 'El codigo de acceso es obligatorio',
            'access_code.in' => 'El codigo de acceso es incorrecto',
            'name.required' => 'El nombre es obligatorio',
            'last_name.required' => 'El apellido es obligatorio',
            'email.required' => 'El correo es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'avatar' => $avatar[array_rand($avatar)],
        ]);
    }
}
