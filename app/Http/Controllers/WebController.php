<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{
    public function setup($errors = null, $data = null)
    {
        return view('web.setup', ['errors' => $errors, 'data' => $data]);
    }

    public function postSetup(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if (!$e->validator) {
                return $e->getMessage();
            }
            if ($request->ajax() || $request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'error' => [
                        'message' => 'ValidationError',
                        'messages' => $e->validator->getMessageBag()->all()
                    ]
                ], 422);
            }
            return $this->setup($e->validator->getMessageBag()->all(), $request->all());
        }

        $user = \App\User::where($request->only('email'))->first();
        if (!$user) {
            if ($request->ajax() || $request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'error' => [
                        'message' => 'User does not exist'
                    ]
                ], 422);
            }
            return $this->setup(['User does not exist'], $request->all());
        }
        if (!Hash::check($request->get('password'), $user->password)) {
            if ($request->ajax() || $request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'error' => [
                        'message' => 'Password is incorrect'
                    ]
                ], 422);
            }
            return $this->setup(['Password is incorrect'], $request->all());
        }

        $token = \App\User::generateToken($user, null);
        if ($request->ajax() || $request->wantsJson() || $request->isJson()) {
            return response()->json([
                'data' => $token->content
            ], 200);
        }
        return $token->content;
    }
}
