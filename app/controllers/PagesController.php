<?php

class PagesController extends BaseController {

	// Home page
	public function Index()
	{
		return View::make('index')->with('active', 'home');
	}


	// Login and Log out links act here
	public function Login()
	{
		if (Auth::check())
		{
			return Redirect::to('/');
		} else {
			return View::make('login')->with(array('active'=> 'login', 'failed'=> false));
		}
	}

	public function LogOut()
	{
		Auth::logout();
		return Redirect::to('/login')->with('success', 'You are now logged out.');
	}


	// The links in the footer act here
	public function About()
	{
		return View::make('about');
	}

	public function Contact()
	{
		return View::make('contact');
	}

	public function Help()
	{
		return View::make('help');
	}

	public function PrivacyPolicy()
	{
		return View::make('privacy')->with('company_name', 'Time Log');
	}

	public function TermsOfService()
	{
		return View::make('tos');
	}
}