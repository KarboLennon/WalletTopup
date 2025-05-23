<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'uuid';

       protected $fillable = [
       'id',
       'from_user_id',
       'to_user_id',
       'amount',
       'remarks',
       'balance_before',
       'balance_after',
   ];

    public function fromUser() {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser() {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
