<?php

namespace App\Http\Controllers\CMS;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends CMSController
{
  public function index() {
    return view('cms.users.index', ['data' => User::orderBy('name')->get()]);
  }

  public function create() {
    return view('cms.users.form');
  }

  public function store(Request $request) {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed',
    ]);
    
    $data = User::create([
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'password' => Hash::make($request->get('password')),
    ]);

    return redirect('cms/users')->with('success', "El usuario $data->name fue agregado correctamente.");
  }

  public function edit($id) {
    $data = User::find($id);

    if ($data == NULL) return redirect('cms/users')->with('error', "El usuario no existe.");

    return view('cms.users.form', compact('data'));
  }

  public function update(Request $request, $id) {
    $rules = [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,'.$id,
    ];

    if ($request->get('password') != NULL && $request->get('password') != "") {
      $rules['password'] = 'string|min:6|confirmed';
    }

    $request->validate($rules);
    
    $data = User::find($id);
    
    $data->name = $request->get('name');
    $data->email = $request->get('email');

    if ($request->get('password') != NULL && $request->get('password') != "") {
      $data->password = Hash::make($request->get('password'));
    }

    $data->save();

    return redirect('cms/users')->with('success', "El usuario $data->name fue actualizado correctamente.");
  }

  public function destroy($id) {
    $data = User::find($id);
    $data->delete();
    return redirect('cms/users')->with('success', "El usuario $data->name fue eliminado correctamente.");
  }
}
