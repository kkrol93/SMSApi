<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Server extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ip', 'name'
    ];
    protected $dates = ['deleted_at'];
    public function accounts()
    {
        return $this->belongsToMany(Account::class, "account_server");
    }
}
