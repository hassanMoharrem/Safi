<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Base\BaseController;
use App\Models\User;

class ProfileController extends BaseController
{
    public function index($view = 'default', $parameters = [])
    {
        $view = 'user.profile';
        return parent::indexBase($view , $parameters); // Pass the $view variable to the parent method
    }
    public function show($id , $model = 'default')
    {
        $model = User::class;
        return parent::showBase($id,$model); // Pass the $id & $model  variable to the parent method

    }
    public function update(){
        $model = User::class;
        $id = auth()->guard('web')->id();
        $params = \request()->all();
        $rules = [
            'name' => 'required|string|min:3|max:50|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|image'
        ];
        return parent::updateBase($id,$model,$params,$rules); // Pass the $id , $model , $params & $rules  variable to the parent method

    }
}
