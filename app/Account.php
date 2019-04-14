<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'service', 'customer_id', 'signature', '[_token',
    ];
    protected $dates = ['deleted_at'];

    public function customer()
    {

        return $this->belongsTo(Customer::class)->withTrashed();
    }
    public function messages()
    {

        return $this->hasMany(Message::class)->withTrashed();
    }
    public function servers()
    {
        return $this->belongsToMany(Server::class, "account_server");
    }
}
