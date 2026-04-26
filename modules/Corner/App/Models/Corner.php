<?php

namespace Modules\Corner\App\Models;


use App\Traits\HasAttributeConversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


use Illuminate\Support\Str;
use Modules\Championship\App\Models\Championship;
use Modules\Game\App\Models\Game;
use Modules\Team\App\Models\Team;

class Corner extends Model
{

    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'corners';

    protected $fillable = [
        'active',
        'half',
        'game_id',
        'favored_id',
        'min',
        'half',
        'hour',
        'date',
        'championship_id',
        'code',
        'opponent_id',
        'team_id',
        'updated_by',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->setUpperCaseAttributes([

                'updated_by',
                'created_by',
            ]);
        });
        static::creating(function ($transaction) {
            $transaction->created_by = Auth::user()->name;
            $transaction->updated_by = Auth::user()->name;
        });

        static::updating(function ($transaction) {
            $transaction->updated_by = Auth::user()->name;
        });
    }
    public function setUpperCaseAttributes(array $attributes)
    {
        foreach ($attributes as $attribute) {
            if (isset($this->attributes[$attribute])) {
                $this->attributes[$attribute] = mb_strtoupper($this->attributes[$attribute]);
            }
        }
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $this->dbDate($value);
    }
    public function getFDateAttribute()
    {
        return $this->viewDate($this->date);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id', 'id')->where('active', 1);
    }

    public function championship(): BelongsTo
    {
        return $this->belongsTo(Championship::class, 'championship_id', 'id')->where('active', 1);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id')->where('active', 1);
    }
    public function opponent(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'opponent_id', 'id')->where('active', 1);
    }
    public function favored(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'favored_id', 'id')->where('active', 1);
    }

    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }
    public function getCodeImageAttribute()
    {
        // return $this->logo_path;
        if ($this->logo_path) {
            $code = explode('.', $this->logo_path);
            return $code[0];
        }
    }
}
