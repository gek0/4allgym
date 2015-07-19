<?php

class AdminController extends BaseController{

    /**
     * CSRF validation on requests
     */
    public function __construct()
    {
        $this->beforeFilter('crfs', ['on' => ['post', 'put', 'patch', 'delete']]);
    }

    /**
     * show admin homepage
     * @return mixed
     */
    public function showHome()
    {
        return View::make('admin.index');
    }

    /**
     * show admin user settings page
     * @return mixed
     */
    public function showUserSettings()
    {
        //get current user data
        $user_data = User::findOrFail(Auth::user()->id);

        return View::make('admin.user-settings')->with(['user_data' => $user_data]);
    }

    /**
     * update user account data
     * @return mixed
     */
    public function updateUserSettings()
    {
        if (Request::ajax()){

            //get user input data
            $input_data = Input::get('formData');
            $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
            $user_data = ['username' => $input_data['username'],
                            'email' => $input_data['email'],
                            'password' => $input_data['password'],
                            'password_again' => $input_data['password_again'],
                        ];

            //validation
            $validator = Validator::make($user_data, User::$rulesLessStrict, User::$messages);

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                //check validation results and save user if ok
                if($validator->fails()){
                    return Response::json(['status' => 'error',
                                            'errors' => $validator->getMessageBag()->toArray()
                                        ]);
                }
                else{
                    $user = User::find(Auth::user()->id);
                    $user->username = e($user_data['username']);
                    $user->email = e($user_data['email']);
                    
                    //change user password if new is in input
                    if(strlen($user_data['password']) > 0) {
                        $user->password = Hash::make($user_data['password']);
                    }
                    $user->save();

                    return Response::json(['status' => 'success']);
                }
            }
        }
        else{
            return Response::json(['status' => 'error',
                                    'errors' => 'Data not sent with Ajax.'
                                ]);
        }
    }

    /**
     * create new user account
     * @return mixed
     */
    public function addNewUser()
    {
        if (Request::ajax()){

            //get user input data
            $input_data = Input::get('formData');
            $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
            $user_data = ['username' => $input_data['newUsername'],
                            'email' => $input_data['newEmail'],
                            'password' => $input_data['newPassword'],
                            'password_again' => $input_data['newPasswordAgain'],
                        ];

            //validation
            $validator = Validator::make($user_data, User::$rules, User::$messages);

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                //check validation results and save user if ok
                if($validator->fails()){
                    return Response::json(['status' => 'error',
                                            'errors' => $validator->getMessageBag()->toArray()
                                        ]);
                }
                else{
                    $user = new User;
                    $user->username = e($user_data['username']);
                    $user->email = e($user_data['email']);
                    $user->password = Hash::make($user_data['password']);
                    $user->save();

                    return Response::json(['status' => 'success']);
                }
            }
        }
        else{
            return Response::json(['status' => 'error',
                                    'errors' => 'Data not sent with Ajax.'
                                ]);
        }
    }


}