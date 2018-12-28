<?php

namespace App\Http\Controllers\Api;

use App\PrivateMessage;
use App\Events\PrivateMessageEvent;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PrivateMessageController extends Controller
{
    /**
     * Send message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
		Validator::make($request->all(), [
			'users' => ['required', 'array'],
			'users.*' => ['exists:users,id'],
			'title' => ['required', 'string', 'max:256'],
			'message' => ['required', 'string', 'max:65536']
		])->validate();

		$messages = new Collection();

		foreach ($request->users as $key => $id)
		{
			$message = PrivateMessage::create([
				'sender_id' => $request->user()->id,
				'receiver_id' => $id,
				'title' => $request->title,
				'message' => $request->message,
				'read' => 0
			]);
			$messages->push($message);

			$channel = 'pm.' . $id;

			broadcast(new PrivateMessageEvent($message, $channel))->toOthers();
		}

		return response(['messages' => $messages], 201);
    }

    /**
     * Get inbox.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInbox(Request $request)
    {
		$channel = 'pm.' . $request->user()->id;
		$messages = $request->user()->Inbox();

		return response(['messages' => $messages, 'channel' => $channel]);
    }

    /**
     * Get outbox.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getOutbox(Request $request)
    {
		$messages = $request->user()->Outbox();

		return response(['messages' => $messages]);
    }

    /**
     * Show message by id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showMessage(Request $request)
    {
		Validator::make($request->all(), [
			'message' => ['required', 'exists:private_messages,id']
		])->validate();

		$message = PrivateMessage::find($request->message);

		if ($message->sender_id == $request->user()->id ||
			$message->receiver_id == $request->user()->id)
		{
			if (!$message->read)
			{
				$message->read = 1;
				$message->save();
			}

			return response(['message' => $message]);
		}

		return response([], 404);
    }
}