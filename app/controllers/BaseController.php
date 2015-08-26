<?php

class BaseController extends Controller {

	/**
	 * CSRF validation on requests
	 */
	public function __construct()
	{
		$this->beforeFilter('crfs', ['on' => ['post', 'put', 'patch', 'delete']]);
	}

	/**
	 *	re-cache offer links in navigation if expired
     */
	protected function cacheCheck()
	{
		if (!Cache::has('offer_cache')) {
			$offer_data_cache = Offer::all();
			$offer_data_array = array();

			foreach ($offer_data_cache as $key => $offer) {
				$offer_data_array[$key] = $offer;
			}

			Cache::put('offer_cache', $offer_data_array, 1440);	//cache for 1 day
		}
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
