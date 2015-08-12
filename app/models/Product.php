<?php
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Product extends Eloquent implements SluggableInterface
{

    /**
     * Product Database Model
     *  -   id INT UNSIGNED / AUTO_INCREMENT PRIMARY KEY
     *  -   product_name VARCHAR(255) / UNIQUE
     *  -   product_image VARCHAR(255)
     *  -   product_price VARCHAR(255)
     *  -   product_description TEXT
     *  -   product_active ENUM('yes', 'no') / DEFAULT@yes
     *  -   category_id INT UNSIGNED / FOREIGN KEY@product_category
     *  -   slug VARCHAR(255)
     *  -   created_at TIMESTAMP
     *  -   updated_at TIMESTAMP
     */

    use SluggableTrait;

    protected $sluggable = ['build_from' => 'product_name',
                            'save_to' => 'slug',
                        ];

    /**
     * validation rules for product entities
     *
     */
    public static $rules = ['product_name' => 'required|between:1,255|unique:products',
                                'product_image' => 'image|max:6000',
                                'product_price' => 'required',
                                'product_description' => 'required',
                                'product_active' => 'required',
                                'product_category' => 'integer',
                            ];

    public static $rulesLessStrict = ['product_name' => 'required|between:1,255',
                                        'product_image' => 'image|max:6000',
                                        'product_price' => 'required',
                                        'product_description' => 'required',
                                        'product_active' => 'required',
                                        'product_category' => 'integer',
                                    ];

    public static $rulesCategorySort = ['person_category' => 'integer'];

    /**
     * validation error messages
     *
     */
    public static $messages = ['product_name.required' => 'Ime proizvoda je obavezno.',
                                'product_name.between' => 'Ime proizvoda mora biti kraće od 255 znakova.',
                                'product_name.unique' => 'Proizvod s istim imenom već postoji.',
                                'product_image.image' => 'Dozvoljeni formati slike su: .jpeg, .png, .bmp i .gif.',
                                'product_image.max' => 'Maksimalna veličina slike je 6MB.',
                                'product_price.required' => 'Cijena proizvoda je obavezna.',
                                'product_description.required' => 'Opis proizvoda je obavezan.',
                                'product_active.required' => 'Status proizvoda je obavezno polje.',
                                'product_category.integer' => 'Kategorija proizvoda je obavezna.',
                            ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * define relationships
     */
    public function category()
    {
        return $this->belongsTo('ProductCategory', 'category_id');
    }
}