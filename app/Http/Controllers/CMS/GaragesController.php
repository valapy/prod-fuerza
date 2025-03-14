<?php

namespace App\Http\Controllers\CMS;

use Imageupload;

use App\Office;
use Illuminate\Http\Request;

class GaragesController extends CMSController
{
  public function index() {
    return view('cms.garages.index', ['data' => Office::where('type', 'garages')->orderBy('name')->get()]);
  }

  public function create() {
    return view('cms.garages.form');
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
        'type' => 'garages'
    ]);

    $this->upload($request, $data);

    return redirect('cms/garages')->with('success', "Los servicios y repuestos $data->name fue agregados correctamente.");
  }

  public function edit($id) {
    $data = Office::find($id);

    if ($data == NULL) return redirect('cms/garages')->with('error', "Los servicios y repuestos no existe.");

    return view('cms.garages.form', compact('data'));
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

    return redirect('cms/garages')->with('success', "Los servicios y repuestos $data->name fue actualizados correctamente.");
  }

  public function destroy($id) {
    $data = Office::find($id);
    $data->delete();
    return redirect('cms/garages')->with('success', "Los servicios y repuestos $data->name fue eliminados correctamente.");
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
