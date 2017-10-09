<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\rbacService;

class ActiveController extends Controller
{
	
	public function index()
	{
		$tree = rbacService::getAuthTreeByAdminId();

		echo '<pre>';print_r($tree);
	}

}