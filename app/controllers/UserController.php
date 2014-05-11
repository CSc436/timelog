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

		$user = Auth::user();
		$credentials = array("email" => $user->email, "password" => Input::get("current-password"));

		if(!Auth::once($credentials)){
			return json_encode("Invalid current password!");
		}

		$rules = array(
			'password' => 'required|alpha_num|between:4,32|confirmed',
			'password_confirmation' => 'required|alpha_num|between:4,32'
			);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()){
			return $validator->getMessageBag();
		}
		else{
			
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
			Input::flash();
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

			$user = User::create(array(
				'firstname'     => Input::get('firstname'),
				'lastname'     => Input::get('lastname'),
				'email'    => Input::get('email'),
				'password' => Hash::make(Input::get('password'))
				));
			

			//Sleep, Social, Work
			//Setup PID
			$catEntry = new logCategory;
			$superCategory = NULL;
			$catEntry->UID = $user->id;
			$catEntry->name = 'Work';
			$catEntry->PID = NULL;
			$catEntry->color = "6AA4B1";
			$catEntry->isTask = 0;
			$catEntry->isCompleted = 0;
			$catEntry->rating = 0;
			$catEntry->deadline = NULL;
			$catEntry->save();

			$catEntry = new logCategory;
			$superCategory = NULL;
			$catEntry->UID = $user->id;
			$catEntry->name = 'Play';
			$catEntry->PID = NULL;
			$catEntry->color = "8DD59F";
			$catEntry->isTask = 0;
			$catEntry->isCompleted = 0;
			$catEntry->rating = 0;
			$catEntry->deadline = NULL;
			$catEntry->save();

			$catEntry = new logCategory;
			$superCategory = NULL;
			$catEntry->UID = $user->id;
			$catEntry->name = 'Uncategorized';
			$catEntry->PID = NULL;
			$catEntry->color = "D09586";
			$catEntry->isTask = 0;
			$catEntry->isCompleted = 0;
			$catEntry->rating = 0;
			$catEntry->deadline = NULL;
			$catEntry->save();
			//Routes::post(logController@saveCategory);

			return Redirect::to('/')->with('success', 'Thanks for registering!');

		} else {
			return $validator->getMessageBag();
		}
	}

	public function getAllUsers(){
		$users = User::all();
		return View::make('users')->with('users', $users);
	}
	
	public function deleteUser(){
	
		$user = Auth::user();
		
		$credentials = array("email" => $user->email, "password" => Input::get("password"));
		if(!Auth::once($credentials)){
			return Redirect::to('profile')->with('err', array("Invalid Password! Could not authenticate!"));
		}
		
		
		$user_to_delete = User::find($user->id);
		$user_to_delete->delete();
		return Redirect::route('logout');
	}

}