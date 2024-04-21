<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController;
use App\Models\User;

class UserController extends BaseController
{

    public function index()
    {
        $view = 'admin.users.users';
        $parameters = [];
        return parent::indexBase($view , $parameters); // Pass the $view variable to the parent method
    }
    public function getAllData($model = "default", array $relation = [], string $direction = "ASC", int $page = 10)
    {
        $model = User::class;
        return parent::getAllData($model, $relation, $direction, $page); // TODO: Change the autogenerated stub
    }

    public function store()
    {
        $model = User::class;
        $params = \request()->all();
        $rules = [
            'name' => 'required|string|min:3|max:50|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:6',
            'num_system' => 'nullable|numeric|min:1',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'image' => 'nullable|image'
        ];
        return parent::storeBase($model,$params,$rules); // Pass the $view variable to the parent method
    }

    public function show($id , $model = 'default')
    {
        $model = User::class;
        return parent::showBase($id,$model); // Pass the $view variable to the parent method
    }

    public function update($id){
        $model = User::class;
        $params = \request()->all();
        $rules = [
            'name' => 'required|string|min:3|max:50|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'phone' => 'required|numeric|digits:10|unique:users,phone,'. $id,
            'image' => 'nullable|image'
        ];
        return parent::updateBase($id,$model,$params,$rules); // Pass the $view variable to the parent method

    }

    public function destroy($id , $model = "default")
    {

        return parent::destroyBase($id,User::class); // Pass the $view variable to the parent method
    }
}