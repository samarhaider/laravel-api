<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionType;
use Auth;

/**
 * @Resource("SessionTypes", uri="/session_types" )
 */
class SessionTypeController extends Controller
{

    /**
     * List of SessionTypes
     *  
     * @Get("/")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"total":10,"per_page":1,"current_page":1,"last_page":10,"next_page_url":"http:\/\/localhost:8000\/api\/session-types?page=2","prev_page_url":null,"from":1,"to":1,"data":{{"id":"0ae48790-92de-4576-bb42-dcd4c24b00c1","name":"Hester","duration":"50.89","duration_unit":"minute","price":"95.70","payable_per_duration":true,"payable_per_person":true,"deactivated":false,"limited_to":"7","deleted_at":null,"created_at":"2017-05-12 10:43:49","updated_at":"2017-05-12 10:43:49"}}})
     * })
     * 
     */
    public function index()
    {
        $session_types = SessionType::latest()->paginate(20);
        return $session_types;
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
     * Add Session Type
     *
     * @Post("/")
     * 
     * @Parameters({
     *      @Parameter("name", required=true),
     *      @Parameter("duration", type="float", required=true),
     *      @Parameter("duration_unit", required=true),
     *      @Parameter("price", type="float", required=true),
     *      @Parameter("payable_per_duration", type="boolean", required=true),
     *      @Parameter("payable_per_person", type="boolean", required=true),
     *      @Parameter("deactivated", type="boolean", required=true),
     *      @Parameter("limited_to", type="integer", required=true)
     * })
     * 
     * @Transaction({
     *      @Request({"name":"Hester","duration":"50.89","duration_unit":"minute","price":"95.70","payable_per_duration":true,"payable_per_person":true,"deactivated":false,"limited_to":"7"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"session_type":{"id":"0ae48790-92de-4576-bb42-dcd4c24b00c1","name":"Hester","duration":"50.89","duration_unit":"minute","price":"95.70","payable_per_duration":true,"payable_per_person":true,"deactivated":false,"limited_to":"7","deleted_at":null,"created_at":"2017-05-12 10:43:49","updated_at":"2017-05-12 10:43:49"}}),
     *      @Response(422, body={"message":"Could not add session type information.","errors":{"name":{"The name field is required."},"duration":{"The duration field is required."},"duration_unit":{"The duration unit field is required."},"price":{"The price field is required."},"payable_per_duration":{"The payable per duration field is required."},"payable_per_person":{"The payable per person field is required."},"deactivated":{"The deactivated field is required."},"limited_to":{"The limited to field is required."}},"status_code":422})
     * })
     * 
     */
    public function store(Request $request)
    {
        $session_type = new SessionType($request->all());
        if ($session_type->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not add session type information.', $session_type->getErrors());
        }
        $session_type->user_id = Auth::user()->id;
        $session_type->save();
        return $session_type;
    }

    /**
     * Show Session Type
     *
     * @Get("/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"session_type":{"id":"0ae48790-92de-4576-bb42-dcd4c24b00c1","name":"Hester","duration":"50.89","duration_unit":"minute","price":"95.70","payable_per_duration":true,"payable_per_person":true,"deactivated":false,"limited_to":"7","deleted_at":null,"created_at":"2017-05-12 10:43:49","updated_at":"2017-05-12 10:43:49"}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\SessionType] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function show($id)
    {
        $session_type = SessionType::findOrFail($id);
        return $session_type;
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
     * Add Session Type
     *
     * @Put("/{id}")
     * 
     * @Parameters({
     *      @Parameter("name", required=true),
     *      @Parameter("duration", type="float", required=true),
     *      @Parameter("duration_unit", required=true),
     *      @Parameter("price", type="float", required=true),
     *      @Parameter("payable_per_duration", type="boolean", required=true),
     *      @Parameter("payable_per_person", type="boolean", required=true),
     *      @Parameter("deactivated", type="boolean", required=true),
     *      @Parameter("limited_to", type="integer", required=true)
     * })
     * 
     * @Transaction({
     *      @Request({"name":"Hester","duration":"50.89","duration_unit":"minute","price":"95.70","payable_per_duration":true,"payable_per_person":true,"deactivated":false,"limited_to":"7"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"session_type":{"id":"0ae48790-92de-4576-bb42-dcd4c24b00c1","name":"Hester","duration":"50.89","duration_unit":"minute","price":"95.70","payable_per_duration":true,"payable_per_person":true,"deactivated":false,"limited_to":"7","deleted_at":null,"created_at":"2017-05-12 10:43:49","updated_at":"2017-05-12 10:43:49"}}),
     *      @Response(422, body={"message":"Could not add session type information.","errors":{"name":{"The name field is required."},"duration":{"The duration field is required."},"duration_unit":{"The duration unit field is required."},"price":{"The price field is required."},"payable_per_duration":{"The payable per duration field is required."},"payable_per_person":{"The payable per person field is required."},"deactivated":{"The deactivated field is required."},"limited_to":{"The limited to field is required."}},"status_code":422}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\SessionType] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function update(Request $request, $id)
    {
        $session_type = SessionType::findOrFail($id);
        $session_type->fill($request->all());
        if ($session_type->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update session_type information.', $session_type->getErrors());
        }
        $session_type->save();
        return $session_type;
    }

    /**
     * Delete Session Type
     *
     * @Delete("/{id}")
     * 
     * @Transaction({
     *      @Response(200, body={"session_type":{"id":"0ae48790-92de-4576-bb42-dcd4c24b00c1","name":"Hester","duration":"50.89","duration_unit":"minute","price":"95.70","payable_per_duration":true,"payable_per_person":true,"deactivated":false,"limited_to":"7","deleted_at":null,"created_at":"2017-05-12 10:43:49","updated_at":"2017-05-12 10:43:49"}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\SessionType] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     */
    public function destroy($id)
    {
        $session_type = SessionType::findOrFail($id);
        $session_type->delete();
        return $session_type;
    }
}
