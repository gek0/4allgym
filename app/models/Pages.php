<?php

class Pages extends Eloquent{

    /**
     * Pages Database Model
     *	-	id INT UNSIGNED / AUTO_INCREMENT PRIMARY KEY
     *  -	page_title VARCHAR(255)
     *  - 	page_text TEXT
     *	-	page_uri VARCHAR(255)
     *  - 	created_at TIMESTAMP
     *  - 	updated_at TIMESTAMP
     */

    /**
     * validation rules for pages entities
     *
     */
    public static $rules = array(
        'page_title' => 'required|between:1,255',
        'page_text' => 'required'
    );

    /**
     * validation error messages
     *
     */
    public static $messages = array(
        'page_title.required' => 'Naslov stranice je obavezan.',
        'page_title.between' => 'Naslov mora biti kraći od 255 znakova.',
        'page_text.required' => 'Tekst stranice je obavezan.'
    );

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * define relationships
     */
    public function images()
    {
        return $this->hasMany('PagesImage', 'page_id');
    }

}