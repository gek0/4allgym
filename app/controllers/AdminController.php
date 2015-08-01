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

}