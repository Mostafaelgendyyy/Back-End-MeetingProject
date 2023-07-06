<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'subjectid','userid','description','subjecttype','iscompleted','attachmentlink'
    ];
    public $timestamps = false;

    protected $primaryKey = 'subjectid';

}
