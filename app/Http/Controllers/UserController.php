<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Hash;
use Auth;
use App\Models\User;
use App\Models\PasswordReset;
use App\Mail\PasswordResetCode;

/**
 * @Resource("Users", uri="/users" )
 */
class UserController extends Controller
{

    public function index(Request $request)
    {
        
    }

    /**
     * Register User
     *
     * @Post("/register")
     * 
     * @Parameters({
     *      @Parameter("username",  description="Username should be unique", required=true),
     *      @Parameter("email", type="email",  description="Email should be unique", required=true),
     *      @Parameter("password",  description="User Password", required=true),
     *      @Parameter("name", description="Full Name of user")
     * })
     * 
     * @Transaction({
     *      @Request({"username": "user2", "email": "user2@mailinator.com", "password": "123456", "name": "User Two"}),
     *      @Response(200, body={ "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2dhbmdzdGVyLXN0cmVuZ3RoLmxvY2FsLmNvbVwvYXBpXC91c2Vyc1wvcmVnaXN0ZXIiLCJpYXQiOjE0OTEzMDQ4NjQsImV4cCI6MTQ5MTMwODQ2NCwibmJmIjoxNDkxMzA0ODY0LCJqdGkiOiIxYzA0ZDMxNDk5NWQ5ZWJlYWE1Yzk0MTdkYzQ5MzA4NiJ9.R2OMlFOwPzqtrgIgoZpF9VAH1Zm0BnLYMt2PzTR8LUk", "user": { "username": "user2", "email": "user2@mailinator.com", "created_at": "2017-04-04 11:21:03", "id": 2,"profile":{"name":"User Two","weight":null,"height":null,"gender":null,"dob":null,"biceps":null,"shoulders":null,"gym_name":null,"avatar":null,"ethnicity":null,"latitude":null,"longitude":null,"description":null} } }),
     *      @Response(422, body={"message":"Could not add new user.","errors":{"email":{"The email field is required."}, "username":{"The username field is required."}, "password": {"The password field is required."}},"status_code":422})
     * })
     */
    public function store(Request $request)
    {
        $user = new User($request->all());
        if ($user->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not add new user.', $user->getErrors());
        }
        $user->password = Hash::make($user->password);
        $ret = $user->save();
        if ($ret) {
            $token = JWTAuth::fromUser($user);
            return compact('token', 'user');
        }
        throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not add new user.', $user->getErrors());
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
     *      @Response(200, body={"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2dhbmdzdGVyLXN0cmVuZ3RoLmxvY2FsXC9hcGlcL3VzZXJzXC9yZWdpc3RlciIsImlhdCI6MTQ5MTIwNDU4MSwiZXhwIjoxNDkxMjA4MTgxLCJuYmYiOjE0OTEyMDQ1ODEsImp0aSI6ImZiMzAxMzI1YzgyMmRiMzkxMzhmOTkzMjc0MDQ5NTk1In0.L2PcdY3kuUdakNzgWirglwuJqCTtdLa-uHaAfL5OZqA","user":{"username":"user2","email":"user2@mailinator.com","created_at":"2017-04-03 07:29:40","id":2,"profile":{"name":"User Two","weight":null,"height":null,"gender":null,"dob":null,"biceps":null,"shoulders":null,"gym_name":null,"avatar":null,"ethnicity":null,"latitude":null,"longitude":null,"description":null}}}),
     *      @Response(401, body={ "error":"invalid_credentials","message":"Invalid credentials", "status_code": 401 }),
     *      @Response(401, body={ "error": "user_deactivated", "message": "Your Account has been deactivated. Please email us at abc@xyz.com to reactivate your account.", "status_code": 401 }),
     *      @Response(500, body={ "error":"could_not_create_token","message":"Internal Server Error", "status_code": 500 })
     * })
     */
    public function login(Request $request, $provider = 'app')
    {
        if ($provider != 'app') {
            $services = Config::get('services');
            if (!isset($services[$provider])) {
                return response()->json(['error' => 'invalid_provider',
                        'message' => 'Internal Server Error', 'status_code' => 500], 500);
            }
            $provider_token = $request->get('token', false);
            if ($provider_token) {
                $provider_user = Socialite::driver($provider)->userFromToken($provider_token);
            } else if ($provider == 'twitter') {
                $provider_user = Socialite::driver($provider)->user();
            } else {
                $provider_user = Socialite::driver($provider)->fields()->stateless()->user();
            }
            return [$provider_user];
            $user = User::where("{$provider}", '=', $provider_user->getId())->first();
            if (!$user) {
                $user = new User;
                $user->status = User::STATUS_ACTIVE;
                $user->email = $provider_user->getEmail();
//                if ($request->get('username')) {
//                    $user->username = $request->get('username');
//                }
                $user->{$provider} = $provider_user->getId();
                $user->providerValidation($provider);
                $profile = new Profile;
                $profile->name = $provider_user->getName();
                $profile->avatar = $provider_user->getAvatar();
                if ($user->isInvalid()) {
                    throw new \Dingo\Api\Exception\ResourceException('Could not register user.', $user->getErrors());
                }
                if ($profile->isInvalid()) {
                    throw new \Dingo\Api\Exception\ResourceException('Could not register user.', $profile->getErrors());
                }
                $user->save();
                $profile->user_id = $user->id;
                $profile->save();
//                if ($provider_user->getEmail()) {
//                    $user->email = $provider_user->getEmail();
//                    $user->save();
//                }
            }
            $token = JWTAuth::fromUser($user);
        } else {
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
        }
//        if ($user->isBlocked()) {
//            return response()->json(['error' => 'user_blocked',
//                    'message' => 'Your account has been blocked', 'status_code' => 401], 401);
//        }
        if ($user->isDeactived()) {
            return response()->json(['error' => 'user_deactivated',
                    'message' => 'Your Account has been deactivated. Please email us at abc@xyz.com to reactivate your account.', 'status_code' => 401], 401);
        }
        if ($user->isBanned()) {
            return response()->json(['error' => 'user_blocked',
                    'message' => 'Your account has been blocked', 'status_code' => 401], 401);
        }
        $user->profile;
        return compact('token', 'user');
    }

    /**
     * Login with Google
     *
     * Login user with a google code.
     * Token is returned which will be required in every request
     *
     * @Post("/login/google")
     * 
     * @Transaction({
     *      @Request({"code":"4/7zE1BAw89p1hyBuVS1NCMjMVIVfHD81VIPo0PdFhpTU"}),
     *      @Response(200, body={"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2dhbmdzdGVyLXN0cmVuZ3RoLmxvY2FsXC9hcGlcL3VzZXJzXC9yZWdpc3RlciIsImlhdCI6MTQ5MTIwNDU4MSwiZXhwIjoxNDkxMjA4MTgxLCJuYmYiOjE0OTEyMDQ1ODEsImp0aSI6ImZiMzAxMzI1YzgyMmRiMzkxMzhmOTkzMjc0MDQ5NTk1In0.L2PcdY3kuUdakNzgWirglwuJqCTtdLa-uHaAfL5OZqA","user":{"username":"user2","email":"user2@mailinator.com","created_at":"2017-04-03 07:29:40","id":2,"profile":{"name":"User Two","weight":null,"height":null,"gender":null,"dob":null,"biceps":null,"shoulders":null,"gym_name":null,"avatar":null,"ethnicity":null,"latitude":null,"longitude":null,"description":null}}}),
     *      @Response(401, body={ "error":"invalid_credentials","message":"Invalid credentials", "status_code": 401 }),
     *      @Response(401, body={ "error": "user_deactivated", "message": "Your Account has been deactivated. Please email us at abc@xyz.com to reactivate your account.", "status_code": 401 }),
     *      @Response(500, body={ "error":"could_not_create_token","message":"Internal Server Error", "status_code": 500 })
     * })
     */
    public function google(Request $request)
    {
        return $this->login($request, 'google');
    }

    /**
     * Login with Facebook
     *
     * Login user with a facebook code.
     * Token is returned which will be required in every request
     *
     * @Post("/login/facebook")
     * 
     * @Transaction({
     *      @Request({"code":"AQDB5WWoJsQCgg4mvJaczTY8ZKvUpDMemUwJf9fP3r44wXJtTaM2I5mYK43Dx3DIf5_M4RH_2lGybuavQJ6uRT2tiLPkjTYguVYYylx1G-ZPtW88aiFpz3D3126-THki87OEFnqwQQDCPhrbc7yDYgwNS5ld3aU4Kx44ruwtjKlB2v6qdgpuZcF6A4E0t6Vt5ua_tUGYB7YDFpXCsCNyXtDVRpPDxrUyf0iX3lrGax6l4Qdj_1zY4akm4DgrUgUmXcnjYoR1jf3uKVRCwm-qWXbbSLTdSsmSgc4sq8bd1ywChwYopEWFkhXikUn2civT63Gk5gq3ueBEA1y-TOijKrj8#_=_"}),
     *      @Response(200, body={"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2dhbmdzdGVyLXN0cmVuZ3RoLmxvY2FsXC9hcGlcL3VzZXJzXC9yZWdpc3RlciIsImlhdCI6MTQ5MTIwNDU4MSwiZXhwIjoxNDkxMjA4MTgxLCJuYmYiOjE0OTEyMDQ1ODEsImp0aSI6ImZiMzAxMzI1YzgyMmRiMzkxMzhmOTkzMjc0MDQ5NTk1In0.L2PcdY3kuUdakNzgWirglwuJqCTtdLa-uHaAfL5OZqA","user":{"username":"user2","email":"user2@mailinator.com","created_at":"2017-04-03 07:29:40","id":2,"profile":{"name":"User Two","weight":null,"height":null,"gender":null,"dob":null,"biceps":null,"shoulders":null,"gym_name":null,"avatar":null,"ethnicity":null,"latitude":null,"longitude":null,"description":null}}}),
     *      @Response(401, body={ "error":"invalid_credentials","message":"Invalid credentials", "status_code": 401 }),
     *      @Response(401, body={ "error": "user_deactivated", "message": "Your Account has been deactivated. Please email us at abc@xyz.com to reactivate your account.", "status_code": 401 }),
     *      @Response(500, body={ "error":"could_not_create_token","message":"Internal Server Error", "status_code": 500 })
     * })
     */
    public function facebook(Request $request)
    {
        return $this->login($request, 'facebook');
    }

    /**
     * Login with Twitter
     *
     * First request has no need input data which response has oauth_token, oauth_token_secret & oauth_callback_confirmed
     * Second request has need oauth_token, oauth_verifier  input data which response has token & user profile
     * Token is returned which will be required in every request
     *
     * @Post("/login/twitter")
     * 
     * @Transaction({
     *      @Request({}),
     *      @Request({"oauth_token":"3X2JvwAAAAAAz5owAAABW0LVcCc","oauth_verifier":"xWh0HnOvP0ffk8riAnto7SVwElxFDBJl"}),
     *      @Response(200, body={"oauth_token":"9Aw2gwAAAAAAz5owAAABW0L4mQc","oauth_token_secret":"Bdknx2I6qeEU372OkV0iKbARur4hNbli","oauth_callback_confirmed":"true"}),
     *      @Response(200, body={"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2dhbmdzdGVyLXN0cmVuZ3RoLmxvY2FsXC9hcGlcL3VzZXJzXC9yZWdpc3RlciIsImlhdCI6MTQ5MTIwNDU4MSwiZXhwIjoxNDkxMjA4MTgxLCJuYmYiOjE0OTEyMDQ1ODEsImp0aSI6ImZiMzAxMzI1YzgyMmRiMzkxMzhmOTkzMjc0MDQ5NTk1In0.L2PcdY3kuUdakNzgWirglwuJqCTtdLa-uHaAfL5OZqA","user":{"username":"user2","email":"user2@mailinator.com","created_at":"2017-04-03 07:29:40","id":2,"profile":{"name":"User Two","weight":null,"height":null,"gender":null,"dob":null,"biceps":null,"shoulders":null,"gym_name":null,"avatar":null,"ethnicity":null,"latitude":null,"longitude":null,"description":null}}}),
     *      @Response(401, body={ "error":"invalid_credentials","message":"Invalid credentials", "status_code": 401 }),
     *      @Response(401, body={ "error": "user_deactivated", "message": "Your Account has been deactivated. Please email us at abc@xyz.com to reactivate your account.", "status_code": 401 }),
     *      @Response(500, body={ "error":"could_not_create_token","message":"Internal Server Error", "status_code": 500 })
     * })
     */
    public function twitter(Request $request, $provider = 'twitter')
    {
//        return $this->login($request, 'twitter');
        $twitter_config = Config::get('services.twitter');
        $stack = GuzzleHttp\HandlerStack::create();

        // Part 1 of 2: Initial request from Satellizer.
        if (!$request->input('oauth_token') || !$request->input('oauth_verifier')) {
            $stack = GuzzleHttp\HandlerStack::create();

            $requestTokenOauth = new Oauth1([
                'consumer_key' => $twitter_config['client_id'],
                'consumer_secret' => $twitter_config['client_secret'],
                'callback' => $twitter_config['redirect'],
                'token' => '',
                'token_secret' => ''
            ]);
            $stack->push($requestTokenOauth);

            $client = new GuzzleHttp\Client([
                'handler' => $stack
            ]);

            // Step 1. Obtain request token for the authorization popup.
            $requestTokenResponse = $client->request('POST', 'https://api.twitter.com/oauth/request_token', [
                'auth' => 'oauth'
            ]);

            $oauthToken = array();
            parse_str($requestTokenResponse->getBody(), $oauthToken);

            // Step 2. Send OAuth token back to open the authorization screen.
            return response()->json($oauthToken);
        }
        // Part 2 of 2: Second request after Authorize app is clicked.
        else {
            $accessTokenOauth = new Oauth1([
                'consumer_key' => $twitter_config['client_id'],
                'consumer_secret' => $twitter_config['client_secret'],
                'token' => $request->input('oauth_token'),
                'verifier' => $request->input('oauth_verifier'),
                'token_secret' => ''
            ]);
            $stack->push($accessTokenOauth);

            $client = new GuzzleHttp\Client([
                'handler' => $stack
            ]);

            // Step 3. Exchange oauth token and oauth verifier for access token.
            $accessTokenResponse = $client->request('POST', 'https://api.twitter.com/oauth/access_token', [
                'auth' => 'oauth'
            ]);

            $accessToken = array();
            parse_str($accessTokenResponse->getBody(), $accessToken);

            $profileOauth = new Oauth1([
                'consumer_key' => $twitter_config['client_id'],
                'consumer_secret' => $twitter_config['client_secret'],
                'oauth_token' => $accessToken['oauth_token'],
                'token_secret' => ''
            ]);
            $stack->push($profileOauth);

            $client = new GuzzleHttp\Client([
                'handler' => $stack
            ]);

            // Step 4. Retrieve profile information about the current user.
            $profileResponse = $client->request('GET', 'https://api.twitter.com/1.1/users/show.json?screen_name=' . $accessToken['screen_name'], [
                'auth' => 'oauth'
            ]);
            $provider_user = json_decode($profileResponse->getBody(), true);
            // Step 5a. Link user accounts.

            $user = User::where("{$provider}", '=', $provider_user['id'])->first();
            if (!$user) {
                $user = new User;
                $user->status = User::STATUS_ACTIVE;
//                $user->email = $provider_user->email;
//                if ($request->get('username')) {
//                    $user->username = $request->get('username');
//                }
                $user->{$provider} = $provider_user['id'];
                $user->providerValidation($provider);
                $profile = new Profile;
                $profile->name = $provider_user['name'];
                $profile->avatar = $provider_user['profile_image_url'];
                if ($user->isInvalid()) {
                    throw new \Dingo\Api\Exception\ResourceException('Could not register user.', $user->getErrors());
                }
                if ($profile->isInvalid()) {
                    throw new \Dingo\Api\Exception\ResourceException('Could not register user.', $profile->getErrors());
                }
                $user->save();
                $profile->user_id = $user->id;
                $profile->save();
//                if ($provider_user->getEmail()) {
//                    $user->email = $provider_user->getEmail();
//                    $user->save();
//                }
            }
            $token = JWTAuth::fromUser($user);
            return compact('token', 'user');
        }
    }

    /**
     * Show User Profile
     *
     * @Get("/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"user":{"id":27,"username":"wilmer18","email":"jamaal23@example.org","created_at":"2017-04-06 06:10:33","friendship":{"id":3,"sender_id":27,"sender_type":"App\\Models\\User","recipient_id":15,"recipient_type":"App\\Models\\User","status":1,"created_at":"2017-04-20 10:01:44","updated_at":"2017-04-20 10:02:10"},"profile":{"name":"Dorris Jakubowski IV","weight":"109.21","height":"176.66","gender":"M","dob":"1993-08-28","biceps":"8.62","shoulders":"45.91","gym_name":"Adams-Smith","avatar":"uploads\/avatars\/M6pYujXszsU3axr6X4IvO73ZrrEF9S18BWPxqsCy.jpeg","ethnicity":207623,"latitude":"74.51276300","longitude":"-154.56846400","description":"WILL do next! As for pulling me out of the leaves: 'I should think you'll feel it a minute or two, she made out what it meant till now.' 'If that's all you know what they're like.' 'I believe so,'."}}})
     * })
     */
    public function show($id)
    {
        $login_user = Auth::user();
        if ($id == 'me') {
            $id = $login_user->id;
        }
        $user = User::with('profile')->find($id);
        if ($id != $login_user->id) {
            $user->friendship = $login_user->getFriendship($user);
        }
        return $user;
    }

    /**
     * Show My Account info
     *
     * @Get("/me")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={ "user": { "id": 1, "username": "user1", "email": "user1@mailinator.com", "created_at": "2017-04-04 11:19:11", "profile": { "name": null, "weight": null, "height": null, "gender": null, "dob": null, "biceps": null, "shoulders": null, "gym_name": null, "avatar": null, "ethnicity": null, "latitude": null, "longitude": null, "description": null } } })
     * })
     */
    public function me($id)
    {
        
    }

    /**
     * Update My Profile Information
     *
     * @Post("/me")
     * 
     * @Parameters({
     *      @Parameter("name", description="Customer Name"),
     *      @Parameter("weight", type="decimal"),
     *      @Parameter("height", type="decimal"),
     *      @Parameter("gender", description="Gender is M/F"),
     *      @Parameter("dob", type="date", description="format is Y-m-d like 1985-12-12"),
     *      @Parameter("biceps", type="decimal", description="Vehicle Street Name"),
     *      @Parameter("shoulders", type="decimal", description="Vehicle Postal Code"),
     *      @Parameter("gym_name"),
     *      @Parameter("ethnicity"),
     *      @Parameter("latitude", type="decimal"),
     *      @Parameter("longitude", type="decimal"),
     *      @Parameter("description")
     * })
     * 
     * @Transaction({
     *      @Request({ "name": "User One", "weight": 111.60, "height": 169.60, "gender": "M", "dob": "1989-05-27", "biceps": 13.4, "shoulders": 16.5, "gym_name": "Best Gym", "avatar": null, "ethnicity": null, "latitude": null, "longitude": null, "description": "I am professioal Builder" }, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={ "user": { "id": 1, "username": null, "email": null, "created_at": "2017-04-04 11:19:11", "profile": { "name": null, "weight": 111.6, "height": 169.6, "gender": "M", "dob": "1989-05-27", "biceps": null, "shoulders": null, "gym_name": "Best Gym", "avatar": null, "ethnicity": null, "latitude": null, "longitude": null, "description": "I am professional Builder" } } }),
     *      @Response(422, body={ "message": "Could not update user profile information.", "errors": { "dob": { "The dob is not a valid date." }, "gender": { "The selected gender is invalid." } }, "status_code": 422, })
     * })
     */
    public function update(Request $request, $id)
    {
        if ($id == 'me' || Auth::user()->isAdmin()) {
            $id = Auth::user()->id;
        }
        $user = User::with('profile')->findOrFail($id);
        $profile = $user->profile;
//        $user_data = $request->only('email', 'username');
//        $user->fill($user_data);
        $profile_data = $request->only('weight', 'height', 'gender', 'dob', 'gym_name', 'latitude', 'longitude', 'description');
        $profile->fill($profile_data);
//        $errors = [];
        if ($profile->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update user profile information.', $profile->getErrors());
//            $errors = $profile->getErrors();
        }
//        if ($user->isInvalid()) {
//            $errors = array_merge($user->getErrors(), $errors);
//        }
//        if ($errors) {
//            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update user profile information.', $errors);
//        }
        return $user;
    }

    /**
     * Send Password Reset Code
     *
     * @Post("/send-password-reset-code")
     * 
     * @Parameters({
     *      @Parameter("email",  description="Email for code", required=true)
     * })
     * 
     * @Transaction({
     *      @Request({"email":"user@mailinator.om"}),
     *      @Response(200),
     *      @Response(422, body={"message": "Could not send reset password email.", "errors": {"email": {"Email does not exists."}}, "status_code": 422,}),
     *      @Response(422, body={"message":"Could not send reset password email.","status_code":422})
     * })
     */
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

    /**
     * Reset Customer password 
     *
     * @Post("/reset-password")
     * 
     * @Parameters({
     *      @Parameter("email", description="Email for code", required=true),
     *      @Parameter("token", description="4 digits code", required=true),
     *      @Parameter("password", description="4 digits password", required=true)
     * })
     * 
     * @Transaction({
     *      @Request({"email":"user1@mailinator.com", "token": 3646, "password":1234, "confirm_password": 1234}),
     *      @Response(200, body={"user": { "email": "user1@mailinator.com", "name": "Customer One", "plate_number": "KBP-2440", "telephone_number": 123456789, "user_type": 3, "updated_at": "2016-12-13 08:15:30", "created_at": "2016-12-01 06:16:52", "confirm_password": 1234, "id": "583fc0547d2ae705f534d4b1" }}),
     *      @Response(422, body={"message": "Could not update user password.", "errors": {"email": {"Email does not exists."}},"status_code":422}),
     *      @Response(422, body={"message": "Could not update user password.", "errors": {"token": {"Code does not match."}},"status_code":422}),
     *      @Response(422, body={"message": "Could not update user password.", "errors": {"password": {"The password field is required."}},"status_code":422}),
     *      @Response(422, body={"message": "Could not send reset password email.","status_code":422})
     * })
     */
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
