<?php

namespace App\Http\Controllers\CMS;

use App\BudgetRequest;
use App\Office;
use Illuminate\Http\Request;

class BudgetsController extends CMSController
{
  public function index() {
    $query = BudgetRequest::orderBy('created_at', 'desc');
    if (isset($_GET['office_id']) && $_GET['office_id'] > 0) $query = $query->where('office_id', $_GET['office_id']);
    $data = $query->get();
    $offices = Office::where('type', 'branch_offices')->get();
    return view('cms.budgets.index', compact('data', 'offices'));
  }

  public function show($id) {
    $data = BudgetRequest::find($id);
    $status = BudgetRequest::$status;
    return view('cms.budgets.show', compact('data', 'status'));
  }

  public function update(Request $request, $id) {
    $data = BudgetRequest::find($id);
    
    $data->status = $request->get('status');

    $data->save();

    return redirect('cms/budgets/' . $id)->with('success', "El presupuesto fue actualizado correctamente.");
  }

  public function destroy($id) {
    $data = BudgetRequest::find($id);
    $data->delete();
    return redirect('cms/budgets')->with('success', "El presupuesto fue eliminado correctamente.");
  }
}
