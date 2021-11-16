<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequets $request)
    {
        $validated = $request->validated();

        if(!Auth::attempt($validated)){
            return$this->apiError('Credentials not match', Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email',$validated['email'])->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->apiSuccess([
            'token'=>$token,
            'token_type'=>'Bearer',
            'user'=>$user,
        ]);
    }
}
