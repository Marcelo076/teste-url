<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedirectLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'redirect_id',
        'ip',
        'user_agent',
        'referer',
        'query_params',
        'accessed_at',
    ];

    protected $casts = [
        'query_params' => 'array',
        'accessed_at' => 'datetime',
    ];

    // Relacionamento com o model Redirect
    public function redirect()
    {
        return $this->belongsTo(Redirect::class);
    }
}
