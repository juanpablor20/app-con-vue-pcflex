<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationships extends Model
{
    use HasFactory;
    protected $fillable = ['index_card_id', 'user_rel_id'];

    public function users()
{
    return $this->belongsToMany(Borrower_users::class, 'relationships', 'index_card_id', 'user_rel_id');
}

}
