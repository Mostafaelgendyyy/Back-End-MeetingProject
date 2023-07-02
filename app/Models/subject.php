<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;
    protected $fillable = ['subjectid','controllerid','description','subject_Type','finaldecision','iscompleted','from','attachment-link'];
    public $timestamps = false;

    protected $primaryKey = 'subjectid';

}
