<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopUp;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $user = Auth::user();
        $before = $user->balance;
        $after = $before + $request->amount;

        $topup = TopUp::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'amount' => $request->amount,
            'balance_before' => $before,
            'balance_after' => $after
        ]);

        $user->balance = $after;
        $user->save();

        return response()->json([
            'status' => 'SUCCESS',
            'result' => [
                'top_up_id' => $topup->id,
                'amount_top_up' => $topup->amount,
                'balance_before' => $before,
                'balance_after' => $after,
                'created_date' => $topup->created_at->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
