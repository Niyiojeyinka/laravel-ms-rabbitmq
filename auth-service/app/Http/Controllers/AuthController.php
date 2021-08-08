<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    /**
     * sign in function
     *
     * @param  App\Http\Requests\RegisterRequest;
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {

        $user = User::create(
            array_merge($request->all(), [
                'password' => Hash::make($request->password)
            ])

        );

        return $this->respondWithToken($user);
    }


    /**
     * sign in function
     *
     * @param  App\Http\Requests\LoginRequest;
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (empty($user)) {
            return $this->errorResponse(400, "User not exists");
        }

        if (!Hash::check($request->password, $user->password)) {

            return $this->errorResponse(401, 'Invalid or Incorrect Password');
        }

        return $this->respondWithToken($user);
    }



    /**
     * return user object and token
     *
     * @param  object $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($user)
    {


        $token = $user->createToken($user->email)->plainTextToken;

        return $this->successResponse(200, [
            'token' => $token,
            'user' => $user
        ]);
    }
}
