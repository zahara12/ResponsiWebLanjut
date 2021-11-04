<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminPostController extends BaseController
{
	public function index()
	{
		$PostModel = model("PostModel");
		$data = [
			'posts' => $PostModel->findAll()
		];
		return view("posts/index", $data);
	}
	public function create()
    {
        session();
        $data = [
            'validation' => \Config\Services::validation(),
        ];
        return view ("posts/create", $data);
    }

    public function store()
    {
		$valid = $this->validate([
			"judul" => [
				"label" => "Judul",
				"rules" => "required",
				"errors" => [
					"required" => "{field} Harus Diisi!"
				]
			],
			"slug" => [
				"label" => "Slug",
				"rules" => "required|is_unique[posts.slug]",
				"errors" => [
					"required" => "{field} Harus Diisi!",
					"is_unique" => "{filed} sudah ada!"
				]
			],
			"kategori" => [
				"label" => "Kategori",
				"rules" => "required",
				"errors" => [
					"{field} Harus Diisi!"
				]
			],
			"author" => [
				"label" => "Author",
				"rules" => "required",
				"errors" => [
					"{field} Harus Diisi!"
				]
			],
			"deskripsi" => [
				"label" => "Deskripsi",
				"rules" => "required",
				"errors" => [
					"{field} Harus Diisi!"
				]
			]
		]);

		if ($valid) {
			$data = [
				'judul' => $this->request->getVar('judul'),
				'slug' => $this->request->getVar('slug'),
				'kategori' => $this->request->getVar('kategori'),
				'author' => $this->request->getVar('author'),
				'deskripsi' => $this->request->getVar('deskripsi'),
			];

			$PostModel = model("PostModel");
			$PostModel -> insert($data);
			return redirect()->to(base_url('/admin/posts/'));
		} else {
			return redirect()->to(base_url('/admin/posts/create'))->withInput()->with('validation', $this->validator);
		}
    }

	public function delete($slug)
	{
		$PostModel = model("PostModel");
		$PostModel->where('slug', $slug)->delete();
		return redirect()->to(base_url('/admin/posts/'));
		
	}

	public function edit($slug)
	{
		session();
		$PostModel = model("PostModel");
        $data = [
            'validation' => \Config\Services::validation(),
			'post' => $PostModel->where('slug', $slug)->first()
        ];
        return view ("posts/edit", $data);
	}


	public function update($slug)
	{
		$PostModel = model("PostModel");
		$data = $this->request->getPost();
		$PostModel->update($slug, $data);
		return redirect()->to(base_url('/admin/posts/'));
	}
}
