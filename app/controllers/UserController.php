<?php

class UserController extends Controller {

	public function postChangeUserEmail(){

		$validator = Validator::make(Input::all(),

			array(
				'email' => 'required|email|unique:user'
				)
			);

		if($validator->fails()){
			return json_encode(array("error" => "There was a problem with the email you submitted."));
		}
		else{
			
			$user = Auth::user();
			$dbUser = User::find($user->id);
			$dbUser->email = Input::get("email");
			$dbUser->save();

			return json_encode($dbUser->email);
		}

	}

	public function postChangeUserPassword(){

		$rules = array(
			'password'  => 'required|alpha_num|between:4,32|confirmed',
			'password_confirmation' => 'required|alpha_num|between:4,32'
			);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()){
			return $validator->getMessageBag();
		}
		else{
			
			$user = Auth::user();
			$dbUser = User::find($user->id);
			$dbUser->password = Hash::make(Input::get("password"));
			$dbUser->save();

			return json_encode(true);
		}
	}


	public function postUserLogin(){

		$credentials = array(
			'email' => Input::get('email'),
			'password' => Input::get('password')
			);

		if (Auth::attempt($credentials))
		{
			return Redirect::intended('profile');
		}
		else {
			return Redirect::to('login')->with('error', 'Incorrect email or password');
		}
	}

	public function postNewUser(){
		
		$rules = array(
			'firstname' => 'required|min:2|max:64|alpha',
			'lastname'  => 'required|min:2|max:64|alpha',
			'email'     => 'required|between:3,64|email|unique:user',
			'password'  => 'required|alpha_num|between:4,32|confirmed',
			'password_confirmation' => 'required|alpha_num|between:4,32'
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->passes()) {

			User::create(array(
				'firstname'     => Input::get('firstname'),
				'lastname'     => Input::get('lastname'),
				'username'     => Input::get('username'),
				'email'    => Input::get('email'),
				'password' => Hash::make(Input::get('password'))
				));

			return Redirect::to('/')->with('success', 'Thanks for registering!');

		} else {
			return $validator->getMessageBag();
		}
	}

	public function getAllUsers(){
		$users = User::all();
		return View::make('users')->with('users', $users);
	}

}