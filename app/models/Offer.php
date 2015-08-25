<?php
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Offer extends Eloquent implements SluggableInterface
{

    /**
     * Offers Database Model
     *  -    id INT UNSIGNED / AUTO_INCREMENT PRIMARY KEY
     *  -    offer_title VARCHAR(255) / UNIQUE
     *  -    offer_body TEXT
     *  -    slug VARCHAR(255)
     *  -    created_at TIMESTAMP
     *  -    updated_at TIMESTAMP
     */

    use SluggableTrait;

    protected $sluggable = ['build_from' => 'offer_title',
                                'save_to' => 'slug',
                            ];

    /**
     * validation rules for offer entities
     *
     */
    public static $rules = ['offer_title' => 'required|between:1,255|unique:offers',
                                'offer_body' => 'required'
                            ];

    public static $rulesLessStrict = ['offer_title' => 'required|between:1,255',
                                        'offer_body' => 'required'
                                    ];

    /**
     * validation error messages
     *
     */
    public static $messages = ['offer_title.required' => 'Naslov ponude je obavezan.',
                                'offer_title.between' => 'Naslov ponude mora biti kraæi od 255 znakova.',
                                'offer_title.unique' => 'Ponuda s istim naslovom veæ postoji.',
                                'offer_body.required' => 'Tekst ponude je obavezan.'
                            ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'offers';

    /**
     * define relationships
     */
    public function images()
    {
        return $this->hasMany('OfferImage', 'offer_id');
    }
}