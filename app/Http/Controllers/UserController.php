<?php

namespace App\Http\Controllers;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Follow a user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function followUser($id) {
        $user = auth()->user();
        $followedUser = User::find($id);

        if ($user->isFollowing($followedUser)) {
            return response([
                'message' => 'User already followed'
            ], 200);
        }

        $user->follow($followedUser);

        return response([
            'message' => 'User successfully followed'
        ], 200);
    }

    public function getUserInfo($id) {
        $user = User::find($id);

        return response([
            'name' => $user->name
        ]);
    }

    /**
     * Unfollow a user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unfollowUser($id) {
        $user = auth()->user();
        $followedUser = User::find($id);

        if ($user->isFollowing($followedUser)) {
            $user->unfollow($followedUser);

            return response([
                'message' => 'User successfully unfollowed'
            ], 200);
        } else {
            return response([
                'message' => 'User not currently followed'
            ], 200);
        }
    }
}
