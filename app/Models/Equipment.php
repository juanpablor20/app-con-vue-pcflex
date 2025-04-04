<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    static $rules = [
        'type_equi' => 'required',
        'characteristics' => 'required',
        'serie_equi' => 'required|unique:equipment,serie_equi|regex:/^[0-9]{3,}$/',
    ];

  
    protected $fillable = ['type_equi', 'serie_equi', 'characteristics', 'states'];
  
  
    public function service()
    {
        return $this->belongsTo(Services::class);
    }
}
