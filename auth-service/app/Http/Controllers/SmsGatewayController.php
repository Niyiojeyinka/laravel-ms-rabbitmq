<?php

namespace App\Http\Controllers;

use App\Jobs\NewMessagesJob;
use Illuminate\Http\Request;

/** Route all sms request to sms service */

class SmsGatewayController extends Controller
{
public function send(Request $request)
{
    $payload = json_decode($request->getContent());
    //send to sms service here
    //return success response
      if  (count($payload->messages) < 2000 ){
    NewMessagesJob::dispatch($payload->messages)->onQueue("low");
      }else{
            NewMessagesJob::dispatch($payload->messages)->onQueue("high");
      }
    return $this->successResponse(200,[
        'message'=>'Your Messages on its way',
        'messages'=>$payload->messages
    ]);
}

}
