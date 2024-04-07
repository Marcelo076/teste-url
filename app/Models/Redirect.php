<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\SoftDeletes;


class Redirect extends Model
{
    protected $table = 'redirects'; 

    protected $fillable = ['url', 'date_create', 'active','date_update'];

    use SoftDeletes;

    protected $deletedAt = 'removed';
    

    public function getCodeAttribute()
    {
        $hashids = new Hashids();
        return $hashids->encode($this->attributes['id']);
    }
}
