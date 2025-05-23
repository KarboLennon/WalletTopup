<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessTransfer;

class TransferController extends Controller
{
    public function transfer(Request $request)
    {
        $request->validate([
            'target_user' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'remarks' => 'nullable|string'
        ]);

        $sender = Auth::user();
        $id = optional($sender)->id;

        if (!$id) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $receiver = User::find($request->target_user);

        if (!$receiver) {
            return response()->json(['message' => 'Target user not found.'], 404);
        }

        if ($sender->id === $receiver->id) {
            return response()->json(['message' => 'Cannot transfer to self.'], 400);
        }

        if ($sender->balance < $request->amount) {
            return response()->json(['message' => 'Balance is not enough'], 400);
        }

        $trx = DB::transaction(function () use ($sender, $receiver, $request) {
            $sender->balance -= $request->amount;
            $receiver->balance += $request->amount;

            $sender->save();
            $receiver->save();

            return Transaction::create([
                'id' => Str::uuid(),
                'from_user_id' => $sender->id,
                'to_user_id' => $receiver->id,
                'amount' => $request->amount,
                'remarks' => $request->remarks,
                'balance_before' => $sender->balance + $request->amount,
                'balance_after' => $sender->balance
            ]);
        });

        return response()->json([
            'status' => 'SUCCESS',
            'result' => [
                'transfer_id' => $trx->id,
                'amount' => $trx->amount,
                'remarks' => $trx->remarks,
                'balance_before' => $trx->balance_before,
                'balance_after' => $trx->balance_after,
                'created_date' => $trx->created_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
ProcessTransfer::dispatch($sender, $receiver, $amount, $remarks);
