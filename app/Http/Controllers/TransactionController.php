<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller 
{

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $transactions = Transaction::paginate(5);
    return view('pages.admin.transaction.index', compact('transactions'));
  }

  public function create()
  {
    // return view to create new transaction 
  }

  public function store(Request $request)
  {
    // validate request

    // create new transaction using request data

    // redirect with success message
  }

  public function show(string $id)
  {
    $transaction = Transaction::findOrFail($id);

    $transaction_details = TransactionDetail::with(['videos'])
      ->where('transaction_id', $transaction->id)
      ->get();

    return view('pages.admin.transaction.detail', compact('transaction', 'transaction_details'));
  }

  public function edit(string $id)
  {
    $transaction = Transaction::findOrFail($id);

    // return view to edit transaction
  }

  public function update(Request $request, string $id)
  {
    $transaction = Transaction::findOrFail($id);

    // validate request

    // update transaction using request data

    // redirect with success message
  }

  public function destroy(string $id)
  {
    $transaction = Transaction::findOrFail($id);

    // delete transaction

    // redirect with success message
  }

}