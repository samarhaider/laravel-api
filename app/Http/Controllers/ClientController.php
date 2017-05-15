<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Hash;
use Auth;

/**
 * @Resource("Clients", uri="/clients" )
 */
class ClientController extends Controller
{

    /**
     * List of Clients
     *  
     * @Get("/")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"total":10,"per_page":20,"current_page":1,"last_page":10,"next_page_url":"http:\/\/localhost:8000\/api\/clients?page=2","prev_page_url":null,"from":1,"to":1,"data":{{"id":"08dcf275-e2be-4e6a-a977-e722c59b7526","username":"coreilly","email":"kaia.bayer@example.com","avatar":"http:\/\/lorempixel.com\/640\/480\/?44392","firstname":"Ludie","surname":"Pfannerstill","address":"76920 Verner Underpass\nLake Jannieton, AZ 19549-3541","gender":"male","dob":"1989-03-11","mobile":"292.300.8518 x37716","landline":"+1 (506) 201-8955","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44"}}})
     * })
     */
    public function index()
    {
        $clients = Client::latest()->paginate(20);
        return $clients;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Add Client
     *
     * @Post("/{id}")
     * 
     * @Parameters({
     *      @Parameter("username", required=true),
     *      @Parameter("email", required=true),
     *      @Parameter("password", required=true),
     *      @Parameter("surname"),
     *      @Parameter("firstname"),
     *      @Parameter("address"),
     *      @Parameter("gender", description="Its value is either male or female"),
     *      @Parameter("dob", description="format is Y-m-d"),
     *      @Parameter("mobile"),
     *      @Parameter("landline"),
     *      @Parameter("emergency_contact_name"),
     *      @Parameter("emergency_contact_relationship"),
     *      @Parameter("emergency_contact_number"),
     *      @Parameter("contraindications"),
     *      @Parameter("notes")
     * })
     * 
     * @Transaction({
     *      @Request({"username":"betty.rath","password":"123456","email":"elmo.wiegand@example.net","firstname":"Madison","surname":"Ortiz"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"client":{"id":"08dcf275-e2be-4e6a-a977-e722c59b7526","username":"coreilly","email":"kaia.bayer@example.com","avatar":"http:\/\/lorempixel.com\/640\/480\/?44392","firstname":"Ludie","surname":"Pfannerstill","address":"76920 Verner Underpass\nLake Jannieton, AZ 19549-3541","gender":"male","dob":"1989-03-11","mobile":"292.300.8518 x37716","landline":"+1 (506) 201-8955","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44"}}),
     *      @Response(422, body={"message":"Could not update user information.","errors":{"email":{"The email has already been taken."}},"status_code":422})
     * })
     * 
     */
    public function store(Request $request)
    {
        $client = new Client($request->all());
        $client->password = Hash::make(123456);
        if ($client->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not add client information.', $client->getErrors());
        }
        $client->user_id = Auth::user()->id;
        $client->save();
        return $client;
    }

    /**
     * Show Client Details
     *
     * @Get("/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"client":{"id":"08dcf275-e2be-4e6a-a977-e722c59b7526","username":"coreilly","email":"kaia.bayer@example.com","avatar":"http:\/\/lorempixel.com\/640\/480\/?44392","firstname":"Ludie","surname":"Pfannerstill","address":"76920 Verner Underpass\nLake Jannieton, AZ 19549-3541","gender":"male","dob":"1989-03-11","mobile":"292.300.8518 x37716","landline":"+1 (506) 201-8955","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44"}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Client] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return $client;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update Client Details
     *
     * @Put("/{id}")
     * 
     * @Parameters({
     *      @Parameter("username", required=true),
     *      @Parameter("email", required=true),
     *      @Parameter("surname"),
     *      @Parameter("firstname"),
     *      @Parameter("address"),
     *      @Parameter("gender", description="Its value is either male or female"),
     *      @Parameter("dob", description="format is Y-m-d"),
     *      @Parameter("mobile"),
     *      @Parameter("landline"),
     *      @Parameter("emergency_contact_name"),
     *      @Parameter("emergency_contact_relationship"),
     *      @Parameter("emergency_contact_number"),
     *      @Parameter("contraindications"),
     *      @Parameter("notes")
     * })
     * 
     * @Transaction({
     *      @Request({"username":"betty.rath","email":"elmo.wiegand@example.net","firstname":"Madison","surname":"Ortiz"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"client":{"id":"08dcf275-e2be-4e6a-a977-e722c59b7526","username":"coreilly","email":"kaia.bayer@example.com","avatar":"http:\/\/lorempixel.com\/640\/480\/?44392","firstname":"Ludie","surname":"Pfannerstill","address":"76920 Verner Underpass\nLake Jannieton, AZ 19549-3541","gender":"male","dob":"1989-03-11","mobile":"292.300.8518 x37716","landline":"+1 (506) 201-8955","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44"}}),
     *      @Response(422, body={"message":"Could not update user information.","errors":{"email":{"The email has already been taken."}},"status_code":422})
     * })
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->fill($request->all());
        if ($client->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update client information.', $client->getErrors());
        }
        $client->save();
        return $client;
    }

    /**
     * Delete Client
     *
     * @Delete("/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"client":{"id":"08dcf275-e2be-4e6a-a977-e722c59b7526","username":"coreilly","email":"kaia.bayer@example.com","avatar":"http:\/\/lorempixel.com\/640\/480\/?44392","firstname":"Ludie","surname":"Pfannerstill","address":"76920 Verner Underpass\nLake Jannieton, AZ 19549-3541","gender":"male","dob":"1989-03-11","mobile":"292.300.8518 x37716","landline":"+1 (506) 201-8955","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44"}})
     * })
     * 
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return $client;
    }
}
