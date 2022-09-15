<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function show(Transaction $transaction): View
    {

        return view('transactions.show', compact('transaction'));
    }
}
