<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class container extends Model
{
    use HasFactory;
    protected $fillable = ['containerid','controllerid','meetingid','name'];

    public $timestamps = false;


}
