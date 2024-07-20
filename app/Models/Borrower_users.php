<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower_users extends Model
{
    use HasFactory;
    public static $rules = [
      'name' => 'required',
      
    ];

    protected $fillable = 
    [
        'name', 'last_name', 
        'type_identification',
        'number_identification', 
        'sex_user',
         'gender_sex', 
         'roll'
    ];

    public function contacts()
    {
        return $this->hasOne(Contacts::class, 'id_user_con', 'id');
    }

    public function address()
    {
        return $this->hasOne(Addresses::class, 'id_user_add', 'id');
    }

    public function services()
    {
        return $this->hasMany(Services::class, 'user_id');
    }

    public function indexCards()
    {
        return $this->belongsToMany(Index_cards::class, 'relationships', 'user_rel_id', 'index_card_id');
    }
}