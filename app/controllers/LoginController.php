<?php

class LoginController extends BaseController{

    /**
     * CSRF validation on requests
     */
    public function __construct()
    {
        $this->beforeFilter('crfs', ['on' => ['post', 'put', 'patch', 'delete']]);
    }

    /**
     * show login page
     * @return mixed
     */
    public function showLogin()
    {
        if(Auth::guest()){
            $intended_url = Session::get('url.intended', url('admin/pocetna'));
            Session::forget('url.intended');

            return View::make('public.login')->with(['intended_url' => $intended_url,
                                                        'page_title' => 'Prijava'
                                                    ]);
        }
        else{
            return Redirect::to('admin/pocetna');
        }
    }

    /**
     * user login data validation
     * @return mixed
     */
    public function checkLogin()
    {
        //check if user is already authorized
        if(Auth::user()){
            return Redirect::to('admin/pocetna');
        }

        if (Request::ajax()) {

            //get input data
            $input_data = Input::get('formData');
            $token = Input::get('_token');
            $user_data = ['username' => e($input_data['username']),
                            'password' => $input_data['password'],
                            'rememberMe' => $input_data['rememberMe']
                        ];

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }

            $remember_me = false;
            if($user_data['rememberMe'] == '1'){
                $remember_me = true;
            }

            if (Auth::attempt(['username' => $user_data['username'], 'password' => $user_data['password']], $remember_me)) {
                return Response::json(['status' => 'success']);
            }
            else {
                return Response::json(['status' => 'error',
                                        'errors' => 'Neispravno korisničko ime ili lozinka.'
                                    ]);
            }
        }
        else{
            return Response::json(['status' => 'error',
                                    'errors' => 'Data not sent with Ajax.'
                                ]);
        }
    }
}