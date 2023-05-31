<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    public $table= 'tenants';
    protected $fillable = ['firstname','lastname','phoneNumber','roomNo','contract','startDate','endDate','amountPaid','currMetreReading','status'];
}
