<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Resposta extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'respostas'; // nome da collection

    protected $fillable = [
        'nome', 'email', 'brand', 'cur_no', 'bk', 'owner_bk',
        'pk', 'pn', 'status', 'oe', 'case1', 'case2', 'case3',
        'month_from', 'year_from', 'fitment_from',
        'month_until', 'year_until', 'fitment_until',
        'criteria', 'criteria_not', 'comments', 'reason',
        'bu', 'requester', 'date', 'send_date', 'upload_date',
        'upload_time', 'remarks', 'comment_remark',
        'answer_pm', 'answer_mdt'
    ];
}
