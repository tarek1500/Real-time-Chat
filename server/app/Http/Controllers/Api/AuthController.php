<?php

namespace App\Http\Controllers\api;

use App\User;
use DateTime;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Lcobucci\JWT\Parser;
use Laravel\Passport\TokenRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
		Validator::make($request->all(), [
			'email' => ['required', 'string'],
			'password' => ['required', 'string']
		])->validate();

		$user = User::where('email', $request->email)->first();

		if ($user)
		{
			if (Hash::check($request->password, $user->password))
			{
				if ($user->clients->count() > 0)
				{
					$client = $user->clients->first();
					$tokenInfo = $this->createToken($client, $request->email, $request->password);

					return response($tokenInfo, 200);
				}
				else
				{
					return response([
						'message' => 'Something went wrong.',
						'error' => 'invalid_client'
					], 401);
				}
			}
		}

		return response([
			'message' => 'The user credentials were incorrect.',
			'error' => 'invalid_credentials'
		], 401);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
		$access_token = $request->user()->token();

		$refresh_token = DB::table('oauth_refresh_tokens')->where('access_token_id', $access_token->id)->update([
			'revoked' => true
		]);
		$access_token->revoke();

		return response(['message' => 'Logged out'], 200);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
		Validator::make($request->all(), [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:6', 'confirmed']
		])->validate();

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password)
		]);

		$client = $this->createClient($user, false, true);
		$tokenInfo = $this->createToken($client, $request->email, $request->password);

		return response($tokenInfo, 201);
    }

    /**
     * Create an API Client for auth user.
     *
     * @param  \App\User  $user
     * @param  bool  $personalAccess
     * @param  bool  $password
     * @return \Laravel\Passport\Client
     */
    private function createClient(User $user, $personalAccess = false, $password = false)
    {
		return $user->clients()->create([
			'name' => $user->name . ' Client',
			'secret' => str_random(40),
			'redirect' => '',
			'personal_access_client' => $personalAccess,
			'password_client' => $password,
			'revoked' => false
		]);
    }

    /**
     * Create a token for auth user.
     *
     * @param  \Laravel\Passport\Client  $client
     * @param  string  $email
     * @param  string  $password
     * @return array
     */
    private function createToken(\Laravel\Passport\Client $client, $email, $password)
    {
		$response = (new Client)->post(route('passport.token'), [
			'form_params' => [
				'grant_type' => 'password', // First party clients, for web & native (client must be password_client)
				'client_id' => $client->id,
				'client_secret' => $client->secret,
				'scope' => '',
				'username' => $email,
				'password' => $password
			]
		]);

		return json_decode((string) $response->getBody(), true);
    }

    /**
     * Check if token is expired.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkToken(Request $request)
    {
		Validator::make($request->all(), [
			'access_token' => ['required', 'string']
		])->validate();

		$is_valid = $this->checkTokenValidation($request->access_token);

		return response(['valid' => $is_valid], 200);
    }

    /**
     * Refresh access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refreshToken(Request $request)
    {
		Validator::make($request->all(), [
			'access_token' => ['required', 'string'],
			'refresh_token' => ['required', 'string']
		])->validate();

		$token = $this->getAccessToken($request->access_token);

		if ($token)
		{
			try
			{
				$response = (new Client)->post(route('passport.token'), [
					'form_params' => [
						'grant_type' => 'refresh_token',
						'refresh_token' => $request->refresh_token,
						'client_id' => $token->client->id,
						'client_secret' => $token->client->secret,
						'scope' => ''
					]
				]);

				return response(json_decode((string) $response->getBody(), true), 201);
			}
			catch (ClientException $exception) {}
		}

		return response([
			'message' => 'Unauthenticated.',
			'error' => 'invalid_token'
		], 401);
    }

    /**
     * Check access token validation.
     *
     * @param  string  $access_token
     * @return bool
     */
    private function checkTokenValidation(String $access_token)
    {
		$token = $this->getAccessToken($access_token);

		if ($token)
		{
			$current_date = new DateTime();
			$expire_date = new DateTime($token->expires_at);

			if (!$token->revoked && $expire_date > $current_date)
				return true;
		}

		return false;
    }

    /**
     * Get access token.
     *
     * @param  string  $access_token
     * @return \Laravel\Passport\Token
     */
    private function getAccessToken(String $access_token)
    {
		$token_id = (new Parser)->parse($access_token)->getHeader('jti');
		$token = (new TokenRepository)->find($token_id);

		return $token;
    }
}