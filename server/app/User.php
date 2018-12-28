<?php

namespace App;

use App\Chat;
use App\PrivateMessage;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function Chat($id)
	{
		$Sent = $this->hasMany(Chat::class, 'sender_id')->where('receiver_id', $id)->get();
		$Received = $this->hasMany(Chat::class, 'receiver_id')->where('sender_id', $id)->get();

		return $Sent->concat($Received)->sortBy('created_at')->values();
	}

	public function Inbox()
	{
		$Received = $this->hasMany(PrivateMessage::class, 'receiver_id')->get();

		return $Received->sortByDesc('created_at')->values();
	}

	public function Outbox()
	{
		$Sent = $this->hasMany(PrivateMessage::class, 'sender_id')->get();

		return $Sent->sortByDesc('created_at')->values();
	}
}