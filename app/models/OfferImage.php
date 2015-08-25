<?php

class OfferImage extends Eloquent{

    /**
     * NewsImage Database Model
     * 	-	id INT UNSIGNED / AUTO_INCREMENT PRIMARY KEY
     *  -	file_name VARCHAR(255) / UNIQUE
     *  -   file_size DOUBLE
     *  -   offer_id INT UNSIGNED / FOREIGN KEY@offerss / ON DELETE CASCADE
     *  - 	created_at TIMESTAMP
     *  - 	updated_at TIMESTAMP
     */

    /**
     * validation rules for offers image entities
     *
     */
    public static $rules = ['images' => 'image|max:6000'];

    /**
     * validation error messages
     *
     */
    public static $messages = ['images.image' => 'Dozvoljeni formati slike su: .jpeg, .png, .bmp i .gif.',
                                'images.max' => 'Maksimalna velièina slike je 6MB.'
                            ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'offers_images';

    /**
     * define relationships
     */
    public function offer()
    {
        return $this->belongsTo('Offer', 'offer_id');
    }
}