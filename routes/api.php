<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts', function (Request $request) {
    $posts = [
        [
            'id' => 1,
            'body' => 'nagyon jó body',
            'title' => 'nagyon jó title',
            'likeNumber' => 5,
            'comments' => [
                [
                    'id' => 1,
                    'message' => 'nagyon jó komment 1'
                ],
                [
                    'id' => 2,
                    'message' => 'nagyon jó komment 2'
                ]
            ]
                ],
                [
                    'id' => 2,
                    'body' => 'nagyon jó body 2',
                    'title' => 'nagyon jó title 2',
                    'likeNumber' => 2,
                    'comments' => [
                        [
                            'id' => 1,
                            'message' => 'nagyon jó komment 1'
                        ],
                        [
                            'id' => 2,
                            'message' => 'nagyon jó komment 2'
                        ]
                    ]
                        ]
    ];

    $postsCollection = collect($posts);

    return $postsCollection->where('likeNumber','>=',$request['likeNumber'])->all();
});

Route::get('posts/{id}', function ($id) {
    $posts = [
        [
            'id' => 1,
            'body' => 'nagyon jó body',
            'title' => 'nagyon jó title',
            'likeNumber' => 5,
            'comments' => [
                [
                    'id' => 1,
                    'message' => 'nagyon jó komment 1'
                ],
                [
                    'id' => 2,
                    'message' => 'nagyon jó komment 2'
                ]
            ]
                ],
                [
                    'id' => 2,
                    'body' => 'nagyon jó body 2',
                    'title' => 'nagyon jó title 2',
                    'likeNumber' => 2,
                    'comments' => [
                        [
                            'id' => 1,
                            'message' => 'nagyon jó komment 1'
                        ],
                        [
                            'id' => 2,
                            'message' => 'nagyon jó komment 2'
                        ]
                    ]
                        ]
    ];

    $postsCollection = collect($posts);

    $result = $postsCollection->where('id','=',$id)->first();

    if($result == null){
        throw new ModelNotFoundException();
    }

    return $result;
});


Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'store']);
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'destroy']);
});
