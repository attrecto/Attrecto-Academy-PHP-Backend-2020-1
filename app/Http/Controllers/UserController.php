<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(UserResource::collection(User::all()), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->only(['email', 'password']);

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json(UserResource::make($user), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(UserResource::make($user), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return void
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->only(['email', 'password', 'firstName', 'lastName']);

        $user->email = $data['email'];
        $user->first_name = $data['firstName'];
        $user->last_name = $data['lastName'];
        $user->save();

        return response()->json(UserResource::make($user), Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
