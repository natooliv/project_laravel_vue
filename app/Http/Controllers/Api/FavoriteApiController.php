<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class FavoriteApiController extends Controller
{
    public function myFavorites(Request $request)
    {
        $users = $request->user()
                            ->favorites()
                            ->inRandomOrder()
                            ->get();

        return UserResource::collection($users);
    }


}
