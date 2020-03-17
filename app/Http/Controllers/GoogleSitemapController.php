<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleSitemapController extends Controller
{
  public function index()
  {
    return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
  }

  public function pages()
  {
    return response()->view('sitemap.pages')->header('Content-Type', 'text/xml');
  }

}
