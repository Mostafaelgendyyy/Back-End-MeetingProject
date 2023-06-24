<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subjectCreator extends Model
{
    use HasFactory;
    protected $fillable = ['creatorid','adminid','adminstration','name','email','password','username'];
    public $timestamps = false;
    protected $primaryKey = 'creatorid';
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
