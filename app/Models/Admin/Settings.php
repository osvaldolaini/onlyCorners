<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Support\Facades\Auth;

class Settings extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'settings';

    protected $fillable = [
        'title',
        'acronym',
        'slug',
        'update_by',
        'logo_path',
        'image',
        'email',
        'phone',
        'cellphone',
        'whatsapp',
        'telegram',
        'cnpj',
        'postalCode',
        'number',
        'address',
        'district',
        'city',
        'state',
        'complement',
        'about',
        'meta_description',
        'meta_tags',
        'video_link'
    ];
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->setUpperCaseAttributes([
                'title',
                'acronym',
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

    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }


    public function setAddress()
    {
        $address = $this->address;
        if ($this->city) {
            $address .= ' - ' . $this->city;
        }
        if ($this->state) {
            $address .= '/' . $this->state;
        }
        if ($this->postalCode) {
            $address .= ' - CEP ' . $this->postalCode;
        }
        return $address;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = mb_strtoupper($value);
        $this->attributes['slug'] = Str::slug($value);
    }
}
