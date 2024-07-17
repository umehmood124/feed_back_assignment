<?php

namespace App\Rules;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ValidatePassword implements \Illuminate\Contracts\Validation\Rule
{
    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }
    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $user = User::where('email', $this->email)->first();
        return $user && Hash::check($value, $user->password);
    }


    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'Invalid Password!';
    }
}
