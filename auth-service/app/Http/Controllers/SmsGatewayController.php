<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/** Route all sms request to sms service */

class SmsGatewayController extends Controller
{
public function send(Request $request)
{
    //send to sms service here

    //return success response

    return $this->successResponse(200,[
        'message'=>'Your Messages on its way'
    ]);
}

}
