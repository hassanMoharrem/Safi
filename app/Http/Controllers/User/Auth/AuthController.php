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
use mysql_xdevapi\Exception;
use Twilio\Rest\Client;

//use Vonage\Client;
//use Vonage\Client\Credentials\Basic;
//use Vonage\SMS\Message\SMS;
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|max:300',
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
            ]);
        }

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email',$request->email)->first();
            if ($user->is_verified == true){
                auth()->login($user);
                $user['token'] =  $user->createToken('MyApp')->plainTextToken;
                return response()->json([
                    "status" => 200,
                    "message" => "تم الدخول بنجاح",
                    'data' => $user
                ]);
            }else{
//                $verify_code = rand(10000, 99999);
                $verify_code = 12345;
                $user->verify_code = $verify_code;
//                $basic  = new Basic(config('app.NEXMO_API_KEY'), config('app.NEXMO_API_SECRET'));
//                $client = new Client($basic);
//                $message = new SMS($user->phone, config('app.NEXMO_SMS_FROM'), "Confirm your mobile number: $verify_code\n");
//                $response = $client->sms()->send($message);
//                $ress = $response->current();
//                if ($ress->getStatus() == 0) {
                    return response()->json([
                        "status" => 200,
                        'success' => true,
                        "message" => " برجى تأكيد رقم الهاتف",
                    ]);
//                } else {
//                    return response()->json([
//                        "status" => $ress->getStatus(),
//                        'success' => false,
//                        "message" => "The message failed with status",
//                    ]);
//                }
            }

        } else {
            $errors = new MessageBag();
            $errors->add('Error', __('The data is wrong'));
            return response()->json([
                "status" => false,
                "message" => $errors,
            ]);
        }
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:50|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|numeric|digits:12|unique:users,phone',
            'image' => 'nullable|image'
        ]);
        if ($validation->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validation->errors(),
            ]);
        }
        $input = $request->all();

        if (isset($input['image'])) {
            $file = $input['image'];
            $input['image'] = $file->store('images', 'public');
        }

        $input['password'] = Hash::make($input['password']);
        $input['num_system'] = 1;

//        $verify_code = rand(10000, 99999);
        $verify_code = 12345;
        $input['verify_code'] = $verify_code;
        $input['is_verified'] = false;
        $user = User::create($input);
        $user['token'] =  $user->createToken('MyApp')->plainTextToken;
//      geterate code and send save code
//
//        $basic  = new Basic(config('app.NEXMO_API_KEY'), config('app.NEXMO_API_SECRET'));
//        $client = new Client($basic);
//        $message = new SMS($user->phone, config('app.NEXMO_SMS_FROM'), "Confirm your mobile number: $verify_code\n");
//        $response = $client->sms()->send($message);
//        $ress = $response->current();
//        if ($ress->getStatus() == 0) {
//            return response()->json([
//                "status" => 200,
//                'success' => true,
//                "message" => "تم تسجيل المستخدم بنجاح ، برجى تأكيد رقم الهاتف",
//                'user' => $user,
//            ]);
//        } else {
//            return response()->json([
//                "status" => $ress->getStatus(),
//                'success' => false,
//                "message" => "The message failed with status",
//            ]);
//        }

//        $twilio = new Client(config('app.TWILIO_SID'), config('app.TWILIO_AUTH_TOKEN'));
//
//        try {
//            $twilio->messages->create(
//                "whatsapp:" . $user->phone,
//                [
//                    "from" => "whatsapp:" . config('app.TWILIO_WHATSAPP_SENDER'),
//                    "body" => 'Confirm your mobile number: '.$verify_code
//                ]
//            );
            return response()->json([
                "status" => 200,
                'success' => true,
                "message" => " برجى تأكيد رقم الهاتف",
            ]);
//        }catch (\Exception $e){
//            return response()->json([
//                "status" => 500,
//                'success' => false,
//                "message" => $e->getMessage(),
//            ]);
//        }

    }
    public function verifyCode(Request $request){
        $validator = Validator::make($request->all(),[
            'code_number' => 'required|numeric|digits:5',
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        if ($request->code_number == auth()->user()->verify_code && !auth()->user()->is_verified){
            $user->is_verified = true;
            $user->save();
            return response()->json([
                "status" => 200,
                'success' => true,
                "message" => "تم تسجيل المستخدم بنجاح",
            ]);
        }else{
            return response()->json([
                "status" => 500,
                'success' => false,
                "message" => "خطأ في الكود",
            ]);
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::guard('web')->logout();
        return response()->json([
            "status" => 200,
            'success' => true,
            "message" => "تم تسجيل خروج مستخدم بنجاح",
        ]);
    }
}
