<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id', 'user_id', 'amount', 'balance_before', 'balance_after',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

