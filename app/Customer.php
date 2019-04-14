<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'count', 'amount',
    ];
    protected $dates = ['deleted_at'];

    public function accounts()
    {
        return $this->hasMany(Account::class)->withTrashed();
    }
}
