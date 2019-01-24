<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Get current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request)
    {
		return $request->user()->only(['id', 'name', 'email']);
    }

    /**
     * Get all users except current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllUsers(Request $request)
    {
		$users = User::where('id', '!=', $request->user()->id)->orderBy('name')->get(['id', 'name', 'email']);

		return response(['users' => $users]);
    }
}