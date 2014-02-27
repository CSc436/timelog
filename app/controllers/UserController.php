<?php

class UserController extends Controller {

	public function postUserLogin(){

		$credentials = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
			);

		if (Auth::attempt($credentials))
		{
			return Redirect::intended('profile');
		}
		else {
			return Redirect::to('login');
		}
	}

	public function postNewUser(){
		
		$rules = array(
			'firstname' => 'required|min:2|max:64|alpha',
			'lastname'  => 'required|min:2|max:64|alpha',
			'username'  => 'required|alpha_num|between:4,32|unique:user',
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