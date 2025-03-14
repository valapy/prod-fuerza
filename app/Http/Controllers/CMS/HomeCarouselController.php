<?php

namespace App\Http\Controllers\CMS;

use App\HomeCarousel;
use Illuminate\Http\Request;

use Imageupload;

class HomeCarouselController extends CMSController
{
  public function index() {
    return view('cms.home_carousel.index', ['data' => HomeCarousel::orderBy('name')->get()]);
  }

  public function create() {
    return view('cms.home_carousel.form');
  }

  public function store(Request $request) {
    $this->check($request);
    
    $data = HomeCarousel::create([
        'name' => $request->get('name'),
        'url' => $request->get('url'),
    ]);

    $this->upload($request, $data);

    return redirect('cms/home_carousel')->with('success', "La imágen fue agregada correctamente.");
  }

  public function edit($id) {
    $data = HomeCarousel::find($id);

    if ($data == NULL) return redirect('cms/home_carousel')->with('error', "La imágen no existe.");

    return view('cms.home_carousel.form', compact('data'));
  }

  public function update(Request $request, $id) {
    $this->check($request);
    
    $data = HomeCarousel::find($id);
    
    $data->name = $request->get('name');
    $data->url = $request->get('url');

    $this->upload($request, $data);

    $data->save();

    return redirect('cms/home_carousel')->with('success', "La imágen fue actualizada correctamente.");
  }

  public function destroy($id) {
    $data = HomeCarousel::find($id);
    if (file_exists($data->media)) unlink($data->media);
    $data->delete();
    return redirect('cms/home_carousel')->with('success', "La imágen fue eliminada correctamente.");
  }

  function check(Request $request) {
    $request->validate([
      'name' => 'required|string|max:255',
    ]);
  }

  function upload(Request $request, HomeCarousel $data) {
    if ($request->hasFile('media')) {
      parent::delete_file($data->media);
      $data->media = parent::file_upload($request->media, "home_carousel/{$data->id}");
      $data->save();
    }

    if ($request->hasFile('media_mobile')) {
      parent::delete_file($data->media_mobile);
      $data->media_mobile = parent::file_upload($request->media_mobile, "home_carousel/{$data->id}_mobile");
      $data->save();
    }

    return true;
  }
}