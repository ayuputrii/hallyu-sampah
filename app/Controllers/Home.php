<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = "Landing Pages | Hallyu Sampah!";
        return view('landing-pages', $data);
    }
}
