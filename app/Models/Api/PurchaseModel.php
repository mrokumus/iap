<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseModel extends Model
{
    use HasFactory;
    protected $table = 'purchases';
    protected $fillable =
    [
        'purchaseId',
        'expireDate'
    ];
}
