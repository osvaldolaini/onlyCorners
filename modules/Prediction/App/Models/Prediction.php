<?php

namespace Modules\Prediction\App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    protected $table = 'predictions';

    protected $fillable = [
        'status',
        'expired',
        'total_matches',
        'total_odds',
        'total_prob',
        'matches',
        'hash',
        'code',
        'type',
        'updated_by',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];
}
