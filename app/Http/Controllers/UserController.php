<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(UserResource::collection(User::all()), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
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
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->only(['email', 'password', 'firstName', 'lastName']);
        $phoneData = $request->get('phone');
        $postsData = $request->get('posts');

        $user->email = $data['email'];
        $user->first_name = $data['firstName'];
        $user->last_name = $data['lastName'];
        $user->save();

        $userPhone = $user->phone()->firstOrCreate(['user_id' => $user->id]);
        $userPhone->update(['name' => $phoneData['name']]);
        $userPhone->save();

        foreach ($postsData as $postData) {
            Post::create([
                'user_id' => $user->id,
                'title' => $postData['title']
            ]);
        }

        return response()->json(UserResource::make($user), Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
