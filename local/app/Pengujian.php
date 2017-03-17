<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengujian extends Model
{
    protected $table = 'tb_pengujian';

    protected $primaryKey = 'id_tweet';

    protected $fillable = [
    	'id_tweet',
    	'tweet',
    	'class',
    	'predicted_class',
    	'matriks',
    ];

    public function training(){
    	return $this->belongsTo('App\Training', 'id_tweet');
    }
}
