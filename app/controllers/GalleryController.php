<?php

class GalleryController extends BaseController{

    /**
     * CSRF validation on requests
     */
    public function __construct()
    {
        $this->beforeFilter('crfs', ['on' => ['post', 'put', 'patch', 'delete']]);
    }

    /**
     * show gallery homepage in admin area
     * @return mixed
     */
    public function showGalleryAdmin()
    {
        //get images and videos
        $image_data = Gallery::where('is_image', '=', 'yes')->get();
        $video_data = Gallery::where('is_image', '=', 'no')->get();

        return View::make('admin.gallery')->with(['image_data' => $image_data,
                                                    'video_data' => $video_data
                                                ]);
    }

    /**
     * show gallery homepage in public area
     * @return mixed
     */
    public function showGallery()
    {
        //get images and videos
        $image_data = Gallery::where('is_image', '=', 'yes')->get();
        $video_data = Gallery::where('is_image', '=', 'no')->get();

        return View::make('public.gallery')->with(['image_data' => $image_data,
                                                    'video_data' => $video_data
                                                ]);
    }

    /**
     * upload new files to gallery over POST request
     * @return mixed
     */
    public function uploadToGallery()
    {
        //get form data
        $gallery_data = Input::file('gallery_files');

        if($gallery_data == true && $gallery_data[0] != null){
            //check for image directory
            $path = public_path().'/gallery_uploads/';
            if(!File::exists($path)){
                File::makeDirectory($path, 0777);
            }

            $image_ext = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];

            foreach($gallery_data as $file){
                $file_extension = $file->getClientOriginalExtension();
                $full_name = Str::random(15).'.'.$file_extension;
                $file_size = $file->getSize();

                $file_uploaded = $file->move($path, $full_name);

                if($file_uploaded){
                    $image = new Gallery;
                    $image->file_name = $full_name;
                    $image->file_size = $file_size;
                    (in_array($file_extension, $image_ext) == true ? $image->is_image = 'yes' : $image->is_image = 'no');

                    $image->save();
                }
            }

            //redirect on finish
            return Redirect::to('admin/galerija')->with(['success' => 'Datoteke su uspješno dodane u galeriju.']);
        }
        else{
            return Redirect::to('admin/galerija')->withErrors('Dogodila se greška.');
        }
    }

    /**
     * Ajax delete file from gallery
     * @return mixed
     */
    public function deleteGalleryFile()
    {
        if(Request::ajax()){

            //get file ID and token
            $gallery_file_id = e(Input::get('fileData'));
            $token = Request::header('X-CSRF-Token');

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else{
                $gallery_file = Gallery::find($gallery_file_id);

                //delete file if exists and return JSON response
                if($gallery_file){
                    try{
                        $file_name = public_path().'/gallery_uploads/'.$gallery_file->file_name;
                        if(File::exists($file_name)){
                            File::delete($file_name);
                        }
                        $gallery_file->delete();

                        return Response::json(['status' => 'success']);
                    }
                    catch(Exception $e){
                        return Response::json(['status' => 'error',
                                                'errors' => 'Brisanje datoteke nije uspjelo.'
                                            ]);
                    }
                }
                else{
                    return Response::json(['status' => 'error',
                                            'errors' => 'Datoteke ne postoji.'
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