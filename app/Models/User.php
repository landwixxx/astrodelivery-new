<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'profile',
        'phone',
        'status',
        'account_expiration',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function store()
    {
        return $this->hasOne(Store::class, 'lojista_id', 'id');
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function data_customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function store_has_user()
    {
        return $this->hasOne(StoreHasUsers::class);
    }

    public function store_has_customer()
    {
        return $this->hasOne(StoreHasCustomer::class);
    }

    public function banned_customer()
    {
        return $this->hasOne(BannedCustomer::class);
    }

    public function orders_cutomer()
    {
        return $this->hasMany(Order::class);
    }

    public function test_order()
    {
        return $this->hasOne(TestOrder::class);
    }

    public function shopkeeper_token()
    {
        return $this->hasOne(ShopkeeperToken::class, 'id');
    }

    /**
     * Exexplo de retorno: 'em 2 anos 11 meses 4 semanas'
     *
     * @return void
     */
    public function time_account_expiration()
    {
        $time = \Carbon\Carbon::parse($this->account_expiration)->diffForHumans([
            'parts' => 3,
        ]);
        return $time;
    }
}
