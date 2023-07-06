<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationNotifications extends Model
{
    use HasFactory;
    protected $fillable = ['doctorid','meetingid','status','fromoutside'];
    public $timestamps = false;

}
