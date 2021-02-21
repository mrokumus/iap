<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationModel extends Model
{
    use HasFactory;
    protected $table = 'applications';
    protected $fillable =
        [
            'uid',
            'appId',
            'expire-date'
        ];

}
