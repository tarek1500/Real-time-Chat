<?php

namespace App\Http\Controllers\Api;

use App\Chat;
use App\Events\ChatEvent;
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
			'id' => ['required', 'exists:users,id']
		])->validate();

		$channel = $this->getChannelName($request->user()->id, $request->id);
		$chats = $request->user()->Chat($request->id);

		return response(['chats' => $chats, 'channel' => $channel]);
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
			'message' => ['required', 'string', 'max:65536']
		])->validate();

		$chat = Chat::create([
			'sender_id' => $request->user()->id,
			'receiver_id' => $request->id,
			'message' => $request->message
		]);
		$channel = $this->getChannelName($request->user()->id, $request->id);

		broadcast(new ChatEvent($chat, $channel))->toOthers();

		return response(['chat' => $chat], 201);
    }

    /**
     * Generate channel name.
     *
     * @param  int  $sender
     * @param  int  $receiver
     * @return string
     */
    public function getChannelName($sender, $receiver)
    {
		if ($sender > $receiver)
			return 'chat.' . $receiver . '.' . $sender;
		else
			return 'chat.' . $sender . '.' . $receiver;
    }
}