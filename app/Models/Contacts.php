<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user_con',
        'telephone_con',
        'email_con',
    ];

    public function user()
    {
        return $this->belongsTo(Borrower_users::class, 'id_user_con', 'id');
    }
}
