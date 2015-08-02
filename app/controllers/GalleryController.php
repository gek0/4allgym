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
     * show gallery homepage
     * @return mixed
     */
    public function showGallery()
    {
        return View::make('admin.gallery');
    }

}