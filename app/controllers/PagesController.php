<?php

class PagesController extends BaseController
{

    /**
     * CSRF validation on requests
     */
    public function __construct()
    {
        $this->beforeFilter('crfs', ['on' => ['post', 'put', 'patch', 'delete']]);
    }

    /**
     * show cage football page in admin area
     * @return mixed
     */
    public function showCageFootballAdmin()
    {
        //get cage football data and all images
        $cage_football_data = Pages::where('page_uri', '=', Route::currentRouteName())->first();
        $cage_football_images = PagesImage::where('page_id', '=', $cage_football_data->id)->get();

        return View::make('admin.cage-football')->with(['cage_football_data' => $cage_football_data,
                                                        'cage_football_images' => $cage_football_images
                                                    ]);
    }

    /**
     * show caffe bar page in admin area
     * @return mixed
     */
    public function showCaffeBarAdmin()
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
}