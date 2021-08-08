<?php

namespace App\Customs;

trait Responder
{


    public function errorResponse($code,$message)
    {
     return response()->json(
        [
            "status"=>"error",
            "message"=>$message
        ]
        ,$code);
    }

       public function successResponse($code,$data)
    {
     return response()->json(
        [
            "status"=>"success",
            "message"=>"Operation successful",
            "data"=>$data
        ]
        ,$code);
    }

}
