<?php

namespace App\Http\Controllers\CMS;

use Imageupload;

use App\Office;
use Illuminate\Http\Request;

class BranchOfficesController extends CMSController
{
  public function index() {
    return view('cms.branch_offices.index', ['data' => Office::where('type', 'branch_offices')->orderBy('name')->get()]);
  }

  public function create() {
    return view('cms.branch_offices.form');
  }

  public function store(Request $request) {
    $this->check($request);
    
    $data = Office::create([
        'name' => $request->get('name'),
        'address' => $request->get('address'),
        'phone' => $request->get('phone'),
        'email' => $request->get('email'),
        'lat' => $request->get('lat'),
        'lng' => $request->get('lng'),
        'type' => 'branch_offices'
    ]);

    $this->upload($request, $data);

    return redirect('cms/branch_offices')->with('success', "La concesionaria $data->name fue agregada correctamente.");
  }

  public function edit($id) {
    $data = Office::find($id);

    if ($data == NULL) return redirect('cms/branch_offices')->with('error', "La concesionaria no existe.");

    return view('cms.branch_offices.form', compact('data'));
  }

  public function update(Request $request, $id) {
    $this->check($request);
    
    $data = Office::find($id);
    
    $data->name = $request->get('name');
    $data->address = $request->get('address');
    $data->phone = $request->get('phone');
    $data->email = $request->get('email');
    $data->lat = $request->get('lat');
    $data->lng = $request->get('lng');

    $data->save();

    $this->upload($request, $data);

    return redirect('cms/branch_offices')->with('success', "La concesionaria $data->name fue actualizada correctamente.");
  }

  public function destroy($id) {
    $data = Office::find($id);
    $data->delete();
    return redirect('cms/branch_offices')->with('success', "La concesionaria $data->name fue eliminada correctamente.");
  }

  function check(Request $request) {
    $request->validate([
      'name' => 'required|string|max:255',
      'address' => 'required|string|max:255',
      'lat' => 'required',
      'lng' => 'required',
    ]);
  }

  function upload(Request $request, Office $data) {
    if (!$request->hasFile('image')) return false;

    if ($data->image != NULL && $data->image != "") unlink($data->image);
    if ($data->thumbnail != NULL && $data->thumbnail != "") unlink($data->thumbnail);

    $result = Imageupload::upload($request->file('image'));

    $data->image = $this->copy_image($result['dimensions']['size476x336']['filepath'], $data->id);
    $data->save();

    unlink($result['original_filepath']);

    foreach ($result['dimensions'] as $value):
      unlink($value['filepath']);
    endforeach;

    return true;
  }

  function copy_image($original, $destination_name) {
    $extension = pathinfo($original, PATHINFO_EXTENSION);
    $destination = 'uploads/offices/'.$destination_name.'.'.$extension;
    
    copy($original, $destination);

    return $destination;
  }
}
