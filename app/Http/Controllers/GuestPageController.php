<?php

namespace App\Http\Controllers;
use App\Models\Thesis;
use Illuminate\Http\Request;

class GuestPageController extends Controller
{
  public function index()
  {
    $theses=Thesis::latest()->filter(request(['search','user','school']))->paginate(7)->withQueryString();
    return view('guest.search.index', compact('theses'));
  }
  public function show($thesis_id)
  {
    $thesis = Thesis::findOrFail($thesis_id);
    return view('guest.thesis.show', compact('thesis'));
  }
}
