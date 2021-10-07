<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class RegisterController extends BaseController
{
    public function __construct()
    {
        $this -> userModel = new UserModel();
    }
	public function index()
	{
		$data=[
            'title' => "Blog - Register",
        ];
        return view('v_register',$data);
	}
    public function saveRegister()
	{
		$request = service('request');
        $data = [
            'fullname' => $request ->getVar('fullname'),
            'email' => $request ->getVar('email'),
            'password' => $request ->getVar('password'),
        ];
        $this->userModel->insert($data);
        return redirect()->to('/register');
	}
}