<?php

class PagesImage extends Eloquent{

    /**
     * PagesImage Database Model
     * 	-	id INT UNSIGNED / AUTO_INCREMENT PRIMARY KEY
     *  -	file_name VARCHAR(255) / UNIQUE
     *  -   file_size DOUBLE
     *  -   pages_id INT UNSIGNED / FOREIGN KEY@pages / ON DELETE CASCADE
     *  - 	created_at TIMESTAMP
     *  - 	updated_at TIMESTAMP
     */

    /**
     * validation rules for pages image entities
     *
     */
    public static $rules = array(
        'images' => 'image|max:6000'
    );

    /**
     * validation error messages
     *
     */
    public static $messages = array(
        'images.image' => 'Dozvoljeni formati slike su: .jpeg, .png, .bmp i .gif.',
        'images.max' => 'Maksimalna veličina slike je 6MB.'
    );

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages_images';

    /**
     * define relationships
     */
    public function pages()
    {
        return $this->belongsTo('Pages', 'pages_id');
    }
}