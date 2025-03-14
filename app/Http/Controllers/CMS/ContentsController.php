<?php
namespace App\Http\Controllers\CMS;

use App\Content;
use Illuminate\Http\Request;

class ContentsController extends CMSController
{
  public function index() {
    return view('cms.contents.index', ['data' => Content::orderBy('title')->get()]);
  }

  public function edit($id) {
    $data = Content::find($id);

    if ($data == NULL) return redirect('cms/contents')->with('error', "El contenido no existe.");

    return view('cms.contents.form', compact('data'));
  }

  public function update(Request $request, $id) {
    $this->check($request);
    
    $data = Content::find($id);
    
    $data->title = $request->get('title');
    $data->content = $request->get('content');

    $data->save();

    return redirect('cms/contents')->with('success', "El contenido $data->title fue actualizado correctamente.");
  }

  function check(Request $request) {
    $request->validate([
      'title' => 'required|string|max:255'
    ]);
  }
}
