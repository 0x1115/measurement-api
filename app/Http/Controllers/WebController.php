<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{
    public function setup($errors = null, $data = null)
    {
        return view('web.login', ['errors' => $errors, 'data' => $data]);
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
            return $this->setup($e->validator->getMessageBag()->all(), $request->all());
        }

        $user = \App\User::where($request->only('email'))->first();
        if (!$user) {
            return $this->setup(['User does not exist'], $request->all());
        }
        if (!Hash::check($request->get('password'), $user->password)) {
            return $this->setup(['Password is incorrect'], $request->all());
        }

        $token = \App\User::generateToken($user, null);
        return $token->content;
    }
}
