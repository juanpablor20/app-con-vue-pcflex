<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user_add',
        'addres_add',
    ];

    public function user()
    {
        return $this->belongsTo(Borrower_users::class, 'id_user_add', 'id');
    }
}

