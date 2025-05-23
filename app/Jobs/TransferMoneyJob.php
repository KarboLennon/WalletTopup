<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransferMoneyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function handle()
    {
        DB::transaction(function () {
            $from = User::find($this->transaction->from_user_id);
            $to = User::find($this->transaction->to_user_id);

            if ($from->balance < $this->transaction->amount) {
                $this->transaction->status = 'failed';
                $this->transaction->save();
                return;
            }

            $from->balance -= $this->transaction->amount;
            $to->balance += $this->transaction->amount;
            $from->save();
            $to->save();

            $this->transaction->status = 'success';
            $this->transaction->save();
        });
    }
}

