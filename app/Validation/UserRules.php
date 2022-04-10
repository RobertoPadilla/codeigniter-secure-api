<?php

namespace App\Validation;

use App\Models\UserModel;

class UserRules
{
    public function validateUser(string $str, string $fileds, array $data): bool
    {
        try {
            $model = new UserModel();
            $user = $model->findUserByEmailAdress($data['email']);

            return password_verify($data['password'], $user['password']);
        } catch (\Exception $e) {
            return false;
        }
    }
}
