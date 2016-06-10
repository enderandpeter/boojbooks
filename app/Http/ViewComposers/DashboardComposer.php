<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;


class DashboardComposer
{
	/**
	 * Save a reference to the authenticted user instance
	 * 
	 * @var Request
	 */	
	protected $request;
	
	/**
	 * Prepare the user instance
	 * 
	 * @param App\Http\Requests\Request $request The http request
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
	}
	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view The view for this composer
	 * @return void
	 */
	public function compose(View $view)
	{		
		$view->with('userdata', [
			'booklists' => $this->request->user()->booklists
		]);
	}
}