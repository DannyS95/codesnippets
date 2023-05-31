<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $token = auth()->attempt($request->only('email', 'password'));
      
        if (!$token) {
            return response()->json([
                'errors' => [
                    'email' => [
                        'Could not sign you in with those details'
                    ]
                ]
            ], 422);
        }

        return response()->json([
            'data' => compact('token')
        ]);
    }
}
