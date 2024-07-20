<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    static $rules = [
        'names_pro' => 'required',
         'code_pro' => 'required', 
          'version' => 'required'
        ];

    protected  $fillable = ['names_pro', 'code_pro', 'version'];
    use HasFactory;
}
