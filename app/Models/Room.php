<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = "rooms";
    protected $fillable = [
'roomNo',
'metreNo',
'lukuNo',
'roomType',
'amount',
    ];
    use HasFactory;
}
