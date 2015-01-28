<?php

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
                dd($result);

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

        public function calendarRequest () {
                $start = Input::get( 'start' );
                $end = Input::get( 'end' );
                $calendarId = 'zuomingshi@gmail.com';
                $requestString = 'https://www.googleapis.com/calendar/v3/calendars/'.$calendarId.'/events?timeMin='.$start.'&timeMax='.$end.'&';
                Log::info( $requestString );
                $googleService = OAuth::consumer( 'Google' );
                $code = Session::get('code');
//                Log::info( 'CODE3->'.$code );
                $result = json_decode( $googleService->request( $requestString ), true );

                return $result;
/*
                $user = User::findOrFail($id);
                $user->fill(Input::all());
                $user->save();
*/                
//                return Redirect::to('log/editSetting')->with('errors', array('1' => 'done.'));
        }
}