<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'subjectid','controllerid','description','subjecttype','finaldecision','iscompleted','from','to','attachmentlink'
    ];
    public $timestamps = false;

    protected $primaryKey = 'subjectid';

}
