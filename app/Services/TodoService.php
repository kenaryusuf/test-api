<?php

namespace App\Services;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

class TodoService extends BaseService
{
    public function __construct()
    {
        $this->setModel(new Todo());
    }

    public function create($data): Todo
    {
        return $this->model()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'email' => $data['email'],
            'date' => $data['date'],
            'status' => $data['status']
        ]);
    }

    public function getAllTodo()
    {
        return $this->model()->get();
    }


}
