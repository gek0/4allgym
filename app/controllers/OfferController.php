<?php

class OfferController extends BaseController
{

    /**
     * CSRF validation on requests
     */
    public function __construct()
    {
        $this->beforeFilter('crfs', ['on' => ['post', 'put', 'patch', 'delete']]);
    }

    protected $offer_paginate = 9;

    /**
     * show offer omepage in admin area
     * @return mixed
     */
    public function showOfferIndexAdmin()
    {
        //get offers
        $offer_data = Offer::orderBy('id', 'DESC')->paginate($this->offer_paginate);

        return View::make('admin.ponuda.index')->with(['offer_data' => $offer_data]);
    }

    /**
     * show new offer form page
     * @return mixed
     */
    public function showNewOfferForm()
    {
        return View::make('admin.ponuda.nova');
    }

    /**
     * add new offer via POST data
     * @return mixed
     */
    public function addNewOffer()
    {
        //get form data
        $offer_images = Input::file('offer_images');
        $offer_data = ['offer_title' => e(Input::get('offer_title')), 'offer_body' => e(Input::get('offer_body'))];
        $success = true;
        $error_list = null;

        /*
         *  validation
         */
        $validator = Validator::make($offer_data, Offer::$rules, Offer::$messages);
        if($validator->fails()){
            $error_list = $validator->messages();
            $success = false;
        }

        if($offer_images == true){
            foreach($offer_images as $img){
                $validator_images = Validator::make(['images' => $img], OfferImage::$rules, OfferImage::$messages);
                if($validator_images->fails()){
                    $error_list = $validator->messages()->merge($validator_images->messages());
                    $success = false;
                }
            }
        }

        //store to database if no errors
        if($success == true){
            $offer = new Offer;
            $offer->offer_title = $offer_data['offer_title'];
            $offer->offer_body = $offer_data['offer_body'];
            $offer->save();

            $offer_name = safe_name($offer->offer_title);

            //slug regenerate - croatian letter fix
            $offer->slug = string_like_slug(safe_name(Input::get('offer_title')));
            $offer->save();

            //images
            if($offer_images == true && $offer_images[0] != null){
                //check for image directory
                $path = public_path().'/offers_uploads/'.$offer->id.'/';
                if(!File::exists($path)){
                    File::makeDirectory($path, 0777);
                }

                foreach($offer_images as $img){
                    $file_name = substr($offer_name, 0, 15).'_'.Str::random(5);
                    $file_extension = $img->getClientOriginalExtension();
                    $full_name = $file_name.'.'.$file_extension;
                    $file_size = $img->getSize();

                    $file_uploaded = $img->move($path, $full_name);

                    if($file_uploaded){
                        $image = new OfferImage;
                        $image->file_name = $full_name;
                        $image->file_size = $file_size;
                        $image->offer_id = $offer->id;
                        $image->save();
                    }
                }
            }

            //redirect on finish
            return Redirect::to('admin/ponuda/pregled/'.$offer->slug)->with(['success' => 'Usluga je uspješno dodana u ponudu.']);

        }
        else{
            return Redirect::to('admin/ponuda/dodaj')->withErrors($error_list)->withInput();
        }
    }

    /**
     * show individual offer page in admin area
     * @param null $slug
     * @return mixed
     */
    public function showOfferAdmin($slug = null)
    {
        if ($slug !== null){
            $offer_data = Offer::findBySlug(e($slug));

            //check if offer exists
            if($offer_data){
                return View::make('admin.ponuda.pregled')->with(['offer_data' => $offer_data]);
            }
            else{
                return Redirect::to('admin/ponuda')->withErrors('Usluga ne postoji.');
            }
        }
        else{
            return Redirect::to('admin/ponuda')->withErrors('Usluga ne postoji.');
        }
    }

    /**
     * delete selected offer
     * @param null $slug
     * @return mixed
     */
    public function deleteOffer($slug = null)
    {
        //get offer
        $offer = Offer::findBySlug($slug);

        if($offer){
            try{
                //delete image from disk
                File::deleteDirectory(public_path().'/offers_uploads/'.$offer->id.'/');

                //delete data from database
                $offer->delete();

                return Redirect::to('admin/ponuda')->with(['success' => 'Usluga je uspješno obrisana.']);
            }
            catch(Exception $e){
                return Redirect::to('admin/ponuda/pregled/'.$slug)->withErrors('Usluga nije mogla biti obrisana.');
            }
        }
        else{
            return Redirect::to('admin/ponuda')->withErrors('Usluga ne postoji.');
        }
    }

    /**
     * Ajax delete image from offer image gallery
     * @return mixed
     */
    public function deleteOfferGalleryImage()
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
                $offer_image = OfferImage::find($image_id);
                $offer_id = $offer_image->offer_id;

                //delete image if exists and return JSON response
                if($offer_image){
                    try{
                        $file_name = public_path().'/offers_uploads/'.$offer_id.'/'.$offer_image->file_name;
                        if(File::exists($file_name)){
                            File::delete($file_name);
                        }
                        $offer_image->delete();

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
     * show offer edit page
     * @param null $slug
     * @return mixed
     */
    public function showOfferEditForm($slug = null){
        if($slug !== null){
            $offer_data = Offer::findBySlug(e($slug));

            //check if offer exists
            if($offer_data){
                return View::make('admin.ponuda.izmjena')->with(['offer_data' => $offer_data]);
            }
            else{
                return Redirect::to('admin/ponuda')->withErrors('Usluga ne postoji.');
            }
        }
        else{
            return Redirect::to('admin/ponuda')->withErrors('Usluga ne postoji.');
        }
    }

    /**
     * update offer via POST data
     * @param null $slug
     * @return mixed
     */
    public function updateOffer($slug = null)
    {
        if($slug !== null){
            $offer = Offer::findBySlug(e($slug));

            if($offer){
                //get form data
                $offer_images = Input::file('offer_images');
                $offer_data = ['offer_title' => e(Input::get('offer_title')), 'offer_body' => e(Input::get('offer_body'))];

                /*
                 *  validation
                 */
                $success = true;
                $error_list = null;

                $validator = Validator::make($offer_data, Offer::$rulesLessStrict, Offer::$messages);
                if($validator->fails()){
                    $error_list = $validator->messages();
                    $success = false;
                }

                if($offer_images == true){
                    foreach($offer_images as $img){
                        $validator_images = Validator::make(['images' => $img], OfferImage::$rules, OfferImage::$messages);
                        if($validator_images->fails()){
                            $error_list = $validator->messages()->merge($validator_images->messages());
                            $success = false;
                        }
                    }
                }

                //store changes to database if no errors
                if($success == true){
                    $offer->offer_title = $offer_data['offer_title'];
                    $offer->offer_body = $offer_data['offer_body'];
                    $offer->save();

                    $offer_name = safe_name($offer->offer_title);

                    //slug regenerate - croatian letter fix
                    $offer->slug = string_like_slug(safe_name(Input::get('offer_title')));
                    $offer->save();

                    //add new images
                    if($offer_images == true && $offer_images[0] != null){
                        //check for image directory
                        $path = public_path().'/offers_uploads/'.$offer->id.'/';
                        if(!File::exists($path)){
                            File::makeDirectory($path, 0777);
                        }

                        foreach($offer_images as $img){
                            $file_name = substr($offer_name, 0, 15).'_'.Str::random(5);
                            $file_extension = $img->getClientOriginalExtension();
                            $full_name = $file_name.'.'.$file_extension;
                            $file_size = $img->getSize();

                            $file_uploaded = $img->move($path, $full_name);

                            if($file_uploaded){
                                $image = new OfferImage;
                                $image->file_name = $full_name;
                                $image->file_size = $file_size;
                                $image->offer_id = $offer->id;
                                $image->save();
                            }
                        }
                    }


                    //redirect on finish
                    return Redirect::to('admin/ponuda/pregled/'.$offer->slug)->with(['success' => 'Usluga je uspješno izmjenjena.']);
                }
                else{
                    return Redirect::back()->withErrors($error_list)->withInput();
                }
            }
            else{
                return Redirect::to('admin/ponuda')->withErrors('Usluga ne postoji.');
            }
        }
        else{
            return Redirect::to('admin/ponuda')->withErrors('Usluga ne postoji.');
        }
    }

}