<?php

class ProductController extends BaseController
{

    /**
     * CSRF validation on requests
     */
    public function __construct()
    {
        $this->beforeFilter('crfs', ['on' => ['post', 'put', 'patch', 'delete']]);
    }

    /**
     * show shop homepage in admin area
     * @return mixed
     */
    public function showShopAdmin()
    {
        //get products
        $products_data = Product::orderBy('product_name', 'ASC')->paginate(9);

        //get all categories from DB to populate dropdown
        $product_categories = ProductCategory::orderBy('category_name')->lists('category_name', 'id');

        return View::make('admin.shop.index')->with(['products_data' => $products_data,
                                                        'product_categories' => $product_categories,
                                                        'category_id' => null
                                                    ]);
    }

    /**
     * show individual product in admin area
     * @param null $slug
     * @return mixed
     */
    public function showProductAdmin($slug = null)
    {
        //get product
        $product_data = Product::findBySlug($slug);

        if($product_data){
            return View::make('admin.shop.pregled')->with(['product_data' => $product_data]);
        }
        else{
            return Redirect::to('admin/shop')->withErrors('Proizvod ne postoji.');
        }
    }

    /**
     * get products sorted by selected category - paginated
     * @return mixed
     */
    public function sortProductsByCategory()
    {
        //get category from form data
        $category_id = e(Input::get('category'));

        $products_data = Product::where('category_id', '=', $category_id)->paginate(9);

        //get all categories from DB to populate dropdown
        $product_categories = ProductCategory::orderBy('category_name')->lists('category_name', 'id');

        //category validation
        $category_data = ['product_category' => $category_id];

        $validator = Validator::make($category_data, Product::$rulesCategorySort, Product::$messages);
        if($validator->fails()){
            $error = $validator->messages();
            return View::make('admin.shop.index', compact('product_categories'))->with(['products_data' => $products_data,
                                                                                                'category_id' => $category_id
                                                                                            ])->withErrors($error);
        }
        else{
            return View::make('admin.shop.index', compact('product_categories'))->with(['products_data' => $products_data,
                                                                                                'category_id' => $category_id
                                                                                            ]);
        }
    }

    /**
     * delete selected product
     * @param null $slug
     * @return mixed
     */
    public function deleteProduct($slug = null)
    {
        //get product
        $product = Product::findBySlug($slug);

        if($product){
            try{
                //delete image from disk
                File::deleteDirectory(public_path().'/product_uploads/'.$product->id.'/');

                //delete data from database
                $product->delete();

                return Redirect::to('admin/shop')->with(['success' => 'Proizvod je uspješno obrisan.']);
            }
            catch(Exception $e){
                return Redirect::to('admin/shop/proizvod/pregled/'.$slug)->withErrors('Proizvod nije mogao biti obrisan.');
            }
        }
        else{
            return Redirect::to('admin/shop')->withErrors('Proizvod ne postoji.');
        }
    }

    /**
     * show all product categories
     * @return mixed
     */
    public function showShopCategoriesAdmin()
    {
        //grab all categories
        $categories_data = ProductCategory::orderBy('category_name', 'ASC')->get();

        return View::make('admin.shop.kategorije')->with(['categories_data' => $categories_data]);
    }

    /**
     * add new product category
     * @return mixed
     */
    public function addProductCategories()
    {
        if(Request::ajax()){

            //get form data and token
            $category_data = ['category_name' => e(Input::get('formData'))];
            $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                //data validation
                $validator = Validator::make($category_data, ProductCategory::$rules, ProductCategory::$messages);

                if($validator->fails()){
                    return Response::json(['status' => 'error',
                                            'errors' => $validator->messages()->toArray()
                                        ]);
                }
                else{
                    $category = new ProductCategory;
                    $category->category_name = $category_data['category_name'];
                    $category->save();

                    return Response::json(['status' => 'success',
                                            'insert_id' => $category->id
                                        ]);
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
     * edit product category name
     * @return mixed
     */
    public function editProductCategories()
    {
        if(Request::ajax()){

            //get category data and token
            $category_id = e(Input::get('categoryID'));
            $category_data = ['category_name' => e(Input::get('categoryName'))];
            $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                $category = ProductCategory::find($category_id);

                //edit image caption if exists and return JSON response
                if($category){
                    try{

                        //validation
                        $validator = Validator::make($category_data, ProductCategory::$rulesLessStrict, ProductCategory::$messages);

                        if($validator->fails()){
                            return Response::json(['status' => 'error',
                                'errors' => $validator->messages()->toArray()
                            ]);
                        }
                        else{
                            $category->category_name = $category_data['category_name'];
                            $category->save();

                            return Response::json(['status' => 'success']);
                        }
                    }
                    catch(Exception $e){
                        return Response::json(['status' => 'error',
                                                'errors' => 'Izmjena imena kategorije nije uspjela.'
                                            ]);
                    }
                }
                else{
                    return Response::json(['status' => 'error',
                                            'errors' => 'Kategorija ne postoji.'
                                        ]);
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
     * delete product category
     * @return mixed
     */
    public function deleteProductCategories()
    {
        if(Request::ajax()){

            //get category ID and token
            $category_id = e(Input::get('categoryData'));
            $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                $category = ProductCategory::find($category_id);

                //delete category if exists and return JSON response
                if($category){
                    try{
                        $category->delete();

                        return Response::json(['status' => 'success']);
                    }
                    catch(Exception $e){
                        return Response::json(['status' => 'error',
                                                'errors' => 'Brisanje kategorije nije uspjelo.'
                                            ]);
                    }
                }
                else{
                    return Response::json(['status' => 'error',
                                            'errors' => 'Kategorija ne postoji.'
                                        ]);
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
     * show new product form
     * @return mixed
     */
    public function showNewProductForm()
    {
        //get all categories from DB to populate dropdown
        $product_categories = ProductCategory::orderBy('category_name')->lists('category_name', 'id');

        return View::make('admin.shop.novi-proizvod', compact('product_categories'));
    }


    /**
     * add new product over POST request
     * @return mixed
     */
    public function addNewProduct()
    {
        //get form data
        $product_image = Input::file('product_image');
        $product_data = ['product_name' => e(Input::get('product_name')),
                            'product_price' => e(Input::get('product_price')),
                            'product_description' => e(Input::get('product_description')),
                            'product_active' => e(Input::get('product_active')),
                            'product_category' => e(Input::get('product_category'))
                        ];
        $is_active = ($product_data['product_active'] == 'yes' ?: 'no');
        $error_list = null;

        //add image to data array if exists
        if($product_image){
            array_push($product_data, ['product_image' => $product_image]);
        }

        /*
         *  validation
         */
        $validator = Validator::make($product_data, Product::$rules, Product::$messages);
        if($validator->fails()){
            $error_list = $validator->messages();

            return Redirect::to('admin/shop/proizvod/dodaj')->withErrors($error_list)->withInput();
        }
        else{
            $product = new Product;
            $product->product_name = $product_data['product_name'];
            $product->product_price = $product_data['product_price'];
            $product->product_description = $product_data['product_description'];
            $product->product_active = $is_active;
            $product->category_id = $product_data['product_category'];
            $product->save();

            //slug regenerate - croatian letter fix
            $product->slug = safe_name($product_data['product_name']);
            $product->save();

            //image
            if($product_image){
                //check for image directory
                $path = public_path().'/product_uploads/'.$product->id.'/';
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777);
                }

                //upload image and move to folder on disk
                $file_name = $product->slug.'_'.Str::random(2);
                $file_extension = $product_image->getClientOriginalExtension();
                $full_name = $file_name.'.'.$file_extension;

                $file_uploaded = $product_image->move($path, $full_name);

                //save to DB if uploaded
                if ($file_uploaded) {
                    $product->product_image = $full_name;
                    $product->save();
                }
            }

            //redirect on finish
            return Redirect::to('admin/shop')->with(['success' => 'Proizvod je uspješno dodan.']);
        }
    }

    /**
     * show product edit form
     * @param null $slug
     * @return mixed
     */
    public function showProductEditForm($slug = null)
    {
        //get product
        $product_data = Product::findBySlug($slug);

        if($product_data){
            //get all categories from DB to populate dropdown
            $product_categories = ProductCategory::orderBy('category_name')->lists('category_name', 'id');

            return View::make('admin.shop.izmjena', compact('product_categories'))->with(['product_data' => $product_data]);
        }
        else{
            return Redirect::to('admin/shop')->withErrors('Proizvod ne postoji.');
        }
    }

    /**
     * edit selected product
     * @return mixed
     */
    public function updateProduct()
    {
        //find product
        $slug = e(Input::get('slug'));
        $product = Product::findBySlug($slug);

        if($product){
            //get form data
            $product_image = Input::file('product_image');
            $product_data = ['product_name' => e(Input::get('product_name')),
                                'product_price' => e(Input::get('product_price')),
                                'product_description' => e(Input::get('product_description')),
                                'product_active' => e(Input::get('product_active')),
                                'product_category' => e(Input::get('product_category'))
                            ];
            $is_active = ($product_data['product_active'] == 'yes' ?: 'no');
            $error_list = null;

            //add image to data array if exists
            if($product_image){
                array_push($product_data, ['product_image' => $product_image]);
            }

            /*
             *  validation
             */
            $validator = Validator::make($product_data, Product::$rulesLessStrict, Product::$messages);
            if($validator->fails()){
                $error_list = $validator->messages();

                return Redirect::to('admin/shop/proizvod/izmjena'.$slug)->withErrors($error_list)->withInput();
            }
            else{
                $product->product_name = $product_data['product_name'];
                $product->product_price = $product_data['product_price'];
                $product->product_description = $product_data['product_description'];
                $product->product_active = $is_active;
                $product->category_id = $product_data['product_category'];
                $product->save();

                //slug regenerate - croatian letter fix
                $product->slug = safe_name($product_data['product_name']);
                $product->save();

                //image
                if($product_image){
                    //check for image directory
                    $path = public_path().'/product_uploads/'.$product->id.'/';

                    //delete old image from disk
                    if(File::exists($path.$product->product_image)){
                        File::delete($path.$product->product_image);
                    }

                    if(!File::exists($path)){
                        File::makeDirectory($path, 0777);
                    }

                    //upload image and move to folder on disk
                    $file_name = $product->slug . '_' . Str::random(2);
                    $file_extension = $product_image->getClientOriginalExtension();
                    $full_name = $file_name . '.' . $file_extension;

                    $file_uploaded = $product_image->move($path, $full_name);

                    //save to DB if uploaded
                    if($file_uploaded){
                        $product->product_image = $full_name;
                        $product->save();
                    }
                }
            }

            //redirect on finish
            return Redirect::to('admin/shop/proizvod/pregled/'.$product->slug)->with(['success' => 'Proizvod je uspješno izmjenjen.']);
        }
        else{
            return Redirect::to('admin/shop')->withErrors('Proizvod ne postoji.');
        }
    }

}