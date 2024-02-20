<?php

namespace App\Services;

use App\Models\User;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->setModel(new User());
    }

}
