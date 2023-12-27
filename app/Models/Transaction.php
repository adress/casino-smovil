<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
  protected $fillable = [
    'user_id', 'transaction_type', 'amount', 'balance_after', 'transaction_time'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
