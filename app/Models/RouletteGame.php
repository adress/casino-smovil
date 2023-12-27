<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouletteGame extends Model
{
  protected $fillable = [
    'user_id', 'bet_value', 'bet_color', 'win_color', 'is_winner', 'game_time', 'amount'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
