<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Desde Laravel 8 en adelante las factories cambiaron
    // Hay que importar el trait HasFactory para poder usar el factory de este modelo
    use HasFactory;
    //

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id',
    ];

    public function user()
    {
        /**
         * One to One Relation
         * A post belongs to an unique user
         */
        return $this->belongsTo(User::class)->select(['id', 'name', 'username', 'email']);
    }
}
