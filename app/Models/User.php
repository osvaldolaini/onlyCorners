<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'active',
        'name',
        'email',
        'viewVersion',
        'password',
        'groups',
        'accesses',
        'activities',
        'companies',
        'panel',
        'dark',
        'cpf_cnpj',
        'see_excluded'
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($transaction) {
            $transaction->see_excluded  = 0;
            $transaction->accesses      = ["users"];
            $transaction->activities    = [];
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
    public function hasCommonAccessWith($user)
    {
        return count(
            array_intersect(
                $this->jsonGroups,
                $user->jsonGroups
            )
        ) > 0;
    }
    public function getGroupsOfUser(): array
    {
        return array_map(fn($level) => UserGroups::from($level), $this->jsonGroups);
    }
    // public function getSeeExcludedAttribute()
    // {
    //     if ($this->see_excluded) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    public function getJsonGroupsAttribute()
    {
        return json_decode($this->groups);
    }
    public function getTitleAttribute()
    {
        return $this->name . $this->cpf_cnpj ?? ' (' . $this->cpf_cnpj . ')';
    }
    public function setGroupsAttribute($value)
    {
        $this->attributes['groups'] = json_encode($value);
    }
    public function getJsonAccessesAttribute()
    {
        return json_decode($this->accesses);
    }
    public function setAccessesAttribute($value)
    {
        $this->attributes['accesses'] = json_encode($value);
    }
    public function getJsonActivitiesAttribute()
    {
        return json_decode($this->activities);
    }
    public function setActivitiesAttribute($value)
    {
        $this->attributes['activities'] = json_encode($value);
    }
    public function getPanelIdAttribute()
    {
        switch ($this->panel) {
            case 'admin':
                return 1;
                break;
            case 'user':
                return 2;
                break;
            default:
                return 2;
                break;
        }
        return json_decode($this->accesses);
    }

    public function getRedirectRoute(): string
    {
        return match ((int)$this->panelId) {
            1 => '/admin/dashboard',
            2 => '/aplicativo',
        };
    }
}
