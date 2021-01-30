<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";
    protected $primaryKey = 'cod';
    protected $fillable = ['cod', 'name'];

    public function clients()
    {
        return $this->hasMany('App\Client','city','cod');
    }
}
