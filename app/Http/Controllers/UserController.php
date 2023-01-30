<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //Password is encrypted with bcrypt.
            $password = bcrypt($request->password);
            //I created a user with username and password.
            User::create([
                'username' => $request->username,
                'password' => $password,
            ]);
            //I returned the message as json.
            return response()->json(
                [
                    'message' => 'User created',
                ],
                200
            );
        } catch (\Throwable $th) {
            //If there is any error in TRY, I turn it 500.
            return response()->json(
                [
                    'message' => 'User not created',
                ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $username, $password)
    {
        //Username control was performed in User.
        $user = User::where('username', $username)->first();
        //User control was performed in User.
        if ($user) {
            //Password control was performed in User.
            if (password_verify($password, $user->password)) {
                $token = $user->createToken('TOKEN')->plainTextToken;
                return response()->json(
                    [
                        'message' => 'User found',
                        'user' => $user,
                        'token' => $token,
                    ],
                    200
                );
            } else {
                //Password control was performed in User.
                return response()->json(
                    [
                        'message' => 'Wrong password',
                    ],
                    404
                );
            }
        } else {
            return response()->json(
                [
                    'message' => 'User not found',
                ],
                404
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
