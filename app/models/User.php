<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    /**
     * User Database Model
     * 	-	id INT UNSIGNED / AUTO_INCREMENT PRIMARY KEY
     *  -	username VARCHAR(20) / UNIQUE
     *  - 	email VARCHAR(50) / UNIQUE
     *  -	password VARCHAR(60)
     *  -	remember_token VARCHAR(100)
     *  - 	created_at TIMESTAMP
     *  - 	updated_at TIMESTAMP
     */

    /**
     * validation rules for user entities
     *
     */
    public static $rules = ['username' => 'required|alpha_num|between:3,20|unique:users',
                                'email' => 'required|email|between:5,50|unique:users',
                                'password' => 'required|between:5,40',
                                'password_again' => 'required|same:password'
                            ];

    public static $rulesLessStrict = ['username' => 'required|alpha_num|between:3,20',
                                        'email' => 'required|email|between:5,50',
                                        'password' => 'between:5,40',
                                        'password_again' => 'same:password'
                                    ];

    /**
     * validation error messages
     */
    public static $messages = ['username.required' => 'Korisničko ime je obavezno.',
                                'username.alpha_num' => 'Korisničko ime se može sastojati samo od slova i brojeva.',
                                'username.between' => 'Korisničko ime mora biti duljine od 3 do 20 znakova.',
                                'username.unique' => 'Korisničko ime se već koristi.',
                                'email.required' => 'E-mail adresa je obavezna.',
                                'email.email' => 'Unjeta e-mail adresa nije ispravna.',
                                'email.between' => 'E-mail adresa mora biti kraća od 50 znakova.',
                                'email.unique' => 'Unjeta e-mail adresa se već koristi.',
                                'password.required' => 'Lozinka je obavezna.',
                                'password.between' => 'Lozinka mora biti duljine od 5 do 40 znakova.',
                                'password_again.required' => 'Lozinka je obavezna.',
                                'password_again.same' => 'Unjete lozinke nisu iste.'
                            ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * token functions for cookies if needed
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($tokenValue)
    {
        $this->remember_token = $tokenValue;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
