<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Auth;

/**
 * @Resource("Payments", uri="/payments" )
 */
class PaymentController extends Controller
{

    /**
     * List of Payments
     *  
     * @Get("/")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"total":2,"per_page":20,"current_page":1,"last_page":1,"next_page_url":null,"prev_page_url":null,"from":1,"to":2,"data":{{"id":"62ed8907-c898-468d-8416-90e92759503d","client_id":"a1270b4d-b898-441b-b2c3-c431a021a186","client_data":"Payment 2","description":null,"amount":"50.00","payment_date":"2017-05-15 00:00:00","deleted_at":null,"created_at":"2017-05-13 07:43:51","updated_at":"2017-05-13 07:43:51"},{"id":"f25a568f-f12e-4b23-aad6-4d4cb3a4eedb","client_id":"d6721c82-713e-4255-8781-80f6dd82b346","client_data":"This is cover letter","description":null,"amount":"50.00","payment_date":"2017-05-15 00:00:00","deleted_at":null,"created_at":"2017-05-13 07:40:16","updated_at":"2017-05-13 07:40:16"}}})
     * })
     */
    public function index()
    {
        $payments = Payment::latest()->paginate(20);
        return $payments;
    }

    /**
     * List of Payments of Client
     *  
     * @Get("/client/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"total":2,"per_page":20,"current_page":1,"last_page":1,"next_page_url":null,"prev_page_url":null,"from":1,"to":2,"data":{{"id":"62ed8907-c898-468d-8416-90e92759503d","client_id":"a1270b4d-b898-441b-b2c3-c431a021a186","client_data":"Payment 2","description":null,"amount":"50.00","payment_date":"2017-05-15 00:00:00","deleted_at":null,"created_at":"2017-05-13 07:43:51","updated_at":"2017-05-13 07:43:51"},{"id":"f25a568f-f12e-4b23-aad6-4d4cb3a4eedb","client_id":"d6721c82-713e-4255-8781-80f6dd82b346","client_data":"This is cover letter","description":null,"amount":"50.00","payment_date":"2017-05-15 00:00:00","deleted_at":null,"created_at":"2017-05-13 07:40:16","updated_at":"2017-05-13 07:40:16"}}})
     * })
     */
    public function clientPayment($id)
    {
        $payments = Payment::findClient($id)->latest()->paginate(20);
        return $payments;
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
     * Add Payment
     *
     * @Post("/")
     * 
     * @Parameters({
     *      @Parameter("client_id", required=true),
     *      @Parameter("client_data", type="float", required=true),
     *      @Parameter("payment_date", type="date", description="date format is Y-m-d", required=true),
     *      @Parameter("amount", type="float", required=true)
     * })
     * 
     * @Transaction({
     *      @Request({"client_id":  "d6721c82-713e-4255-8781-80f6dd82b346", "client_data": "This is cover letter", "amount": 50, "payment_date": "2017-05-15"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"payment":{"client_id":"d6721c82-713e-4255-8781-80f6dd82b346","client_data":"This is cover letter","amount":50,"payment_date":"2017-05-15 00:00:00","id":"f25a568f-f12e-4b23-aad6-4d4cb3a4eedb","updated_at":"2017-05-13 07:40:16","created_at":"2017-05-13 07:40:16"}}),
     *      @Response(422, body={"message":"Could not add payment information.","errors":{"client_id":{"The client id field is required."},"client_data":{"The client data field is required."},"amount":{"The amount field is required."},"payment_date":{"The payment date field is required."}},"status_code":422})
     * })
     * 
     */
    public function store(Request $request)
    {
        $payment = new Payment($request->all());
        if ($payment->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not add payment information.', $payment->getErrors());
        }
        $payment->user_id = Auth::user()->id;
        $payment->save();
        return $payment;
    }

    /**
     * Show Payment Details
     *
     * @Get("/")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"payment":{"client_id":"d6721c82-713e-4255-8781-80f6dd82b346","client_data":"This is cover letter","amount":50,"payment_date":"2017-05-15 00:00:00","id":"f25a568f-f12e-4b23-aad6-4d4cb3a4eedb","updated_at":"2017-05-13 07:40:16","created_at":"2017-05-13 07:40:16"}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Payment] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return $payment;
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
     * Update Payment
     *
     * @Put("/{id}")
     * 
     * @Parameters({
     *      @Parameter("client_id", required=true),
     *      @Parameter("client_data", type="float", required=true),
     *      @Parameter("payment_date", type="date", description="date format is Y-m-d", required=true),
     *      @Parameter("amount", type="float", required=true)
     * })
     * 
     * @Transaction({
     *      @Request({"client_data": "This is cover letter", "amount": 50, "payment_date": "2017-05-15"}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"payment":{"client_id":"d6721c82-713e-4255-8781-80f6dd82b346","client_data":"This is cover letter","amount":50,"payment_date":"2017-05-15 00:00:00","id":"f25a568f-f12e-4b23-aad6-4d4cb3a4eedb","updated_at":"2017-05-13 07:40:16","created_at":"2017-05-13 07:40:16"}}),
     *      @Response(422, body={"message":"Could not add payment information.","errors":{"client_id":{"The client id field is required."},"client_data":{"The client data field is required."},"amount":{"The amount field is required."},"payment_date":{"The payment date field is required."}},"status_code":422}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Payment] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->fill($request->all());
        if ($payment->isInvalid()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not update payment information.', $payment->getErrors());
        }
        $payment->save();
        return $payment;
    }

    /**
     * Delete Payment
     *
     * @Delete("/{id}")
     * 
     * @Transaction({
     *      @Request({}, headers={"Authorization": "Bearer {token}"}),
     *      @Response(200, body={"payment":{"client_id":"d6721c82-713e-4255-8781-80f6dd82b346","client_data":"This is cover letter","amount":50,"payment_date":"2017-05-15 00:00:00","id":"f25a568f-f12e-4b23-aad6-4d4cb3a4eedb","updated_at":"2017-05-13 07:40:16","created_at":"2017-05-13 07:40:16"}}),
     *      @Response(500, body={"message":"No query results for model [App\\Models\\Payment] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1","status_code":500})
     * })
     * 
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return $payment;
    }
}
