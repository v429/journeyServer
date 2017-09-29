<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RoleAuth;
use App\Services\rbacService;

class ActiveController extends Controller
{
	
	public function index()
	{
		echo 'active list';
	}

}