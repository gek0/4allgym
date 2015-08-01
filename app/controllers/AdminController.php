<?php

class AdminController extends BaseController{

    /**
     * CSRF validation on requests
     */
    public function __construct()
    {
        $this->beforeFilter('crfs', ['on' => ['post', 'put', 'patch', 'delete']]);
    }

    /**
     * show admin homepage
     * @return mixed
     */
    public function showHome()
    {
        return View::make('admin.index');
    }

    /**
     * show admin user settings page
     * @return mixed
     */
    public function showUserSettings()
    {
        //get current user data
        $user_data = User::findOrFail(Auth::user()->id);

        //get all users data
        $all_users_data = User::orderBy('username', 'ASC')->get();

        return View::make('admin.user-settings')->with(['user_data' => $user_data,
                                                        'all_users_data' => $all_users_data
                                                        ]);
    }

    /**
     * update user account data
     * @return mixed
     */
    public function updateUserSettings()
    {
        if (Request::ajax()){

            //get user input data
            $input_data = Input::get('formData');
            $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
            $user_data = ['username' => $input_data['username'],
                            'email' => $input_data['email'],
                            'password' => $input_data['password'],
                            'password_again' => $input_data['password_again'],
                        ];

            //validation
            $validator = Validator::make($user_data, User::$rulesLessStrict, User::$messages);

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                //check validation results and save user if ok
                if($validator->fails()){
                    return Response::json(['status' => 'error',
                                            'errors' => $validator->getMessageBag()->toArray()
                                        ]);
                }
                else{
                    $user = User::find(Auth::user()->id);
                    $user->username = e($user_data['username']);
                    $user->email = e($user_data['email']);
                    
                    //change user password if new is in input
                    if(strlen($user_data['password']) > 0) {
                        $user->password = Hash::make($user_data['password']);
                    }
                    $user->save();

                    return Response::json(['status' => 'success']);
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
     * create new user account
     * @return mixed
     */
    public function addNewUser()
    {
        if (Request::ajax()){

            //get user input data
            $input_data = Input::get('formData');
            $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
            $user_data = ['username' => $input_data['newUsername'],
                            'email' => $input_data['newEmail'],
                            'password' => $input_data['newPassword'],
                            'password_again' => $input_data['newPasswordAgain'],
                        ];

            //validation
            $validator = Validator::make($user_data, User::$rules, User::$messages);

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                //check validation results and save user if ok
                if($validator->fails()){
                    return Response::json(['status' => 'error',
                                            'errors' => $validator->getMessageBag()->toArray()
                                        ]);
                }
                else{
                    $user = new User;
                    $user->username = e($user_data['username']);
                    $user->email = e($user_data['email']);
                    $user->password = Hash::make($user_data['password']);
                    $user->save();

                    return Response::json(['status' => 'success']);
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
     * delete user
     * @return mixed
     */
    public function deleteUser()
    {
        if(Request::ajax()){

            //get category ID and token
            $user_id = e(Input::get('userData'));
            $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                $user = User::findOrFail($user_id);

                //delete user if exists and return JSON response
                if($user){
                    //check if user is admin
                    if($user->id == 1){
                        return Response::json(['status' => 'error',
                            'errors' => 'Administrator se ne može obrisati.'
                        ]);
                    }

                    //try to delete user
                    try{
                        $user->delete();

                        return Response::json(['status' => 'success']);
                    }
                    catch(Exception $e){
                        return Response::json(['status' => 'error',
                                                'errors' => 'Brisanje korisnika nije uspjelo.'
                                            ]);
                    }
                }
                else{
                    return Response::json(['status' => 'error',
                                            'errors' => 'Korisnik ne postoji.'
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
     * show cage football page
     * @return mixed
     */
    public function showCageFootball()
    {
        //get cage football data and all images
        $cage_football_data = Pages::where('page_uri', '=', Route::currentRouteName())->first();
        $cage_football_images = PagesImage::where('page_id', '=', $cage_football_data->id)->get();

        return View::make('admin.cage-football')->with(['cage_football_data' => $cage_football_data,
                                                            'cage_football_images' => $cage_football_images
                                                    ]);
    }

    /**
     * show caffe bar page
     * @return mixed
     */
    public function showCaffeBar()
    {
        //get caffe bar data and all images
        $caffe_bar_data = Pages::where('page_uri', '=', Route::currentRouteName())->first();
        $caffe_bar_images = PagesImage::where('page_id', '=', $caffe_bar_data->id)->get();

        return View::make('admin.caffe-bar')->with(['caffe_bar_data' => $caffe_bar_data,
                                                        'caffe_bar_images' => $caffe_bar_images
                                                    ]);
    }

    /**
     * @return mixed
     * post data for updating cage football page
     * page ID = 1
     */
    public function updateCageFootball()
    {
        //get form data
        $cage_football_images = Input::file('cage_football_images');
        $cage_football_data = ['page_title' => e(Input::get('page_title')), 'page_text' => e(Input::get('page_text'))];
        $page_uri = e(Input::get('page_uri'));
        $success = true;
        $error_list = null;

        /*
         *  validation
         */
        $validator = Validator::make($cage_football_data, Pages::$rules, Pages::$messages);
        if($validator->fails()){
            $error_list = $validator->messages();
            $success = false;
        }

        if($cage_football_images == true){
            foreach($cage_football_images as $img){
                $validator_images = Validator::make(['images' => $img], PagesImage::$rules, PagesImage::$messages);
                if($validator_images->fails()){
                    $error_list = $validator->messages()->merge($validator_images->messages());
                    $success = false;
                }
            }
        }


        //store to database if no errors
        if($success == true){
            $page = Pages::where('page_uri', '=', $page_uri)->first();
            $page->page_title = $cage_football_data['page_title'];
            $page->page_text = $cage_football_data['page_text'];
            $page->page_uri = $page_uri;
            $page->save();

            $page_name = safe_name($page->page_title);

            //images
            if($cage_football_images == true && $cage_football_images[0] != null){
                $path = public_path().'/pages_uploads/';

                $num_of_images_db = PagesImage::where('page_id', '=', 1)->count();  //hardcoded value for page -> 1
                $num_of_images = count($cage_football_images);

                for($i = 0; $i < $num_of_images; $i++){
                    $file_name = substr($page_name, 0, 15).'_'.Str::random(5);
                    $file_extension = $cage_football_images[$i]->getClientOriginalExtension();
                    $full_name = $file_name.'.'.$file_extension;
                    $file_size = $cage_football_images[$i]->getSize();

                    $file_uploaded = $cage_football_images[$i]->move($path, $full_name);

                    if($file_uploaded){
                        $image = new PagesImage;
                        $image->file_name = $full_name;
                        $image->file_size = $file_size;
                        $image->page_id = $page->id;

                        //set image as primary if first in db, as default fallback
                        if($num_of_images_db <= 0){
                            $image->is_primary = 'yes';
                            $num_of_images_db++;
                        }

                        $image->save();
                    }
                }
            }

            //redirect on finish
            return Redirect::to('admin/cage-football')->with(['success' => 'Stranica je uspješno izmjenjena.']);

        }
        else{
            return Redirect::to('admin/cage-football')->withErrors($error_list)->withInput();
        }    
    }

    /**
     * @return mixed
     * post data for updating caffe bar page
     * page ID = 2
     */
    public function updateCaffeBar()
    {
        //get form data
        $caffe_bar_images = Input::file('caffe_bar_images');
        $caffe_bar_data = ['page_title' => e(Input::get('page_title')), 'page_text' => e(Input::get('page_text'))];
        $page_uri = e(Input::get('page_uri'));
        $success = true;
        $error_list = null;

        /*
         *  validation
         */
        $validator = Validator::make($caffe_bar_data, Pages::$rules, Pages::$messages);
        if($validator->fails()){
            $error_list = $validator->messages();
            $success = false;
        }

        if($caffe_bar_images == true){
            foreach($caffe_bar_images as $img){
                $validator_images = Validator::make(['images' => $img], PagesImage::$rules, PagesImage::$messages);
                if($validator_images->fails()){
                    $error_list = $validator->messages()->merge($validator_images->messages());
                    $success = false;
                }
            }
        }


        //store to database if no errors
        if($success == true){
            $page = Pages::where('page_uri', '=', $page_uri)->first();
            $page->page_title = $caffe_bar_data['page_title'];
            $page->page_text = $caffe_bar_data['page_text'];
            $page->page_uri = $page_uri;
            $page->save();

            $page_name = safe_name($page->page_title);

            //images
            if($caffe_bar_images == true && $caffe_bar_images[0] != null){
                $path = public_path().'/pages_uploads/';

                $num_of_images_db = PagesImage::where('page_id', '=', 2)->count();  //hardcoded value for page -> 2
                $num_of_images = count($caffe_bar_images);

                for($i = 0; $i < $num_of_images; $i++){
                    $file_name = substr($page_name, 0, 15).'_'.Str::random(5);
                    $file_extension = $caffe_bar_images[$i]->getClientOriginalExtension();
                    $full_name = $file_name.'.'.$file_extension;
                    $file_size = $caffe_bar_images[$i]->getSize();

                    $file_uploaded = $caffe_bar_images[$i]->move($path, $full_name);

                    if($file_uploaded){
                        $image = new PagesImage;
                        $image->file_name = $full_name;
                        $image->file_size = $file_size;
                        $image->page_id = $page->id;

                        //set image as primary if first in db, as default fallback
                        if($num_of_images_db <= 0){
                            $image->is_primary = 'yes';
                            $num_of_images_db++;
                        }

                        $image->save();
                    }
                }
            }

            //redirect on finish
            return Redirect::to('admin/caffe-bar')->with(['success' => 'Stranica je uspješno izmjenjena.']);

        }
        else{
            return Redirect::to('admin/caffe-bar')->withErrors($error_list)->withInput();
        }    
    }    

    /**
     * Ajax image delete from image gallery
     * @return mixed
     */
    public function deleteGalleryImage()
    {
        if(Request::ajax()){

            //get image ID and token
            $image_id = e(Input::get('imageData'));
            $token = Request::header('X-CSRF-Token');

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                $image = PagesImage::find($image_id);
  
                //delete image if exists and return JSON response
                if($image){
                    try{
                        $file_name = public_path().'/pages_uploads/'.$image->file_name;
                        if(File::exists($file_name)){
                            File::delete($file_name);
                        }

                        $image->delete();

                        return Response::json(['status' => 'success']);
                    }
                    catch(Exception $e){
                        return Response::json(['status' => 'error',
                                                'errors' => 'Brisanje slike nije uspjelo.'
                                            ]);
                    }
                }
                else{
                    return Response::json(['status' => 'error',
                                            'errors' => 'Slika ne postoji.'
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
     * Ajax set primary image from image gallery
     * @return mixed
     */
    public function setPrimaryGalleryImage()
    {
        if(Request::ajax()){

            //get image ID and token
            $image_id = e(Input::get('imageData'));
            $token = Request::header('X-CSRF-Token');

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                $image = PagesImage::find($image_id);
  
                //check if image exists
                if($image){
                    $images = PagesImage::where('page_id', '=', $image->page_id)->get();

                    foreach($images as $img){
                        $img->is_primary = 'no';
                        $img->save();
                    }

                    //after setting all images as not primary, set selected as primary
                    $image->is_primary = 'yes';
                    $image->save();
                    

                    return Response::json(['status' => 'success']);
                }
                else{
                    return Response::json(['status' => 'error',
                                            'errors' => 'Slika ne postoji.'
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
     * show news portal homepage
     * @return mixed
     */
    public function showNewsPortal()
    {
        //get news
        $news_data = News::orderBy('id', 'DESC')->paginate(9);

        return View::make('admin.portal.index')->with(['news_data' => $news_data]);
    }

    /**
     * show new news form page
     * @return mixed
     */
    public function showNewNewsForm()
    {
        //get all tags for input suggestion
        $tag_collection = Tag::distinct()->select('tag')->get();

        return View::make('admin.portal.nova')->with(['tag_collection' => $tag_collection]);
    }

    /**
     * add new news via POST data
     * @return mixed
     */
    public function addNewNews()
    {
        //get form data
        $news_images = Input::file('news_images');
        $news_tags = Input::get('tags');
        $news_data = ['news_title' => e(Input::get('news_title')), 'news_body' => e(Input::get('news_body'))];
        $success = true;
        $error_list = null;

        //remove duplicate tags if any
        if($news_tags == true){
            $news_tags_unique = array_unique($news_tags, SORT_STRING);
        }
        else{
            $news_tags_unique = false;
        }

        /*
         *  validation
         */
        $validator = Validator::make($news_data, News::$rules, News::$messages);
        if($validator->fails()){
            $error_list = $validator->messages();
            $success = false;
        }

        if($news_images == true){
            foreach($news_images as $img){
                $validator_images = Validator::make(['images' => $img], NewsImage::$rules, NewsImage::$messages);
                if($validator_images->fails()){
                    $error_list = $validator->messages()->merge($validator_images->messages());
                    $success = false;
                }
            }
        }

        if($news_tags_unique == true){
            foreach($news_tags_unique as $tags){
                $validator_tags = Validator::make(['tag' => $tags], Tag::$rules, Tag::$messages);
                if($validator_tags->fails()){
                    $error_list = $validator->messages()->merge($validator_tags->messages());
                    $success = false;
                }
            }
        }

        //store to database if no errors
        if($success == true){
            $news = new News;
            $news->news_title = $news_data['news_title'];
            $news->news_body = $news_data['news_body'];
            $news->news_author = Auth::user()->id;
            $news->save();

            $news_name = safe_name($news->news_title);

            //slug regenerate - croatian letter fix
            $news->slug = string_like_slug(safe_name(Input::get('news_title')));
            $news->save();

            //tags
            if($news_tags_unique == true){
                foreach($news_tags_unique as $tags){
                    $new_tag = string_like_slug(safe_name($tags));
                    $db_tag = DB::table('tags')->where('tags.slug', '=', $new_tag)->first();

                    //if tag is not found in database - add it
                    if(!$db_tag){
                        $tag = new Tag;
                        $tag->tag = safe_name($tags);
                        $news->tags()->save($tag);
                    }
                    else{   //if found - attach it to news
                        $news->tags()->attach($db_tag->id);
                    }
                }
            }

            //images
            if($news_images == true && $news_images[0] != null){
                //check for image directory
                $path = public_path().'/news_uploads/'.$news->id.'/';
                if(!File::exists($path)){
                    File::makeDirectory($path, 0777);
                }

                foreach($news_images as $img){
                    $file_name = substr($news_name, 0, 15).'_'.Str::random(5);
                    $file_extension = $img->getClientOriginalExtension();
                    $full_name = $file_name.'.'.$file_extension;
                    $file_size = $img->getSize();

                    $file_uploaded = $img->move($path, $full_name);

                    if($file_uploaded){
                        $image = new NewsImage;
                        $image->file_name = $full_name;
                        $image->file_size = $file_size;
                        $image->news_id = $news->id;
                        $image->save();
                    }
                }
            }

            //redirect on finish
            return Redirect::to('admin/portal/pregled/'.$news->slug)->with(['success' => 'Vijest je uspješno dodana.']);

        }
        else{
            return Redirect::to('admin/portal/dodaj')->withErrors($error_list)->withInput();
        }
    }

    /**
     * show individual news page
     * @param null $slug
     * @return mixed
     */
    public function showNews($slug = null)
    {
        if ($slug !== null){
            $news_data = News::findBySlug(e($slug));

            //check if news exists
            if($news_data){
                return View::make('admin.portal.pregled')->with(['news_data' => $news_data]);
            }
            else{
                return Redirect::to('admin/portal')->withErrors('Vijest ne postoji.');
            }
        }
        else{
            return Redirect::to('admin/portal')->withErrors('Vijest ne postoji.');
        }
    }

    /**
     * show news edit page
     * @param null $slug
     * @return mixed
     */
    public function showNewsEditForm($slug = null){
        if($slug !== null){
            $news_data = News::findBySlug(e($slug));

            //check if news exists
            if($news_data){
                //check if news has tags
                $tags = [];
                if($news_data->tags){
                    foreach($news_data->tags as $tag){
                        $tags[] = $tag->tag;
                    }
                    $tags = json_encode($tags);
                }

                //get all tags for input suggestion
                $tag_collection = Tag::distinct()->select('tag')->get();
                return View::make('admin.portal.izmjena')->with(['news_data' => $news_data,
                                                                    'news_tags' => $tags,
                                                                    'tag_collection' => $tag_collection
                                                                ]);
            }
            else{
                return Redirect::to('admin/portal')->withErrors('Vijest ne postoji.');
            }
        }
        else{
            return Redirect::to('admin/portal')->withErrors('Vijest ne postoji.');
        }
    }

    /**
     * update news via POST data
     * @param null $slug
     * @return mixed
     */
    public function updateNews($slug = null)
    {
        if($slug !== null){
            $news = News::findBySlug(e($slug));

            if($news){
                //get form data
                $news_images = Input::file('news_images');
                $news_tags = Input::get('tags');
                $news_data = ['news_title' => e(Input::get('news_title')), 'news_body' => e(Input::get('news_body'))];


                /*
                 *  tags
                */
                if($news_tags){ //remove same tags from array
                    $news_tags = array_unique($news_tags, SORT_STRING);
                }

                $old_tags = DB::table('tags')->leftJoin('news_tag', 'tags.id', '=', 'news_tag.tag_id')
                                                ->select('news_tag.tag_id', 'tags.tag')
                                                ->where('news_tag.news_id', '=', $news->id)
                                                ->get();

                //compare new tags from form and old ones from db
                if($old_tags){
                    if($news_tags){
                        foreach($old_tags as $tags){
                            //delete tags from db if removed in form
                            if(!in_array($tags->tag, $news_tags)){
                                //check if other news is using same tag
                                $tag_counter = DB::table('tags')->join('news_tag', 'tags.id', '=', 'news_tag.tag_id')
                                                                ->where('news_tag.tag_id', '=', $tags->tag_id)
                                                                ->count();
                                $news->tags()->detach($tags->tag_id);

                                //delete tag if no news uses it
                                if($tag_counter <= 1) {
                                    Tag::where('id', '=', $tags->tag_id)->delete();
                                }
                            }
                            else{
                                if(($key = array_search($tags->tag, $news_tags)) !== false) {
                                    unset($news_tags[$key]);    //duplicate tag - delete from new array if already in database
                                }
                            }
                        }
                    }
                    else{   //delete all tags from db
                        foreach($old_tags as $tags){
                            //check if other news is using same tag
                            $tag_counter = DB::table('tags')->join('news_tag', 'tags.id', '=', 'news_tag.tag_id')
                                                            ->where('news_tag.tag_id', '=', $tags->tag_id)
                                                            ->count();
                            $news->tags()->detach($tags->tag_id);

                            //delete tag if no news uses it
                            if($tag_counter <= 1) {
                                Tag::where('id', '=', $tags->tag_id)->delete();
                            }
                        }
                    }
                }


                /*
                 *  validation
                 */
                $success = true;
                $error_list = null;

                $validator = Validator::make($news_data, News::$rulesLessStrict, News::$messages);
                if($validator->fails()){
                    $error_list = $validator->messages();
                    $success = false;
                }

                if($news_images == true){
                    foreach($news_images as $img){
                        $validator_images = Validator::make(['images' => $img], NewsImage::$rules, NewsImage::$messages);
                        if($validator_images->fails()){
                            $error_list = $validator->messages()->merge($validator_images->messages());
                            $success = false;
                        }
                    }
                }

                if($news_tags == true){
                    foreach($news_tags as $tags){
                        $validator_tags = Validator::make(['tag' => $tags], Tag::$rules, Tag::$messages);
                        if($validator_tags->fails()){
                            $error_list = $validator->messages()->merge($validator_tags->messages());
                            $success = false;
                        }
                    }
                }

                //store changes to database if no errors
                if($success == true){
                    $news->news_title = $news_data['news_title'];
                    $news->news_body = $news_data['news_body'];
                    $news->save();

                    $news_name = safe_name($news->news_title);

                    //slug regenerate - croatian letter fix
                    $news->slug = string_like_slug(safe_name(Input::get('news_title')));
                    $news->save();

                    //add new tags if any
                    if($news_tags){
                        foreach($news_tags as $tags){
                            $new_tag = string_like_slug(safe_name($tags));
                            $db_tag = DB::table('tags')->where('tags.slug', '=', $new_tag)->first();

                            //if tag is not found in database - add it
                            if(!$db_tag){
                                $tag = new Tag;
                                $tag->tag = safe_name($tags);
                                $news->tags()->save($tag);
                            }
                            else{   //if found - attach it to news
                                $news->tags()->attach($db_tag->id);
                            }
                        }
                    }

                    //add new images
                    if($news_images == true && $news_images[0] != null){
                        //check for image directory
                        $path = public_path().'/news_uploads/'.$news->id.'/';
                        if(!File::exists($path)){
                            File::makeDirectory($path, 0777);
                        }

                        foreach($news_images as $img){
                            $file_name = substr($news_name, 0, 15).'_'.Str::random(5);
                            $file_extension = $img->getClientOriginalExtension();
                            $full_name = $file_name.'.'.$file_extension;
                            $file_size = $img->getSize();

                            $file_uploaded = $img->move($path, $full_name);

                            if($file_uploaded){
                                $image = new NewsImage;
                                $image->file_name = $full_name;
                                $image->file_size = $file_size;
                                $image->news_id = $news->id;
                                $image->save();
                            }
                        }
                    }


                    //redirect on finish
                    return Redirect::to('admin/portal/pregled/'.$news->slug)->with(['success' => 'Vijest je uspješno izmjenjena.']);
                }
                else{
                    return Redirect::back()->withErrors($error_list)->withInput();
                }
            }
            else{
                return Redirect::to('admin/portal')->withErrors('Vijest ne postoji.');
            }
        }
        else{
            return Redirect::to('admin/portal')->withErrors('Vijest ne postoji.');
        }
    }

    /**
     * Ajax delete image from news image gallery
     * @return mixed
     */
    public function deleteNewsGalleryImage()
    {
        if(Request::ajax()){

            //get image ID and token
            $image_id = e(Input::get('imageData'));
            $token = Request::header('X-CSRF-Token');

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                $news_image = NewsImage::find($image_id);
                $news_id = $news_image->news_id;

                //delete image if exists and return JSON response
                if($news_image){
                    try{
                        $file_name = public_path().'/news_uploads/'.$news_id.'/'.$news_image->file_name;
                        if(File::exists($file_name)){
                            File::delete($file_name);
                        }
                        $news_image->delete();

                        return Response::json(['status' => 'success']);
                    }
                    catch(Exception $e){
                        return Response::json(['status' => 'error',
                                                'errors' => 'Brisanje slike nije uspjelo.'
                                            ]);
                    }
                }
                else{
                    return Response::json(['status' => 'error',
                                            'errors' => 'Slika ne postoji.'
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
     * delete news and all associated data
     * @param null $slug
     * @return mixed
     */
    public function deleteNews($slug = null)
    {
        if($slug !== null){
            $news = News::findBySlug(e($slug));

            //check if news exists
            if($news){
                try{
                    //get all news tags, if tag is unique to news - delete from DB
                    $tags_array = $news->tags;
                    $tags_to_delete = [];

                    foreach($tags_array as $tag){
                        $tag_counter = DB::table('tags')->join('news_tag', 'tags.id', '=', 'news_tag.tag_id')
                                                        ->where('news_tag.tag_id', '=', $tag->id)
                                                        ->count();

                        if($tag_counter == 1){
                            $tags_to_delete[] = $tag->id;
                        }
                    }

                    //delete data from database
                    $news->delete();

                    //delete tags if any
                    if(count($tags_to_delete) > 0){
                        Tag::whereIn('id', $tags_to_delete)->delete();
                    }

                    //delete images from disk
                    File::deleteDirectory(public_path().'/news_uploads/'.$news->id.'/');

                    return Redirect::to('admin/portal')->with(['success' => 'Vijest je uspješno obrisana.']);
                }
                catch(Exception $e){
                    return Redirect::to('admin/portal/pregled/'.$slug)->withErrors('Vijest nije mogla biti obrisana.');
                }
            }
            else{
                return Redirect::to('admin/portal')->withErrors('Vijest ne postoji.');
            }
        }
        else{
            return Redirect::to('admin/portal')->withErrors('Vijest ne postoji.');
        }
    }


}