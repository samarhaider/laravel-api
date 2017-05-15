<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Client;
use Auth;

/**
 * @Resource("Bookings", uri="/bookings" )
 */
class BookingController extends Controller
{

    /**
     * List of Bookings
     *  
     * @Get("/")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"total":1,"per_page":20,"current_page":1,"last_page":1,"next_page_url":null,"prev_page_url":null,"from":1,"to":1,"data":{{"id":"abfc3482-1080-48d2-87e4-75492de8ffbd","session_type_id":"384f8c02-1702-4aec-9188-e1dc2487bc98","booking_date":"2017-05-25","start_time":"05:05:00","finish_time":"06:55:00","cancelled":false,"deleted_at":null,"created_at":"2017-05-15 05:38:47","updated_at":"2017-05-15 05:38:47","clients":{{"id":"08dcf275-e2be-4e6a-a977-e722c59b7526","username":"coreilly","email":"kaia.bayer@example.com","avatar":"http:\/\/lorempixel.com\/640\/480\/?44392","firstname":"Ludie","surname":"Pfannerstill","address":"76920 Verner Underpass\nLake Jannieton, AZ 19549-3541","gender":"male","dob":"1989-03-11","mobile":"292.300.8518 x37716","landline":"+1 (506) 201-8955","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44","pivot":{"booking_id":"abfc3482-1080-48d2-87e4-75492de8ffbd","client_id":"08dcf275-e2be-4e6a-a977-e722c59b7526","paid":"0","created_at":"2017-05-15 05:38:47","updated_at":"2017-05-15 05:38:47"}},{"id":"bf8b12ef-6352-44dd-afcd-3db8bef07678","username":"ernestine82","email":"chloe43@example.org","avatar":"http:\/\/lorempixel.com\/640\/480\/?82996","firstname":"Kiara","surname":"Johnson","address":"63820 Okuneva Mountain Apt. 080\nRaynortown, IN 42512","gender":"male","dob":"1985-12-12","mobile":"331-762-7069 x74990","landline":"480.844.9263 x62498","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44","pivot":{"booking_id":"abfc3482-1080-48d2-87e4-75492de8ffbd","client_id":"bf8b12ef-6352-44dd-afcd-3db8bef07678","paid":"0","created_at":"2017-05-15 05:38:47","updated_at":"2017-05-15 05:38:47"}}}}}})
     * })
     */
    public function index()
    {
        $bookings = Booking::with('clients')
//            ->upcomming()
            ->latest()
            ->paginate(20);
        return $bookings;
    }

    /**
     * List of Bookings of Client
     *  
     * @Get("/client/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"total":1,"per_page":20,"current_page":1,"last_page":1,"next_page_url":null,"prev_page_url":null,"from":1,"to":1,"data":{{"id":"abfc3482-1080-48d2-87e4-75492de8ffbd","session_type_id":"384f8c02-1702-4aec-9188-e1dc2487bc98","booking_date":"2017-05-25","start_time":"05:05:00","finish_time":"06:55:00","cancelled":false,"deleted_at":null,"created_at":"2017-05-15 05:38:47","updated_at":"2017-05-15 05:38:47","pivot":{"client_id":"08dcf275-e2be-4e6a-a977-e722c59b7526","booking_id":"abfc3482-1080-48d2-87e4-75492de8ffbd","paid":"0","created_at":"2017-05-15 05:38:47","updated_at":"2017-05-15 05:38:47"}}}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Client] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     */
    public function clientBooking($id)
    {
        $client = Client::findOrFail($id);
        return $client->bookings()
//            ->upcomming()
                ->latest()
                ->paginate(20);
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
     * Add Booking
     *
     * @Post("/")
     * 
     * @Parameters({
     *      @Parameter("clients", type="array", description="Ids of client", required=true),
     *      @Parameter("session_type_id", required=true),
     *      @Parameter("booking_date", type="date", description="Format is Y-m-d", required=true),
     *      @Parameter("start_time", type="time", description="Format is H:i", required=true),
     *      @Parameter("finish_time", type="time", description="Format is H:i", required=true)
     * })
     * 
     * @Transaction({
     *      @Request({"clients":  {"08dcf275-e2be-4e6a-a977-e722c59b7526", "bf8b12ef-6352-44dd-afcd-3db8bef07678"}, "session_type_id": "384f8c02-1702-4aec-9188-e1dc2487bc98", "start_time": "05:05", "finish_time": "06:55", "booking_date": "2017-05-25"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"booking":{"session_type_id":"384f8c02-1702-4aec-9188-e1dc2487bc98","start_time":"05:05","finish_time":"06:55","booking_date": "2017-05-25","cancelled":false,"id":"222e766b-c873-445e-8e49-e060ae12492a","updated_at":"2017-05-14 13:52:35","created_at":"2017-05-14 13:52:35","clients":{{"id":"08dcf275-e2be-4e6a-a977-e722c59b7526","username":"coreilly","email":"kaia.bayer@example.com","avatar":"http:\/\/lorempixel.com\/640\/480\/?44392","firstname":"Ludie","surname":"Pfannerstill","address":"76920 Verner Underpass\nLake Jannieton, AZ 19549-3541","gender":"male","dob":"1989-03-11","mobile":"292.300.8518 x37716","landline":"+1 (506) 201-8955","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44","pivot":{"booking_id":"222e766b-c873-445e-8e49-e060ae12492a","client_id":"08dcf275-e2be-4e6a-a977-e722c59b7526","paid":"0","created_at":"2017-05-14 13:52:35","updated_at":"2017-05-14 13:52:35"}},{"id":"bf8b12ef-6352-44dd-afcd-3db8bef07678","username":"ernestine82","email":"chloe43@example.org","avatar":"http:\/\/lorempixel.com\/640\/480\/?82996","firstname":"Kiara","surname":"Johnson","address":"63820 Okuneva Mountain Apt. 080\nRaynortown, IN 42512","gender":"male","dob":"1985-12-12","mobile":"331-762-7069 x74990","landline":"480.844.9263 x62498","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44","pivot":{"booking_id":"222e766b-c873-445e-8e49-e060ae12492a","client_id":"bf8b12ef-6352-44dd-afcd-3db8bef07678","paid":"0","created_at":"2017-05-14 13:52:35","updated_at":"2017-05-14 13:52:35"}}}}}),
     *      @Response(422, body={"message":"Could not add booking information.","errors":{"clients":{"The clients field is required."},"session_type_id":{"The session type id field is required."},"start_time":{"The start time field is required."},"end_time":{"The end time field is required."}},"status_code":422})
     * })
     * 
     */
    public function store(Request $request)
    {
        $booking = new Booking($request->all());
        if (!$request->get('cancelled')) {
            $booking->cancelled = false;
        }
        if ($booking->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not add booking information.', $booking->getErrors());
        }
        $booking->user_id = Auth::user()->id;
        $booking->save();
        if ($request->get('clients')) {
            $booking->clients()->sync($request->get('clients', []));
            $booking->clients;
        }
        return $booking;
    }

    /**
     * Show Booking Details
     *
     * @Get("/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"booking":{"session_type_id":"384f8c02-1702-4aec-9188-e1dc2487bc98","start_time":"05:05","finish_time":"06:55","booking_date": "2017-05-25","cancelled":false,"id":"222e766b-c873-445e-8e49-e060ae12492a","updated_at":"2017-05-14 13:52:35","created_at":"2017-05-14 13:52:35","clients":{{"id":"08dcf275-e2be-4e6a-a977-e722c59b7526","username":"coreilly","email":"kaia.bayer@example.com","avatar":"http:\/\/lorempixel.com\/640\/480\/?44392","firstname":"Ludie","surname":"Pfannerstill","address":"76920 Verner Underpass\nLake Jannieton, AZ 19549-3541","gender":"male","dob":"1989-03-11","mobile":"292.300.8518 x37716","landline":"+1 (506) 201-8955","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44","pivot":{"booking_id":"222e766b-c873-445e-8e49-e060ae12492a","client_id":"08dcf275-e2be-4e6a-a977-e722c59b7526","paid":"0","created_at":"2017-05-14 13:52:35","updated_at":"2017-05-14 13:52:35"}},{"id":"bf8b12ef-6352-44dd-afcd-3db8bef07678","username":"ernestine82","email":"chloe43@example.org","avatar":"http:\/\/lorempixel.com\/640\/480\/?82996","firstname":"Kiara","surname":"Johnson","address":"63820 Okuneva Mountain Apt. 080\nRaynortown, IN 42512","gender":"male","dob":"1985-12-12","mobile":"331-762-7069 x74990","landline":"480.844.9263 x62498","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44","pivot":{"booking_id":"222e766b-c873-445e-8e49-e060ae12492a","client_id":"bf8b12ef-6352-44dd-afcd-3db8bef07678","paid":"0","created_at":"2017-05-14 13:52:35","updated_at":"2017-05-14 13:52:35"}}}}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Booking] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->clients;
        return $booking;
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
     * Update Booking
     *
     * @Put("/{id}")
     * 
     * @Parameters({
     *      @Parameter("clients", type="array", description="Ids of client", required=true),
     *      @Parameter("session_type_id", required=true),
     *      @Parameter("booking_date", type="date", description="Format is Y-m-d", required=true),
     *      @Parameter("start_time", required=true),
     *      @Parameter("finish_time", required=true),
     *      @Parameter("cancelled",type="boolean")
     * })
     * 
     * @Transaction({
     *      @Request({"clients":  {"08dcf275-e2be-4e6a-a977-e722c59b7526", "bf8b12ef-6352-44dd-afcd-3db8bef07678"}, "session_type_id": "384f8c02-1702-4aec-9188-e1dc2487bc98", "start_time": "05:05", "finish_time": "06:55"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"booking":{"session_type_id":"384f8c02-1702-4aec-9188-e1dc2487bc98","start_time":"05:05","finish_time":"06:55","booking_date": "2017-05-25","cancelled":false,"id":"222e766b-c873-445e-8e49-e060ae12492a","updated_at":"2017-05-14 13:52:35","created_at":"2017-05-14 13:52:35","clients":{{"id":"08dcf275-e2be-4e6a-a977-e722c59b7526","username":"coreilly","email":"kaia.bayer@example.com","avatar":"http:\/\/lorempixel.com\/640\/480\/?44392","firstname":"Ludie","surname":"Pfannerstill","address":"76920 Verner Underpass\nLake Jannieton, AZ 19549-3541","gender":"male","dob":"1989-03-11","mobile":"292.300.8518 x37716","landline":"+1 (506) 201-8955","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44","pivot":{"booking_id":"222e766b-c873-445e-8e49-e060ae12492a","client_id":"08dcf275-e2be-4e6a-a977-e722c59b7526","paid":"0","created_at":"2017-05-14 13:52:35","updated_at":"2017-05-14 13:52:35"}},{"id":"bf8b12ef-6352-44dd-afcd-3db8bef07678","username":"ernestine82","email":"chloe43@example.org","avatar":"http:\/\/lorempixel.com\/640\/480\/?82996","firstname":"Kiara","surname":"Johnson","address":"63820 Okuneva Mountain Apt. 080\nRaynortown, IN 42512","gender":"male","dob":"1985-12-12","mobile":"331-762-7069 x74990","landline":"480.844.9263 x62498","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44","pivot":{"booking_id":"222e766b-c873-445e-8e49-e060ae12492a","client_id":"bf8b12ef-6352-44dd-afcd-3db8bef07678","paid":"0","created_at":"2017-05-14 13:52:35","updated_at":"2017-05-14 13:52:35"}}}}}),
     *      @Response(422, body={"message":"Could not add booking information.","errors":{"clients":{"The clients field is required."},"session_type_id":{"The session type id field is required."},"start_time":{"The start time field is required."},"end_time":{"The end time field is required."}},"status_code":422}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Booking] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->fill($request->all());
        if ($booking->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update booking information.', $booking->getErrors());
        }
        $booking->save();
        if ($request->get('clients')) {
            $booking->clients()->sync($request->get('clients', []));
            $booking->clients;
        }
        return $booking;
    }

    /**
     * Delete Booking
     *
     * @Delete("/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"booking":{"session_type_id":"384f8c02-1702-4aec-9188-e1dc2487bc98","start_time":"05:05","finish_time":"06:55","booking_date": "2017-05-25","cancelled":false,"id":"222e766b-c873-445e-8e49-e060ae12492a","updated_at":"2017-05-14 13:52:35","created_at":"2017-05-14 13:52:35","clients":{{"id":"08dcf275-e2be-4e6a-a977-e722c59b7526","username":"coreilly","email":"kaia.bayer@example.com","avatar":"http:\/\/lorempixel.com\/640\/480\/?44392","firstname":"Ludie","surname":"Pfannerstill","address":"76920 Verner Underpass\nLake Jannieton, AZ 19549-3541","gender":"male","dob":"1989-03-11","mobile":"292.300.8518 x37716","landline":"+1 (506) 201-8955","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44","pivot":{"booking_id":"222e766b-c873-445e-8e49-e060ae12492a","client_id":"08dcf275-e2be-4e6a-a977-e722c59b7526","paid":"0","created_at":"2017-05-14 13:52:35","updated_at":"2017-05-14 13:52:35"}},{"id":"bf8b12ef-6352-44dd-afcd-3db8bef07678","username":"ernestine82","email":"chloe43@example.org","avatar":"http:\/\/lorempixel.com\/640\/480\/?82996","firstname":"Kiara","surname":"Johnson","address":"63820 Okuneva Mountain Apt. 080\nRaynortown, IN 42512","gender":"male","dob":"1985-12-12","mobile":"331-762-7069 x74990","landline":"480.844.9263 x62498","emergency_contact_name":null,"emergency_contact_relationship":null,"emergency_contact_number":null,"contraindications":null,"notes":null,"created_at":"2017-05-12 10:43:44","pivot":{"booking_id":"222e766b-c873-445e-8e49-e060ae12492a","client_id":"bf8b12ef-6352-44dd-afcd-3db8bef07678","paid":"0","created_at":"2017-05-14 13:52:35","updated_at":"2017-05-14 13:52:35"}}}}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Booking] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->clients;
        $booking->delete();
        return $booking;
    }
}
