<?php

namespace App\Http\Controllers\Api;

use App\Chat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Get chat for specific user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getChat(Request $request)
    {
		Validator::make($request->all(), [
			'id' => ['required', 'exists:users,id'],
		])->validate();

		$Chats = $request->user()->Chat($request->id);

		return response(['chats' => $Chats]);
    }

    /**
     * Send chat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendChat(Request $request)
    {
		Validator::make($request->all(), [
			'id' => ['required', 'exists:users,id'],
			'message' => ['required', 'string', 'max:65536'],
		])->validate();

		$Chat = Chat::create([
			'sender_id' => $request->user()->id,
			'receiver_id' => $request->id,
			'message' => $request->message,
			'read' => 0
		]);

		return response(['chat' => $Chat], 201);
    }
}