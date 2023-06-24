<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class admin extends Model
{
    use HasFactory;
    protected $fillable = ['adminid','name','email','password','username'];
    public $timestamps = false;
    protected $primaryKey = 'adminid';
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
