<?php

namespace App\Http\Controllers\Backend;

use App\Common\Utils;
use App\Http\Controllers\Controller;
use App\Services\rbacService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;


class ActiveController extends Controller
{
	
	public function index()
	{
		$tree = rbacService::getAuthTreeByAdminId();

		echo '<pre>';print_r($tree);
	}

}