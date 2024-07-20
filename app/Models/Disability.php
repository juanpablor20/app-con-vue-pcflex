<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
     protected $fillable = ['description', 'punishment_date', 'end_date', 'service_id'];
    use HasFactory;
}
