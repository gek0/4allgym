<?php
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Tag extends Eloquent implements SluggableInterface{

    /**
     * Tags Database Model
     * 	-	id INT UNSIGNED / AUTO_INCREMENT PRIMARY KEY
     *  -	tag VARCHAR(50)
     *  -   slug VARCHAR(255)
     *  - 	created_at TIMESTAMP
     *  - 	updated_at TIMESTAMP
     */

    use SluggableTrait;

    protected $sluggable = ['build_from' => 'tag',
                            'save_to'    => 'slug',
                        ];

    /**
     * validation rules for tags entities
     *
     */
    public static $rules = ['tag' => 'between:1,50'];

    /**
     * validation error messages
     *
     */
    public static $messages = ['tag.between' => 'Tag mora imati barem 1 znak i manje od 50.'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * define relationships
     */
    public function news()
    {
        return $this->belongsToMany('News');
    }
}