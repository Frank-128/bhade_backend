<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metre extends Model
{
    use HasFactory;
    public $table = 'metre';
    protected $fillable = ['metreNumber','roomNumber','metreReading','tenant_id'];
}
