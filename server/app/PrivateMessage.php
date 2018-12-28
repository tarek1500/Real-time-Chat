<?php

namespace App;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['sender_id', 'receiver_id', 'title', 'message', 'read'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
	protected $appends = ['created_at_string', 'updated_at_string', 'sender', 'receiver'];

	public function getCreatedAtStringAttribute()
	{
		return Carbon::parse($this->created_at)->diffForHumans();
	}

	public function getUpdatedAtStringAttribute()
	{
		return Carbon::parse($this->updated_at)->diffForHumans();
	}

	public function getSenderAttribute()
	{
		return User::find($this->sender_id);
	}

	public function getReceiverAttribute()
	{
		return User::find($this->receiver_id);
	}
}