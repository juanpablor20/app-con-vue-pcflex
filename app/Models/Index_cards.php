<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Index_cards extends Model
{
    static $rules = [
        'number' => ['required', 'numeric', 'unique:index_cards,number'],
        'program_id' => 'required'
    ];


    protected $fillable = ['number', 'program_id'];
    use HasFactory;

   
    public function programs()
    {
        return $this->belongsTo(Programs::class, 'program_id');
    }
    
}
