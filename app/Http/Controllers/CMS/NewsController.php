<?php

namespace App\Http\Controllers\CMS;

use App\News;
use Illuminate\Http\Request;

use Imageupload;

class NewsController extends CMSController
{
  public function index() {
    return view('cms.news.index', ['data' => News::orderBy('date')->get()]);
  }

  public function create() {
    return view('cms.news.form');
  }

  public function store(Request $request) {
    $this->check($request);
    
    $data = News::create([
        'title' => $request->get('title'),
        'content' => $request->get('content'),
        'date' => $request->get('date'),
    ]);

    $this->upload($request, $data);

    return redirect('cms/news')->with('success', "La noticia fué agregada correctamente.");
  }

  public function edit($id) {
    $data = News::find($id);

    if ($data == NULL) return redirect('cms/news')->with('error', "La noticia no existe.");

    return view('cms.news.form', compact('data'));
  }

  public function update(Request $request, $id) {
    $this->check($request);
    
    $data = News::find($id);
    
    $data->title = $request->get('title');
    $data->content = $request->get('content');
    $data->date = $request->get('date');

    if (!$this->upload($request, $data)) $data->save();

    return redirect('cms/news')->with('success', "La noticia fue actualizada correctamente.");
  }

  public function destroy($id) {
    $data = News::find($id);
    if (file_exists($data->image)) unlink($data->image);
    $data->delete();
    return redirect('cms/news')->with('success', "La noticia fue eliminada correctamente.");
  }

  function check(Request $request) {
    $request->validate([
      'title' => 'required|string|max:255',
      'content' => 'required|string',
      'date' => 'required|date',
    ]);
  }

  function upload(Request $request, News $data) {
    if (!$request->hasFile('image')) return false;

    if ($data->image != NULL && $data->image != "") unlink($data->image);
    if ($data->thumbnail != NULL && $data->thumbnail != "") unlink($data->thumbnail);

    $data->image = $this->copy_image($request->image->getRealPath(), $data->id);
    $data->thumbnail = $this->copy_image($request->image->getRealPath(), $data->id . '_thumbnail');
    $data->save();

    return true;
  }

  function copy_image($original, $destination_name) {
    $extension = pathinfo($original, PATHINFO_EXTENSION);
    $destination = 'uploads/news/'.$destination_name.'.'.$extension;
    
    copy($original, $destination);

    return $destination;
  }
}