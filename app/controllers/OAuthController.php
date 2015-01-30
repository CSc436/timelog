<?php
require 'class.iCalReader.php';

class OAuthController extends BaseController {

	public function loginWithGoogle() {


		// get data from input
		$code = Input::get( 'code' );

		// get google service
		$googleService = OAuth::consumer( 'Google' );

		// check if code is valid

		// if code is provided get user data and sign in
		if ( !empty( $code ) ) {

			// This was a callback request from google, get the token
//                Log::info( 'CODE1->'.$code );
			$token = $googleService->requestAccessToken( $code );
			Session::put('code', $code);
			$code = Session::get('code');
//                Log::info( 'CODE2->'.$code );


			// Send a request with it
			//$result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
			$result = json_decode( $googleService->request( 'https://www.googleapis.com/calendar/v3/calendars/zuomingshi%40gmail.com/events?' ), true );

			//Var_dump
			//display whole array().
			print_r($result);
			die();

		}
		// if not ask for permission first
		else {
			// get googleService authorization
			$url = $googleService->getAuthorizationUri();

			// return to google login url
			return (string)$url;
			//return Redirect::to( (string)$url );
		}
	}

	public function filterAddedEvents ( $eventList ) {
		$user = Auth::user();
		$counter = 0;
		$results = array();

		foreach ($eventList['items'] as $item) {
			$start = DateTime::createFromFormat(DateTime::ISO8601, $item['start']['dateTime']);
			$end = DateTime::createFromFormat(DateTime::ISO8601, $item['end']['dateTime']);
			//Log::info('START' . $start->format(DateTime::ISO8601));
			$name = $item['summary'];
			$add = false;
			$catName = 'Uncategorized';
			
			$category = LogCategory::where('UID', '=', Auth::user()->id)->where('name', '=', $name)->first();

			if ($category == NULL){
				$add = true;
				$category = LogCategory::where('UID', '=', Auth::user()->id)->where('name', '=', 'Uncategorized')->first();
			}else{
				$CID = $category['CID'];
				$entry = LogEntry::where('UID', '=', Auth::user()->id)
					->where('CID', '=', $CID)
					->where('startDateTime', '=', $start)
					->where('endDateTime', '=', $end)->first();
				if($entry == NULL){
					$catName = $name;
					$add = true;
				}
			}

			if($add == true){
				$counter++;
				$interval = $start->diff($end);
				$d = intval($interval->format('%a'));
				$h = intval($interval->format('%h'));
				$m = intval($interval->format('%i'));
				$duration = ((($d * 24) + $h) * 60) + $m;

				$id = DB::table('log_entry')->insertGetId(
    				array('CID' => $category['CID'], 
								'startDateTime' => $start, 
								'endDateTime' => $end, 
								'UID' => Auth::user()->id,
								'notes' => '',
								'duration' => $duration,
								'rating' => 0)
				);
				
				$JSEntry = array('CID' => $category['CID'], 
								'startDateTime' => $item['start']['dateTime'], 
								'endDateTime' => $item['end']['dateTime'], 
								'category' => $category['name'],
								'color' => $category['color'],
								'LID' => $id,
								'notes' => '');
				$results[$counter] = $JSEntry;
			}

		}
		return $results;
	}

	public function calendarRequest () {
		$start = Input::get( 'start' );
		$end = Input::get( 'end' );
		$calendarId = 'zuomingshi@gmail.com';
		$requestString = 'https://www.googleapis.com/calendar/v3/calendars/'.$calendarId.'/events?timeMin='.$start.'&timeMax='.$end.'&singleEvents=true&';
		Log::info( $requestString );
		$googleService = OAuth::consumer( 'Google' );
		$code = Session::get('code');
//                Log::info( 'CODE3->'.$code );
		$result = json_decode( $googleService->request( $requestString ), true );
		$result = $this->filterAddedEvents( $result );
		return json_encode($result);
/*
		$user = User::findOrFail($id);
		$user->fill(Input::all());
		$user->save();
*/                
//                return Redirect::to('log/editSetting')->with('errors', array('1' => 'done.'));
	}
}