<?php

class Gallery extends Eloquent{

    /**
     * Gallery Database Model
     * 	-	id INT UNSIGNED / AUTO_INCREMENT PRIMARY KEY
     *  -	file_name VARCHAR(255) / UNIQUE
     *  -   file_size DOUBLE
     *  -   is_image ENUM('yes'/'no') / DEFAULT@'yes'
     *  - 	created_at TIMESTAMP
     *  - 	updated_at TIMESTAMP
     */

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gallery';


}