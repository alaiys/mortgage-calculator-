<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    public function getBanks(): \Illuminate\Http\JsonResponse {
        $banks = Bank::all();
        return response()->json([
            'banks' => $banks
        ], 200);
    }

    public function addBank(Request $request) {
        $bank = new Bank();
        $bank->name = $request->name;
        $bank->interest_rate = $request->interest_rate;
        $bank->max_loan = $request->max_loan;
        $bank->min_loan = $request->min_loan;
        $bank->loan_term = $request->loan_term;
        $bank->save();
    }

    public function getBank(string $id): \Illuminate\Http\JsonResponse {
        $bank = Bank::find($id);
        return response()->json([
            'bank' => $bank
        ], 200);
    }

    public function updateBank(Request $request, string $id) {
        $bank = Bank::find($id);
        $bank->name = $request->name;
        $bank->interest_rate = $request->interest_rate;
        $bank->max_loan = $request->max_loan;
        $bank->min_loan = $request->min_loan;
        $bank->loan_term = $request->loan_term;
        $bank->save();
    }

    public function deleteBank(string $id) {
        $bank = Bank::findOrFail($id);
        $bank->delete();
    }
}
