<?php

namespace App\Http\Controllers\Backend;

use App\Models\Admin;
use Illuminate\Routing\Controller as BaseController;

class ActiveController extends BaseController 
{
	
	public function index()
	{
		$admin = Admin::getAdmin();

		echo '<pre>';print_r($admin);
	}

}