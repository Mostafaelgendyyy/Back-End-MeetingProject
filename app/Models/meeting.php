<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class meeting extends Model
{
    use HasFactory;
    protected $fillable = ['meetingid','initiatorid','location','date','topic','islast'];
    public $timestamps = false;

    protected $primaryKey = 'meetingid';


}
