<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;


class ActiveController extends Controller
{
	
	public function index()
	{
		$this->pageTitle = '活动列表';
		return $this->display('backend.active.list');
	}

}