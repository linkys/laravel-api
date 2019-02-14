<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = ['first_name', 'last_name', 'email'];
    protected $hidden = ['password'];
}
