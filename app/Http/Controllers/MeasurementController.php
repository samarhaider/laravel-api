<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Measurement;
use Auth;

/**
 * @Resource("Measurements", uri="/measurements" )
 */
class MeasurementController extends Controller
{
//
//    /**
//     * List of Measurements
//     *  
//     * @Get("/")
//     * 
//     * @Transaction({
//     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
//     *      @Response(200, body={"total":1,"per_page":20,"current_page":1,"last_page":1,"next_page_url":null,"prev_page_url":null,"from":1,"to":1,"data":{{"id":"074201ab-aeb6-4c45-b6e4-a9a4ac70019c","client_id":"a1270b4d-b898-441b-b2c3-c431a021a186","bmi":"14.02","bmr":"50.00","body_fat":"14.00","calf":"15.00","chest":"15.00","height":"15.00","shoulders":"15.00","thigh":"15.00","upper_arm":"15.00","waist":"15.00","weight":"180.00","goals":null,"notes":null,"measurement_date":"2017-05-15 00:00:00","deleted_at":null,"created_at":"2017-05-13 10:25:45","updated_at":"2017-05-13 10:25:45"}}})
//     * })
//     */
    public function index()
    {
        $measurements = Measurement::latest()->paginate(20);
        return $measurements;
    }

    /**
     * List of Measurements of Client
     *  
     * @Get("/client/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"total":1,"per_page":20,"current_page":1,"last_page":1,"next_page_url":null,"prev_page_url":null,"from":1,"to":1,"data":{{"id":"074201ab-aeb6-4c45-b6e4-a9a4ac70019c","client_id":"a1270b4d-b898-441b-b2c3-c431a021a186","bmi":"14.02","bmr":"50.00","body_fat":"14.00","calf":"15.00","chest":"15.00","height":"15.00","shoulders":"15.00","thigh":"15.00","upper_arm":"15.00","waist":"15.00","weight":"180.00","goals":null,"notes":null,"measurement_date":"2017-05-15 00:00:00","deleted_at":null,"created_at":"2017-05-13 10:25:45","updated_at":"2017-05-13 10:25:45"}}})
     * })
     */
    public function clientMeasurement($id)
    {
        $measurements = Measurement::findClient($id)->latest()->paginate(20);
        return $measurements;
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
     * Add Measurement
     *
     * @Post("/")
     * 
     * @Parameters({
     *      @Parameter("client_id", required=true),
     *      @Parameter("bmi", type="float", required=true),
     *      @Parameter("bmr", type="float", required=true),
     *      @Parameter("body_fat", type="float", required=true),
     *      @Parameter("calf", type="float", required=true),
     *      @Parameter("chest", type="float", required=true),
     *      @Parameter("height", type="float", required=true),
     *      @Parameter("shoulders", type="float", required=true),
     *      @Parameter("thigh", type="float", required=true),
     *      @Parameter("upper_arm", type="float", required=true),
     *      @Parameter("waist", type="float", required=true),
     *      @Parameter("weight", type="float", required=true),
     *      @Parameter("measurement_date", type="date", description="date format is Y-m-d", required=true)
     * })
     * 
     * @Transaction({
     *      @Request({"client_id":  "a1270b4d-b898-441b-b2c3-c431a021a186", "bmi": 14.02, "bmr": 50, "body_fat":14.0,"calf":15,"chest":15,"height":15,"shoulders":15,"thigh":15,"upper_arm":15,"waist":15,"weight":180, "measurement_date": "2017-05-15"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"measurement":{"client_id":"a1270b4d-b898-441b-b2c3-c431a021a186","bmi":14.02,"bmr":50,"body_fat":14,"calf":15,"chest":15,"height":15,"shoulders":15,"thigh":15,"upper_arm":15,"waist":15,"weight":180,"measurement_date":"2017-05-15 00:00:00","id":"074201ab-aeb6-4c45-b6e4-a9a4ac70019c","updated_at":"2017-05-13 10:25:45","created_at":"2017-05-13 10:25:45"}}),
     *      @Response(422, body={"message":"Could not add measurement information.","errors":{"bmi":{"The bmi field is required."},"bmr":{"The bmr field is required."},"body_fat":{"The body fat field is required."},"calf":{"The calf field is required."},"chest":{"The chest field is required."},"height":{"The height field is required."},"shoulders":{"The shoulders field is required."},"thigh":{"The thigh field is required."},"upper_arm":{"The upper arm field is required."},"waist":{"The waist field is required."},"weight":{"The weight field is required."},"measurement_date":{"The measurement date field is required."}},"status_code":422})
     * })
     * 
     */
    public function store(Request $request)
    {
        $measurement = new Measurement($request->all());
        if ($measurement->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not add measurement information.', $measurement->getErrors());
        }
        $measurement->user_id = Auth::user()->id;
        $measurement->save();
        return $measurement;
    }

    /**
     * Show Measurement Details
     *
     * @Get("/")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"measurement":{"client_id":"a1270b4d-b898-441b-b2c3-c431a021a186","bmi":14.02,"bmr":50,"body_fat":14,"calf":15,"chest":15,"height":15,"shoulders":15,"thigh":15,"upper_arm":15,"waist":15,"weight":180,"measurement_date":"2017-05-15 00:00:00","id":"074201ab-aeb6-4c45-b6e4-a9a4ac70019c","updated_at":"2017-05-13 10:25:45","created_at":"2017-05-13 10:25:45"}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Measurement] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function show($id)
    {
        $measurement = Measurement::findOrFail($id);
//        $measurement = Measurement::with('client')->findOrFail($id);
        return $measurement;
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
     * Update Measurement
     *
     * @Put("/{id}")
     * 
     * @Parameters({
     *      @Parameter("client_id", required=true),
     *      @Parameter("bmi", type="float", required=true),
     *      @Parameter("bmr", type="float", required=true),
     *      @Parameter("body_fat", type="float", required=true),
     *      @Parameter("calf", type="float", required=true),
     *      @Parameter("chest", type="float", required=true),
     *      @Parameter("height", type="float", required=true),
     *      @Parameter("shoulders", type="float", required=true),
     *      @Parameter("thigh", type="float", required=true),
     *      @Parameter("upper_arm", type="float", required=true),
     *      @Parameter("waist", type="float", required=true),
     *      @Parameter("weight", type="float", required=true),
     *      @Parameter("measurement_date", type="date", description="date format is Y-m-d", required=true)
     * })
     * 
     * @Transaction({
     *      @Request({"client_id":  "a1270b4d-b898-441b-b2c3-c431a021a186", "bmi": 14.02, "bmr": 50, "body_fat":14.0,"calf":15,"chest":15,"height":15,"shoulders":15,"thigh":15,"upper_arm":15,"waist":15,"weight":180, "measurement_date": "2017-05-15"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"measurement":{"client_id":"a1270b4d-b898-441b-b2c3-c431a021a186","bmi":14.02,"bmr":50,"body_fat":14,"calf":15,"chest":15,"height":15,"shoulders":15,"thigh":15,"upper_arm":15,"waist":15,"weight":180,"measurement_date":"2017-05-15 00:00:00","id":"074201ab-aeb6-4c45-b6e4-a9a4ac70019c","updated_at":"2017-05-13 10:25:45","created_at":"2017-05-13 10:25:45"}}),
     *      @Response(422, body={"message":"Could not add measurement information.","errors":{"bmi":{"The bmi field is required."},"bmr":{"The bmr field is required."},"body_fat":{"The body fat field is required."},"calf":{"The calf field is required."},"chest":{"The chest field is required."},"height":{"The height field is required."},"shoulders":{"The shoulders field is required."},"thigh":{"The thigh field is required."},"upper_arm":{"The upper arm field is required."},"waist":{"The waist field is required."},"weight":{"The weight field is required."},"measurement_date":{"The measurement date field is required."}},"status_code":422}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Measurement] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function update(Request $request, $id)
    {
        $measurement = Measurement::findOrFail($id);
        $measurement->fill($request->all());
        if ($measurement->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update measurement information.', $measurement->getErrors());
        }
        $measurement->save();
        return $measurement;
    }

    /**
     * Delete Measurement
     *
     * @Delete("/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"measurement":{"client_id":"a1270b4d-b898-441b-b2c3-c431a021a186","bmi":14.02,"bmr":50,"body_fat":14,"calf":15,"chest":15,"height":15,"shoulders":15,"thigh":15,"upper_arm":15,"waist":15,"weight":180,"measurement_date":"2017-05-15 00:00:00","id":"074201ab-aeb6-4c45-b6e4-a9a4ac70019c","updated_at":"2017-05-13 10:25:45","created_at":"2017-05-13 10:25:45"}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Measurement] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function destroy($id)
    {
        $measurement = Measurement::findOrFail($id);
        $measurement->delete();
        return $measurement;
    }
}
