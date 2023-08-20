<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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


    public function show($id){
        $transaction = Transaction::find($id);

        return view('pages.admin.transaction.show', compact('transaction'));
    }
    }
