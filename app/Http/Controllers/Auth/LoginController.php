<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use JWTAuth;

/**
 * @Resource("Authentication", uri="/auth" )
 */
class LoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login user
     *
     * Login user with a `email` and `password`.
     * Token is returned which will be required in every request
     *
     * @Post("/login")
     * 
     * @Transaction({
     *      @Request({"email":"user1@mailinator.com","password":"123456"}),
     *      @Response(200, body={"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJlMDk1YjRlMS1hNjdhLTRiZDQtOTQ5OS03YWRjN2IxNzVkODQiLCJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTQ5NDU4NjE4MywiZXhwIjoxNDk0NTg5NzgzLCJuYmYiOjE0OTQ1ODYxODMsImp0aSI6IkNQZVFFbzA1YkwwRGswNVoifQ.RouE5IpWIGsuxshQ3U5q1LzMivN9KfGPA93LpdadbRM","user":{"id":"e095b4e1-a67a-4bd4-9499-7adc7b175d84","username":"tgorczany","email":"lee52@example.org","avatar":"http:\/\/lorempixel.com\/640\/480\/?99996","firstname":"Norma","surname":"Langworth","created_at":"2017-05-12 10:43:35"}}),
     *      @Response(401, body={ "error":"invalid_credentials","message":"Invalid credentials", "status_code": 401 }),
     *      @Response(500, body={ "error":"could_not_create_token","message":"Internal Server Error", "status_code": 500 })
     * })
     */
    public function login(Request $request, $login_type = 'user_login')
    {
        if ($login_type == 'client_login') {
            \Config::set('auth.providers.users.model', \App\Models\Client::class);
        }
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials',
                        'message' => 'Invalid credentials', 'status_code' => 401], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token',
                    'message' => 'Internal Server Error', 'status_code' => 500], 500);
        }
        $user = JWTAuth::toUser($token);
//        if ($user->isBlocked()) {
//            return response()->json(['error' => 'user_blocked',
//                    'message' => 'Your account has been blocked', 'status_code' => 401], 401);
//        }
//        if ($user->isDeactived()) {
//            return response()->json(['error' => 'user_deactivated',
//                    'message' => 'Your Account has been deactivated. Please email us at abc@xyz.com to reactivate your account.', 'status_code' => 401], 401);
//        }
//        if ($user->isBanned()) {
//            return response()->json(['error' => 'user_blocked',
//                    'message' => 'Your account has been blocked', 'status_code' => 401], 401);
//        }
        return compact('token', 'user');
    }

//
//    /**
//     * Send Password Reset Code
//     *
//     * @Post("/send-password-reset-code")
//     * 
//     * @Parameters({
//     *      @Parameter("email",  description="Email for code", required=true)
//     * })
//     * 
//     * @Transaction({
//     *      @Request({"email":"user@mailinator.om"}),
//     *      @Response(200),
//     *      @Response(422, body={"message": "Could not send reset password email.", "errors": {"email": {"Email does not exists."}}, "status_code": 422,}),
//     *      @Response(422, body={"message":"Could not send reset password email.","status_code":422})
//     * })
//     * 
//     */
    public function sendPasswordResetCode(Request $request)
    {
        $email = $request->get('email');
        $user = User::where('email', '=', $email)->first();
        if (!$user) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not send reset password email.', ['email' => 'Email does not exists.']);
        }

        $password_reset = PasswordReset::where('email', '=', $user->email)->first();
        if (!$password_reset) {
            $password_reset = new PasswordReset;
            $password_reset->email = $user->email;
        }
        $password_reset->token = mt_rand(1000, 9999);
        if ($password_reset->save()) {
            # Send Email oops email work remain
            \Mail::to($user)->send(new PasswordResetCode($password_reset));
//            return [];
            return $password_reset;
        }
        throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not send reset password email.', $password_reset->getErrors());
    }

//
//    /**
//     * Reset password 
//     *
//     * @Post("/reset-password")
//     * 
//     * @Parameters({
//     *      @Parameter("email", description="Email for code", required=true),
//     *      @Parameter("token", description="4 digits code", required=true),
//     *      @Parameter("password", description="4 digits password", required=true)
//     * })
//     * 
//     * @Transaction({
//     *      @Request({"email":"user1@mailinator.com", "token": 3646, "password":1234, "confirm_password": 1234}),
//     *      @Response(200, body={"user": { "email": "user1@mailinator.com", "name": "Customer One", "plate_number": "KBP-2440", "telephone_number": 123456789, "user_type": 3, "updated_at": "2016-12-13 08:15:30", "created_at": "2016-12-01 06:16:52", "confirm_password": 1234, "id": "583fc0547d2ae705f534d4b1" }}),
//     *      @Response(422, body={"message": "Could not update password.", "errors": {"email": {"Email does not exists."}},"status_code":422}),
//     *      @Response(422, body={"message": "Could not update password.", "errors": {"token": {"Code does not match."}},"status_code":422}),
//     *      @Response(422, body={"message": "Could not update password.", "errors": {"password": {"The password field is required."}},"status_code":422}),
//     *      @Response(422, body={"message": "Could not send reset password email.","status_code":422})
//     * })
//     * 
//     */
    public function setPassword(Request $request)
    {
        $token = $request->get('token');
        $email = $request->get('email');
        $user = User::where('email', '=', $email)->first();
        if (!$user) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update user password.', ['email' => 'Email does not exists.']);
        }

        $password_reset = PasswordReset::where('token', '=', $token)
            ->where('email', '=', $email)
            ->first();
        if (!$password_reset) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update user password.', ['token' => 'Code does not match.']);
        }

        $user->changePasswordValidation();
        $user->password = $request->get('password');
        if ($user->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update user password.', $user->getErrors());
        }
//        $user->changePasswordValidation(false);
        $user->password = Hash::make($user->password);
        if ($user->save() && $password_reset->forceDelete()) {
            return $user;
        }
        throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update user password.', $user->getErrors());
    }
}
