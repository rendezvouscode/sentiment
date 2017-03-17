<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'tb_training';

    public function pengujian(){
    	return $this->hasOne('App\Pengujian', 'id_tweet');
    }
}
