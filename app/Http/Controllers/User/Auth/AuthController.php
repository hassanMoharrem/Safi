<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
    public function loginIndex()
    {
        if (Auth::guard('web')->check()) {
            Session::flush();
            Auth::guard('web')->logout();
            return redirect()->route('user.login.index');
        }
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'phone' => 'required|exists:users,phone',
            'password' => 'required|max:300',
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
            ]);
        }
        if (Auth::guard('web')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = User::where('phone',$request->phone)->first();
            auth()->login($user);
            $user['token'] =  $user->createToken('MyApp')->plainTextToken;
            return response()->json([
                "status" => 200,
                "message" => "تم الدخول بنجاح",
                'data' => $user
            ]);
        } else {
            $errors = new MessageBag();
            $errors->add('Error', __('The data is wrong'));
            return response()->json([
                "status" => false,
                "message" => $errors,
            ]);
        }
    }
    public function registerIndex()
    {
        return view('user.auth.register');
    }
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:50|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'image' => 'nullable|image',
        ]);
        if ($validation->fails()) {
            $message = $validation->errors();
            return redirect()->back()->withInput()->withErrors($validation->errors())->with('customVariable', $message);
        }
        $input = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('images', 'public');
        } else {
            $image = $input['image'];
        }

        $input['password'] = Hash::make($input['password']);
        $input['image'] = $image;
        $user = User::create($input);
        auth()->login($user);
        return redirect()->route('user.dashboard');
    }

    public function logout()
    {
        Session::flush();
        Auth::guard('web')->logout();
        return redirect()->route('user.login.index');
    }
}
