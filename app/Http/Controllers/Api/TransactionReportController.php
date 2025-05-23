<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TopUp;
use Illuminate\Support\Facades\Auth;

class TransactionReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil transaksi transfer (DEBIT)
        $transfers = Transaction::where('from_user_id', $user->id)->get()->map(function ($trx) use ($user) {
            return [
                'transfer_id' => $trx->id,
                'status' => 'SUCCESS',
                'user_id' => $user->id,
                'transaction_type' => 'DEBIT',
                'amount' => (int)$trx->amount,
                'remarks' => $trx->remarks,
                'balance_before' => (int)$trx->balance_before,
                'balance_after' => (int)$trx->balance_after,
                'created_date' => $trx->created_at->format('Y-m-d H:i:s'),
            ];
        });

        // Ambil transaksi top up (CREDIT)
        $topups = TopUp::where('user_id', $user->id)->get()->map(function ($top) use ($user) {
            return [
                'top_up_id' => $top->id,
                'status' => 'SUCCESS',
                'user_id' => $user->id,
                'transaction_type' => 'CREDIT',
                'amount' => (int)$top->amount,
                'remarks' => '',
                'balance_before' => (int)$top->balance_before,
                'balance_after' => (int)$top->balance_after,
                'created_date' => $top->created_at->format('Y-m-d H:i:s'),
            ];
        });

        // Gabungin dan sort by waktu
        $result = $transfers->merge($topups)->sortBy('created_date')->values();

        return response()->json([
            'status' => 'SUCCESS',
            'result' => $result
        ]);
    }
}
