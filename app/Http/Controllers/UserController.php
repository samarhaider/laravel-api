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

    /**
     * Users List
     *
     * @Get("/")
     * 
     * @Transaction({
     *      @Response(200, body={"total":10,"per_page":20,"current_page":1,"last_page":10,"next_page_url":"http:\/\/localhost:8000\/api\/users?page=2","prev_page_url":null,"from":1,"to":1,"data":{{"id":"0b2db6ac-e596-4981-b39a-2cbfafc996ea","username":"betty.rath","email":"elmo.wiegand@example.net","avatar":"http:\/\/lorempixel.com\/640\/480\/?30446","firstname":"Madison","surname":"Ortiz","created_at":"2017-05-12 10:43:35"}}})
     * })
     * 
     */
    public function index(Request $request)
    {
        $users = User::latest()->paginate(20);
        return $users;
    }

//
//    /**
//     * Register User
//     *
//     * @Post("/register")
//     * 
//     * @Parameters({
//     *      @Parameter("username",  description="Username should be unique", required=true),
//     *      @Parameter("email", type="email",  description="Email should be unique", required=true),
//     *      @Parameter("password",  description="User Password", required=true),
//     *      @Parameter("name", description="Full Name of user")
//     * })
//     * 
//     * @Transaction({
//     *      @Request({"username": "user2", "email": "user2@mailinator.com", "password": "123456", "name": "User Two"}),
//     *      @Response(200, body={ "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2dhbmdzdGVyLXN0cmVuZ3RoLmxvY2FsLmNvbVwvYXBpXC91c2Vyc1wvcmVnaXN0ZXIiLCJpYXQiOjE0OTEzMDQ4NjQsImV4cCI6MTQ5MTMwODQ2NCwibmJmIjoxNDkxMzA0ODY0LCJqdGkiOiIxYzA0ZDMxNDk5NWQ5ZWJlYWE1Yzk0MTdkYzQ5MzA4NiJ9.R2OMlFOwPzqtrgIgoZpF9VAH1Zm0BnLYMt2PzTR8LUk", "user": { "username": "user2", "email": "user2@mailinator.com", "created_at": "2017-04-04 11:21:03", "id": 2,"profile":{"name":"User Two","weight":null,"height":null,"gender":null,"dob":null,"biceps":null,"shoulders":null,"gym_name":null,"avatar":null,"ethnicity":null,"latitude":null,"longitude":null,"description":null} } }),
//     *      @Response(422, body={"message":"Could not add new user.","errors":{"email":{"The email field is required."}, "username":{"The username field is required."}, "password": {"The password field is required."}},"status_code":422})
//     * })
//     */
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
     * Show User Details
     *
     * @Get("/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"user":{"id":"0b2db6ac-e596-4981-b39a-2cbfafc996ea","username":"betty.rath","email":"elmo.wiegand@example.net","avatar":"http:\/\/lorempixel.com\/640\/480\/?30446","firstname":"Madison","surname":"Ortiz","created_at":"2017-05-12 10:43:35"}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\User] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500}),
     * })
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    /**
     * Update User Information
     *
     * @Put("/{id}")
     * 
     * @Parameters({
     *      @Parameter("username"),
     *      @Parameter("email"),
     *      @Parameter("surname"),
     *      @Parameter("firstname")
     * })
     * 
     * @Transaction({
     *      @Request({"username":"betty.rath","email":"elmo.wiegand@example.net","firstname":"Madison","surname":"Ortiz"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"user":{"id":"0b2db6ac-e596-4981-b39a-2cbfafc996ea","username":"betty.rath","email":"elmo.wiegand@example.net","avatar":"http:\/\/lorempixel.com\/640\/480\/?30446","firstname":"Madison","surname":"Ortiz","created_at":"2017-05-12 10:43:35"}}),
     *      @Response(422, body={"message":"Could not update user information.","errors":{"email":{"The email has already been taken."}},"status_code":422})
     * })
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->fill($request->all());
        if ($user->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update user information.', $user->getErrors());
        }
        $user->save();
        return $user;
    }

    /**
     * Delete User
     *
     * @Delete("/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"user":{"id":"0b2db6ac-e596-4981-b39a-2cbfafc996ea","username":"betty.rath","email":"elmo.wiegand@example.net","avatar":"http:\/\/lorempixel.com\/640\/480\/?30446","firstname":"Madison","surname":"Ortiz","created_at":"2017-05-12 10:43:35"}}),
     * })
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }

}
