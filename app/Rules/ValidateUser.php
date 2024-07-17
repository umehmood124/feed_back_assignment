<?php

namespace App\Rules;

use App\Models\User;

class ValidateUser implements \Illuminate\Contracts\Validation\Rule
{
    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $user = User::where('email', $value)->first();
        return $user == null;
    }


    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'User already exist!';
    }
}
