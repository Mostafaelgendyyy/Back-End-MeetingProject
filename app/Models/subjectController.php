<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subjectController extends Model
{
    use HasFactory;
    protected $fillable = ['controllerid','adminstration','email','password','username','name'];
    public $timestamps = false;
    protected $primaryKey = 'controllerid';
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
