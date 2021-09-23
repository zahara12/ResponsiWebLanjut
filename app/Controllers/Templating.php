<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Templating extends BaseController
{
	public function index()
	{

        return view('view_admin');
	}
}
