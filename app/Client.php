<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = "client";
    protected $primaryKey = 'cod';
    protected $fillable = ['cod', 'name','city'];

    protected $guarded = []; 
    
    public function city_d()
    {
        return $this->hasOne('App\City','cod','city');
    }
}
