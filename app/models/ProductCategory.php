<?php

class ProductCategory extends Eloquent{

    /**
     * ProductCategory Database Model
     * 	-	id INT UNSIGNED / AUTO_INCREMENT PRIMARY KEY
     *  -	category_name VARCHAR(255) / UNIQUE
     */

    /**
     * validation rules for news entities
     *
     */
    public static $rules = ['category_name' => 'required|between:1,255|unique:product_category'];

    public static $rulesLessStrict = ['category_name' => 'required|between:1,255'];

    /**
     * validation error messages
     *
     */
    public static $messages = ['category_name.required' => 'Ime kategorije je obavezno.',
                                'category_name.between' => 'Ime kategorije mora biti kraće od 255 znakova.',
                                'category_name.unique' => 'Kategorija s istim imenom već postoji.',
                            ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_category';
    public $timestamps = false;

    /**
     * define relationships
     */
    public function products()
    {
        return $this->belongsToMany('Product');
    }

}