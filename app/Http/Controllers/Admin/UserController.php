<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController;
use App\Http\Controllers\LanguageController;
use App\Models\User;
use http\Env\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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
        $lang = request()->header('Accept-Language') ?? 'en';
        $model = User::class;
        $params = \request()->all();
        $rules = [
            'name' => 'required|string|min:3|max:50|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:1',
            'num_system' => 'nullable|numeric|min:1',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'image' => 'nullable|image'
        ];
        return parent::storeBase($model,$params,$rules ,$lang); // Pass the $view variable to the parent method
    }

    public function show($id , $model = 'default')
    {
        $lang = request()->header('Accept-Language') ?? 'en';
        $model = User::class;
        return parent::showBase($id,$model); // Pass the $view variable to the parent method
    }

    public function update($id){
        $lang = request()->header('Accept-Language') ?? 'en';
        $model = User::class;
        $params = \request()->all();
        $rules = [
            'name' => 'required|string|min:3|max:50|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:1',
            'phone' => 'required|numeric|digits:10|unique:users,phone,'. $id,
            'image' => 'nullable|image'
        ];
        return parent::updateBase($id,$model,$params,$rules,$lang); // Pass the $view variable to the parent method

    }

    public function destroy($id)
    {
        $lang = request()->header('Accept-Language') ?? 'en';
        return parent::destroyBase($id,User::class,$lang); // Pass the $view variable to the parent method
    }
}
