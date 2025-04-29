<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Resposta extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'respostas'; // nome da collection

    protected $fillable = [
        'nome',
        'email',
        'mensagem',
    ];
}
