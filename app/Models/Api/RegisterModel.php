<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterModel extends Model
{

    use hasFactory;

    protected $table = 'devices';
    protected $fillable =
        [
            'uid',
            'os',
            'language',
            'token',
        ];

}
